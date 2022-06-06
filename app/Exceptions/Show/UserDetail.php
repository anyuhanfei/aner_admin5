<?php
namespace App\Admin\Extensions\Show;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Show\AbstractField;
use App\Models\Log\LogUserOperation;

class UserDetail extends AbstractField
{
    // 这个属性设置为false则不会转义HTML代码
    public $escape = false;

    public function render($arg = '')
    {
        return unserialize($this->value);
    }
}