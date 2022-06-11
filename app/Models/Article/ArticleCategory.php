<?php

namespace App\Models\Article;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class ArticleCategory extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'article_category';
    protected $guarded = [];

}
