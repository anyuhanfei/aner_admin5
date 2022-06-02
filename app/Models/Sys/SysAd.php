<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SysAd extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use ModelTree;

    protected $table = 'sys_ad';
    protected $titleColumn = 'title';
    protected $parentColumn = 'parent_id';

    public function getOrderColumn(){
        return null;
    }
}
