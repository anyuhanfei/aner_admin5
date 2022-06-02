<?php

namespace App\Admin\Repositories\Article;

use App\Models\Article\ArticleTag as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ArticleTag extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
