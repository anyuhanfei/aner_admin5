<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SysNotice extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'sys_notice';
    protected $fillable = ['title', 'content', 'image'];

    public static function init(){
        if(self::count() < 1){
            self::create([
                'title'=> '',
                'image'=> '',
                'content'=> '',
            ]);
        }
    }
}
