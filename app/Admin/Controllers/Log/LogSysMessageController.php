<?php

namespace App\Admin\Controllers\Log;

use App\Admin\Repositories\Log\LogSysMessage;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Controllers\BaseController;
use App\Models\User\Users;
use Illuminate\Support\Facades\Cache;

class LogSysMessageController extends BaseController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new LogSysMessage(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('uid');
            $sys_user = config('project.users');
            $grid->column('user_identity')->display(function() use($sys_user){
                if($this->uid == 0){
                    return "所有会员";
                }
                $identity = $sys_user['user_identity'][0];
                return $this->user->$identity;
            });
            $grid->column('title');
            config('project.sys_message.image_show') ? $grid->column('image')->image('', 40, 40) : '';
            config('project.sys_message.content_show') ? '' : $grid->disableViewButton();
            $grid->column('created_at');
            $grid->filter(function (Grid\Filter $filter) use($sys_user) {
                $filter->equal('id');
                $filter->equal('uid');
                $identity = $sys_user['user_identity'][0];
                $filter->like('user.' . $identity, '会员标识');
                $filter->like('title');
                $filter->between('created_at')->datetime();
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
        return Show::make($id, new LogSysMessage(), function (Show $show) {
            $show->field('id');
            $show->field('uid');
            $show->field('title');
            $show->field('image');
            $show->field('content');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new LogSysMessage(), function (Form $form) {
            $form->display('id');
            $form->select('uid')->options(Users::all()->pluck('nickname', 'id'))->help('不选择表示所有会员');
            $form->text('title')->required();
            config('project.sys_message.image_show') ? $form->image('image')->autoUpload()->required() : '';
            if(config('project.sys_message.content_show')){
                $form->editor('content')->height('600')->disk(config('project.upload_disk'))->required();
            }else{
                $form->hidden('content');
            }
            $form->saving(function (Form $form) {
                $form->content = $form->content ?? '';
                $form->uid = $form->uid ?? 0;
            });
            $form->saved(function(Form $form, $result){
                if($form->model()->uid == 0){
                    Cache::tags(["sys_message"])->flush();
                }else{
                    Cache::tags(["sys_message:{$form->model()->uid}"])->flush();
                }
            });
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
            $form->disableDeleteButton();
        });
    }
}
