<?php

namespace App\Admin\Controllers\Log;

use App\Admin\Repositories\Log\LogUserFund;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Controllers\BaseController;

class LogUserFundController extends BaseController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new LogUserFund(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column('uid');
            $sys_user = config('admin.users');
            $grid->column('user_identity')->display(function() use($sys_user){
                $identity = $sys_user['user_identity'][0];
                return $this->user->$identity;
            });
            $grid->column('number');
            $grid->column('coin_type');
            $grid->column('fund_type');
            $grid->column('content')->width("15%");
            $grid->column('remark')->width('10%');
            $grid->column('created_at');

            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableQuickEditButton();
            $grid->disableCreateButton();
            $grid->filter(function (Grid\Filter $filter) use($sys_user){
                $filter->equal('id');
                $filter->equal('uid');
                $identity = $sys_user['user_identity'][0];
                $filter->like('user.' . $identity, '会员标识');
                $filter->equal('coin_type')->select($sys_user['user_funds']);
                $filter->equal('fund_type')->select($sys_user['fund_type']);
                $filter->between('number');
                $filter->between('created_at')->datetime();
            });
        });
    }
}
