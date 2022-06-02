<?php

namespace App\Admin\Repositories\Article;

use App\Models\Article\Article as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Article extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
