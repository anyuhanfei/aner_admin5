<?php

namespace App\Admin\Controllers\Sys;

use App\Admin\Repositories\Sys\SysSetting;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Controllers\BaseController;
use Dcat\Admin\Widgets\Tab;
use App\Models\Sys\SysSetting as SysSettingModel;
use Illuminate\Support\Facades\Redis;

class SysSettingController extends BaseController{

    protected function grid(){
        return Grid::make(new SysSetting(), function (Grid $grid) {
            $grid->wrap(function(){
                $tab = Tab::make();
                foreach (SysSettingModel::where('parent_id', 0)->get() as $value) {
                    $tab->add($value->title, $this->tab($value->id));
                }
                return $tab;
            });
        });
    }

    private function tab($id){
        return Grid::make(SysSettingModel::where('parent_id', $id), function (Grid $grid) {
            $grid->column('id')->sortable()->width('10%');
            $grid->column('title');
            $grid->column('value')->editable()->width("40%");
            if(config('admin.setting.line_button_show') == false){
                $grid->disableViewButton();
                $grid->disableEditButton();
                $grid->disableDeleteButton();
                $grid->disableQuickEditButton();
                $grid->disableToolbar();
            }
            $grid->disableRowSelector();
            $grid->withBorder();
            $grid->disableRefreshButton();
            $grid->disableFilterButton();
            $grid->disablePagination();
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
        return Show::make($id, new SysSetting(), function (Show $show) {
            $show->field('id');
            $show->field('parent_id');
            $show->field('title');
            $show->field('input_type');
            $show->field('value');
            $show->field('remark');
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
        return Form::make(new SysSetting(), function (Form $form) {
            $form->hidden('value');
            $form->input('remark', $form->model()->remark);

            $form->display('id');
            $form->select('parent_id')->options(SysSettingModel::where('parent_id', 0)->get()->pluck('title', 'id'));
            $form->text('title');
            # ['text'=> '普通字符', 'select'=> '下拉选项', 'redio'=> '单选项', 'onoff'=> '开关']
            $form->select('input_type')->options(['text'=> '普通字符']);
            // $form->text('remark')->help('仅在select、redio类型的表单中有效，每个选项以空格隔开');
            $form->footer(function ($footer) {
                $footer->disableViewCheck();
            });
            $form->saving(function (Form $form) {
                if($form->isCreating()){
                    $form->value = $form->value ?? '';
                    $form->parent_id = $form->parent_id ?? 0;
                }
            });
            $form->saved(function(Form $form, $result){
                Redis::set("setting:{$form->model()->id}", $form->model()->value);
            });
            $form->disableResetButton();
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
        });
    }
}
