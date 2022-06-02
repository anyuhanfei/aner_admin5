<?php

namespace App\Admin\Repositories\Log;

use App\Models\Log\LogSysMessage as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class LogSysMessage extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
