<?php

namespace App\Admin\Actions\User;

use Encore\Admin\Actions\Action;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;

class CloneWorkPlan extends RowAction
{

    public $name = 'Clone workplan';

    public function handle(Request $request)
    {
        return $this->response()->success('Success message...')->refresh(); 
    }

   
}