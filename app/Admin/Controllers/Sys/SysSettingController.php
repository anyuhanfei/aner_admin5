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
                foreach ((new SysSetting())->get_parent_list() as $key=> $value) {
                    $tab->add($value, $this->tab($key));
                }
                return $tab;
            });
        });
    }

    private function tab($id){
        return Grid::make(SysSettingModel::where('parent_id', $id), function (Grid $grid) {
            $grid->column('id')->sortable()->width('10%');
            $grid->column('title')->width("20%");
            $grid->column('value')->textarea()->width("50%")->setAttributes(['style'=> 'word-break:break-all;']);
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
            $form->select('parent_id')->options((new SysSetting())->get_parent_list());
            $form->text('title');
            # ['text'=> '????????????', 'select'=> '????????????', 'redio'=> '?????????', 'onoff'=> '??????']
            $form->select('input_type')->options(['text'=> '????????????']);
            // $form->text('remark')->help('??????select???redio??????????????????????????????????????????????????????');
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
                (new SysSetting())->del_cache_data($form->id);
            });
            $form->disableResetButton();
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
        });
    }
}
