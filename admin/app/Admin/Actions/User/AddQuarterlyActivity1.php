<?php

namespace App\Admin\Actions\CaseModel;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class AddQuarterlyActivity1 extends RowAction
{
    public $name = 'Add suspect';

    public function handle(Model $model)
    {
        return $this->response()->redirect("/case-suspects/create?case_id={$model->id}");
    }
}
