<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class SysBanner extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'sys_banner';
    protected $guarded = [];
}
