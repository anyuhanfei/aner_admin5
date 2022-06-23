<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Controllers\BaseController;
use App\Admin\Repositories\Article\Article;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\Article\ArticleCategory;
use App\Models\Article\ArticleTag;


class ArticleController extends BaseController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(){
        return Grid::make(new Article(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            config('admin.article.image_show') ? $grid->column('image')->image('', 40, 40) : '';
            if(config('admin.article.tag_show')){
                $grid->column('tag_ids')->display(function(){
                    $tag = ArticleTag::whereIn('id', json_decode($this->tag_ids))->get();
                    $str = '';
                    foreach ($tag as $value) {
                        $str .= $value->name . ' ';
                    }
                    return $str;
                })->limit(30, '...');
            }
            $grid->column('category_id')->display(function(){
                return ArticleCategory::where('id', $this->category_id)->value('name');
            });
            config('admin.article.author_show') ? $grid->column('author') : '';
            config('admin.article.intro_show') ? $grid->column('intro')->limit(30, '...') : '';
            config('admin.article.keyword_show') ? $grid->column('keyword')->limit(30, '...') : '';
            $grid->column('created_at');
            // $grid->disableViewButton();  # 隐藏展示按钮
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('title');
                $filter->equal('category_id')->select(ArticleCategory::all()->pluck('name', 'id'));
                // $filter->in('tag_ids')->multipleSelect(ArticleTag::all()->pluck('name', 'id'));
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
        return Show::make($id, new Article(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('author');
            $show->field('image')->image();
            $show->field('tag_ids')->as(function(){
                $tag = ArticleTag::whereIn('id', json_decode($this->tag_ids))->get();
                $str = '';
                foreach ($tag as $value) {
                    $str .= $value->name . ' ';
                }
                return $str;
            });
            $show->field('category_id')->as(function(){
                return ArticleCategory::where('id', $this->category_id)->value('name');
            });;
            
            $show->field('intro');
            $show->field('keyword');
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
        return Form::make(new Article(), function (Form $form) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });
            $form->display('id');
            $form->text('title');
            $form->text('author');
            $form->checkbox('tag_ids')->options(ArticleTag::all()->pluck('name', 'id'))->saving(function ($value) {
                return json_encode($value);
            });
            $form->select('category_id')->options(ArticleCategory::all()->pluck('name', 'id'));
            config('admin.article.image_show') ? $form->image('image')->autoUpload() : '';
            $form->textarea('intro')->rows(3);
            $form->text('keyword');
            $form->editor('content')->height('600')->disk(config('admin.upload_disk'));

            $form->footer(function ($footer) {
                $footer->disableViewCheck();
            });
        });

    }
}
