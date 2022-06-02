<?php

namespace App\Admin\Controllers;


use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\User\Users as UsersModel;
use App\Models\User\UserFunds;
use App\Models\User\UserDetail;

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
            $grid->column('id')->sortable();
            $this->sys['users']['avatar_show'] ? $grid->column('avatar')->image('avatar', 40, 40) : '';
            $this->sys['users']['nickname_show'] ? $grid->column('nickname') : '';
            foreach ($this->sys['users']['user_identity'] as $field) {
                $grid->column($field);
            }
            $sys_user = $this->sys['users'];
            $grid->colum('资金')->display(function() use($sys_user){
                $str = '';
                foreach ($sys_user['user_funds'] as $key => $value) {
                    $str .= $value . ': ' . $this->funds->$key . '<br/>';
                }
                return $str;
            });
            $grid->column('parent_id', '上级ID');
            $grid->column('parent.phone', '上级标识')->display(function() use($sys_user){
                if($this->parent_id == 0){
                    return "";
                }
                $identity = $sys_user['user_identity'][0];
                return $this->parent->$identity;
            });
            $grid->column('is_login')->switch();
            $grid->column('created_at');
            $grid->filter(function (Grid\Filter $filter) use($sys_user){
                $filter->equal('id');
                $filter->like('nickname');
                $identity = $sys_user['user_identity'][0];
                $filter->like($identity, '会员标识');
                $filter->like('parent_id', '上级会员ID');
                $filter->like('parent.' . $identity, '上级会员标识');
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
        return Show::make($id, new User(), function (Show $show) {
            $show->row(function (Show\Row $show) {
                $show->width(3)->id;
                foreach ($this->sys['users']['user_identity'] as $field) {
                    $show->width(4)->$field;
                }
            });
            $show->row(function (Show\Row $show) {
                $show->width(3)->avatar->image('', 40, 40);
                $show->width(4)->nickname;
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
                $this->sys['users']['avatar_show'] ? $form->image('avatar')->autoUpload()->required() : '';
                foreach ($this->sys['users']['user_identity'] as $field) {
                    $form->text($field)->required();
                }
                $this->sys['users']['avatar_show'] ? $form->text('nickname')->required() : '';
                $form->text('password')->required();
                if($this->sys['users']['avatar_show']){
                    $form->text('level_password')->required();
                }
                if($this->sys['users']['parent_show']){
                    $form->select('parent_id')->options(UsersModel::all()->pluck('nickname', 'id'));
                }
                //将输入的密码加密
                $form->saving(function (Form $form) {
                    [$form->password, $form->password_salt] = UsersModel::admin_set_password($form->password);
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
                    $this->sys['users']['avatar_show'] ? $form->image('avatar')->autoUpload() : '';
                    foreach ($this->sys['users']['user_identity'] as $field) {
                        $form->text($field);
                    }
                    $this->sys['users']['avatar_show'] ? $form->text('nickname') : '';
                });
                $form->tab('密码', function(Form $form){
                    $form->text('password')->customFormat(function(){
                        return '';
                    })->help('不填写则不修改');
                    if($this->sys['users']['avatar_show']){
                        $form->text('level_password')->customFormat(function(){
                            return '';
                        })->help('不填写则不修改');
                    }
                });
                $form->tab('资产', function(Form $form){
                    $user_funds = $this->sys['users']['user_funds'];
                    foreach ($user_funds as $key => $value) {
                        $form->number('funds.' . $key, $value);
                    }
                });
                //判断是否填写了密码，并加密
                $form->saving(function (Form $form) {
                    if($form->password == null){
                        $form->deleteInput('password');
                    }else{
                        [$form->password, $form->password_salt] = UsersModel::admin_set_password($form->password);
                    }
                    if($form->level_password == null){
                        $form->deleteInput('level_password');
                    }
                });
            }
            $form->hidden('is_login');
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
        });
    }
}
