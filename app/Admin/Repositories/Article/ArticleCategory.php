<?php

namespace App\Admin\Repositories\Article;

use App\Models\Article\ArticleCategory as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ArticleCategory extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
