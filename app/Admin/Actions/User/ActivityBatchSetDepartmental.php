<?php

namespace App\Admin\Actions\User;

use App\Models\Department;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

  
class ActivityBatchSetDepartmental extends BatchAction
{
    public $name = 'Set as Departmental Activities';

    public function handle(Collection $collection, Request $r)
    {
        $i = 0;
        foreach ($collection as $model) {
            $model->type = 'Departmental';
            $model->role = null;
            $model->department_id = $r->get('department_id');
            $i++;
            $model->save();
        }
        return $this->response()->success("Updated $i Successfully.")->refresh();
    }


    public function form()
    {
        $this->select('department_id', __('Select Department'))
            ->options(Department::where([])->orderBy('department', 'asc')->get()->pluck('department', 'id'))
            ->rules('required');
    }
}
