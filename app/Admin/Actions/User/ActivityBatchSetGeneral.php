<?php

namespace App\Admin\Actions\User;

use App\Models\Department;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class ActivityBatchSetGeneral extends BatchAction
{
    public $name = 'Set as General Activities';

    public function handle(Collection $collection, Request $r)
    {
        $i = 0;
        foreach ($collection as $model) {
            $model->type = 'General';
            //$model->failed_reason = $r->get('failed_reason');
            $model->role = null;
            $model->department_id = null; 
            $i++;
            $model->save();
        }
        return $this->response()->success("Updated $i Successfully.")->refresh();
    }

    /* 
    public function form()
    {
        $this->textarea('failed_reason', __('Enter reason for failure'))
            ->required()
            ->rules('required');
    } */
}
 