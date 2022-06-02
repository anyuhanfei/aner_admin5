<?php

namespace App\Admin\Repositories\Log;

use App\Models\Log\LogUserFund as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class LogUserFund extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
