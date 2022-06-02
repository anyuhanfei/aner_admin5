<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SysBanner extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'sys_banner';
    
}
