<?php

namespace App\Admin\Actions\User;

use App\Models\Department;
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
        $this->select('role', __('Select Role'))
            ->options([
                'Ministry' => 'Ministry level',
                'District' => 'District level',
                'Subcounty' => 'Subcounty level',
            ])
            ->rules('required');
    }
}
