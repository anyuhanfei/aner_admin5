<?php

namespace App\Admin\Controllers\Sys;

use App\Admin\Repositories\Sys\SysNotice;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Controllers\BaseController;
use App\Models\Sys\SysNotice as SysNoticeModel;

class SysNoticeController extends BaseController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SysNotice(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            switch(config('admin.notice.type')) {
                case '单条富文本':
                    SysNoticeModel::init();
                    $grid->column('title');
                    $grid->disableDeleteButton();
                    $grid->disableCreateButton();
                    break;
                case '多条富文本':
                    $grid->column('id')->sortable();
                    $grid->column('title');
                    break;
                default:
                    SysNoticeModel::init();
                    $grid->column('id')->sortable();
                    $grid->column('title');
                    $grid->disableViewButton();
                    $grid->disableDeleteButton();
                    $grid->disableCreateButton();
                    break;
            }
            config('admin.notice.image_show') ? $grid->column('image')->image('', 40, 40) : '';
            $grid->column('created_at');
            $grid->disableRowSelector();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
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
        return Show::make($id, new SysNotice(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('content')->unescape();
            $show->field('image')->image();
            $show->field('created_at');
            $show->field('updated_at');
            $show->panel()->tools(function ($tools) {
                $tools->disableDelete();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SysNotice(), function (Form $form) {
            $form->display('id');
            config('admin.notice.image_show') ? $form->image('image')->autoUpload()->uniqueName()->saveFullUrl()->required() : '';
            $form->text('title')->required();
            switch(config('admin.notice.type')) {
                case '单条富文本':
                    $form->editor('content')->height('600')->disk(config('admin.upload_disk'))->required();
                    break;
                case '多条富文本':
                    $form->editor('content')->height('600')->disk(config('admin.upload_disk'))->required();
                    break;
                default:
                    $form->hidden('content');
                    break;
            }
            $form->saving(function (Form $form) {
                $form->content = $form->content ?? '';
            });
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
            $form->disableDeleteButton();
        });
    }
}
