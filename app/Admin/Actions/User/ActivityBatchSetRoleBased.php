<?php

namespace App\Admin\Actions\User;

use App\Models\Department;
use App\Models\Position;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class ActivityBatchSetRoleBased extends BatchAction
{
    public $name = 'Set as Role Based Activities';

    public function handle(Collection $collection, Request $r)
    {
        $i = 0;
        foreach ($collection as $model) {
            $model->type = 'Role';
            $model->department_id = null;
            $model->role = $r->get('role');
            $i++;
            $model->save();
        }
        return $this->response()->success("Updated $i Successfully.")->refresh();
    }


    public function form()
    {
        $pos = [];
        foreach (Position::where([])->orderBy('name', 'asc')->get() as $key => $p) {
            $pos[$p->id] = $p->category . " - " . $p->name;
        }
        $this->select('role', __('Select Position'))
            ->options($pos)
            ->rules('required');
    }
}
