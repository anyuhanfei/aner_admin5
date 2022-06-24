<?php

namespace App\Admin\Controllers\Sys;

use App\Admin\Repositories\Sys\SysAd;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Controllers\BaseController;
use App\Models\Sys\SysAd as SysAdModel;
use Illuminate\Support\Facades\Redis;
use Dcat\Admin\Widgets\Card;

class SysAdController extends BaseController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SysAd(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->title->tree(true, false)->width('30%')->setAttributes(['style'=> 'word-break:break-all;']);
            $grid->column('image')->image('', 60, 60)->width('10%');
            $grid->column('value')->width('30%')->setAttributes(['style'=> 'word-break:break-all;']);
            $grid->column('content')->width('10%')->display('')->modal(function ($modal) {
                $modal->title($this->title);
                $this->content == null ? $modal->icon('feather ') : $modal->icon('feather icon-eye');
                $card = new Card(null, $this->content);
                return "<div style='padding:10px 10px 0'>$card</div>";
            });
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->disableRowSelector();
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
        return Show::make($id, new SysAd(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('parent_id')->as(function(){
                $sys_ad = SysAdModel::where('id', $this->parent_id)->first();
                return $sys_ad ? $sys_ad->title : '';
            });
            $show->field('image')->image();
            $show->field('value');
            $show->field('content')->unescape();
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
        return Form::make(new SysAd(), function (Form $form) {
            $form->display('id');
            $form->text('title')->required();
            $form->select('parent_id')
                ->when('!=', '', function(Form $form){
                    $form->html('<span class="help-block"><i class="fa feather icon-help-circle"></i>&nbsp;请至少填写/上传以下三项中的一项</span>');
                    $form->text('value');
                    $form->image('image')->autoUpload()->uniqueName()->saveFullUrl();
                    $form->editor('content')->height('600')->disk(config('admin.upload_disk'));
                })
                ->options(SysAdModel::where('parent_id', 0)->get()->pluck('title', 'id'))
                ->help('如果添加的是广告位，则不要选择广告位');
            $form->footer(function ($footer) {
                $footer->disableViewCheck();
            });
            $form->saving(function (Form $form) {
                $form->parent_id = $form->parent_id ?? 0;
                if($form->parent_id != 0){
                    $value = $form->value;
                    $image = $form->image;
                    $content = $form->content;
                    if($value == '' && $image == '' && $content == ''){
                        return $form->response()->error('值、图片、内容请至少填写一项');
                    }
                }
            });
            $form->saved(function(Form $form, $result){
                Redis::del("ad");
            });
        });
    }
}
