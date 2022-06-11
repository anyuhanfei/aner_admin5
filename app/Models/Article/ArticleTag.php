<?php

namespace App\Models\Article;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class ArticleTag extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'article_tag';
    protected $guarded = [];

}
