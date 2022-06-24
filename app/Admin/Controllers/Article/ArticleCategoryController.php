<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Controllers\BaseController;
use App\Admin\Repositories\Article\ArticleCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;


class ArticleCategoryController extends BaseController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(){
        return Grid::make(new ArticleCategory(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            config('admin.article.category_image_show') ? $grid->column('image')->image('', 40, 40) : '';

            $grid->disableViewButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(){
        return Form::make(new ArticleCategory(), function (Form $form) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });

            $form->display('id');
            $form->text('name')->required();
            config('admin.article.category_image_show') ? $form->image('image')->autoUpload()->uniqueName()->saveFullUrl()->required() : '';

            $form->footer(function ($footer) {
                $footer->disableViewCheck();
            });
        });
    }
}
