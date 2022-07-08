<?php

namespace App\Admin\Controllers;


use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\User\UserFunds;
use App\Models\User\UserDetail;
use App\Models\Log\LogUserOperation;
use App\Models\Log\LogUserFund;

class UserController extends BaseController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            config('admin.users.avatar_show') ? $grid->column('avatar')->image('', 40, 40) : '';
            config('admin.users.nickname_show') ? $grid->column('nickname') : '';
            foreach(config('admin.users.user_identity') as $field){
                $grid->column($field);
            }
            $sys_user = config('admin.users');
            if(count($sys_user['user_funds']) > 0){
                $grid->colum('资金')->display(function() use($sys_user){
                    $str = '';
                    foreach ($sys_user['user_funds'] as $key => $value) {
                        $str .= $value . ': ' . $this->funds->$key . '<br/>';
                    }
                    return $str;
                });
            }
            if($sys_user['parent_show']){
                $grid->column('parent_id', '上级ID');
                $grid->column('parent.phone', '上级标识')->display(function() use($sys_user){
                    if($this->parent_id == 0){
                        return "";
                    }
                    $identity = $sys_user['user_identity'][0];
                    return $this->parent->$identity;
                });
            }
            $grid->column('is_login')->switch()->help('如果关闭则此会员无法登录');
            $grid->column('created_at');
            $grid->filter(function (Grid\Filter $filter) use($sys_user){
                $filter->equal('id');
                $filter->like('nickname');
                $identity = $sys_user['user_identity'][0];
                $filter->like($identity, '会员标识');
                if($sys_user['parent_show']){
                    $filter->like('parent_id', '上级会员ID');
                    $filter->like('parent.' . $identity, '上级会员标识');
                }
                $filter->equal('is_login')->select(['0'=> '冻结', '1'=> '正常']);
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new User(['log_operation', 'detail']), function (Show $show) use($id){
            $show->row(function (Show\Row $show) {
                $show->width(5)->id;
                $show->width(4)->avatar->image('', 40, 40);
            });
            $show->row(function (Show\Row $show) {
                foreach (config('admin.users.user_identity') as $field) {
                    $show->width(5)->$field;
                }
                $show->width(4)->nickname;
            });

            $show->row(function (Show\Row $show) {
                $show->width(6)->field('detail.id_card_username', '真实姓名');
                $show->width(6)->field('detail.id_card_code', '身份证号');
            });
            $show->relation('会员操作记录', function ($model) {
                $grid = new Grid(new LogUserOperation);
                $grid->model()->where('uid', $model->id);
                $grid->id()->width('15%');
                $grid->content('操作')->width('40%');
                $grid->ip()->width('15%');;
                $grid->created_at();
                $grid->disableRefreshButton();
                $grid->disableFilterButton();
                $grid->disableCreateButton();
                $grid->disableRowSelector();
                $grid->disableActions();
                return $grid;
            });
            $show->relation('会员资产记录', function ($model) {
                $grid = new Grid(new LogUserFund);
                $grid->model()->where('uid', $model->id);
                $grid->id()->width("10%");
                $grid->column('number', '金额')->width("10%");
                $grid->column('coin_type', '资金类型')->width("10%");
                $grid->column('fund_type', '操作类型')->width("10%");
                $grid->column('content', '详细说明')->width("20%");
                $grid->column('remark', '备注')->width('15%');
                $grid->column('created_at');
                $grid->disableRefreshButton();
                $grid->disableFilterButton();
                $grid->disableCreateButton();
                $grid->disableRowSelector();
                $grid->disableActions();
                return $grid;
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(){
        return Form::make(User::with('funds'), function (Form $form) {
            $form->hidden('password_salt');
            if($form->isCreating()){
                config('admin.users.avatar_show') ? $form->image('avatar')->autoUpload()->uniqueName()->saveFullUrl()->required() : '';
                foreach(config('admin.users.user_identity') as $field){
                    $form->text($field)->required();
                }
                config('admin.users.nickname_show') ? $form->text('nickname')->required() : '';
                $form->text('password')->required();
                if(config('admin.users.level_password_show')){
                    $form->text('level_password')->required();
                }
                if(config('admin.users.parent_show')){
                    $form->select('parent_id', '选择上级')->options((new User())->get_parent_list());
                }
                //将输入的密码加密
                $form->saving(function (Form $form) {
                    $form->password = password_hash($form->password, PASSWORD_DEFAULT);
                    $form->parent_id = $form->parent_id ?? 0;
                });
                // 同步创建资产表与详情表
                $form->saved(function (Form $form, $result) {
                    UserFunds::create_data($result);
                    UserDetail::create_data($result);
                });
            }else{
                $form->tab('基本信息', function(Form $form){
                    $form->display('id');
                    config('admin.users.avatar_show') ? $form->image('avatar')->autoUpload()->uniqueName()->saveFullUrl() : '';
                    foreach(config('admin.users.user_identity') as $field){
                        $form->text($field);
                    }
                    config('admin.users.nickname_show') ? $form->text('nickname') : '';
                });
                $form->tab('密码', function(Form $form){
                    $form->text('password')->customFormat(function(){
                        return '';
                    })->help('不填写则不修改');
                    if(config('admin.users.level_password_show')){
                        $form->text('level_password')->customFormat(function(){
                            return '';
                        })->help('不填写则不修改');
                    }
                });
                if(count(config('admin.users.user_funds')) > 0){
                    $form->tab('资产', function(Form $form){
                        $user_funds = config('admin.users.user_funds');
                        foreach ($user_funds as $key => $value) {
                            $form->number('funds.' . $key, $value);
                        }
                    });
                }
                //判断是否填写了密码，并加密
                $form->saving(function (Form $form) {
                    $form->avatar = $form->avatar ?? '';
                    if($form->password == null){
                        $form->deleteInput('password');
                    }else{
                        $form->password = password_hash($form->password, PASSWORD_DEFAULT);
                    }
                    if($form->level_password == null){
                        $form->deleteInput('level_password');
                    }
                });
                $form->saved(function(Form $form, $result){
                    (new \App\Api\Repositories\User\UsersRepositories())->delete_cache($form->model()->id);
                });
            }
            $form->hidden('is_login');
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
        });
    }
}
