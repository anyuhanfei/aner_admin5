<?php

namespace App\Models\Log;

use App\Models\User\Users;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;


class LogUserFund extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'log_user_fund';

    protected $guarded = [];

    public function user(){
        return $this->hasOne(Users::class, 'id', 'uid');
    }

    protected function CoinType(): Attribute{
        $coin_type = config('admin.users.user_funds');
        if(count($coin_type) == 0){
            return Attribute::make(
                get: fn ($value) => '未设置',
            );
        }
        return Attribute::make(
            get: fn ($value) => $coin_type[$value],
        );
    }
}
