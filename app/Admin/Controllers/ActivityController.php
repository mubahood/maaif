<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\User\ActivityBatchSetDepartmental;
use App\Admin\Actions\User\ActivityBatchSetGeneral;
use App\Admin\Actions\User\ActivityBatchSetRoleBased;
use App\Models\Activity;
use App\Models\Department;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Activities';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Activity());
        //$grid->disableBatchActions();
        $grid->batchActions(function ($batch) {
            $batch->add(new ActivityBatchSetGeneral());
            $batch->add(new ActivityBatchSetDepartmental());
            $batch->add(new ActivityBatchSetRoleBased());
            $batch->disabledelete();
        });
        $grid->quickSearch('name')->placeholder('Search by name...');


        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('type', __('Type'))->label()->sortable();
        $grid->column('department_id', __('Department'))->display(function ($x) {
            if ($this->department == null) {
                return '-';
            }
            return $this->department->department;
        })->sortable();
        $grid->column('role', __('Department'))->display(function ($x) {
            if ($this->role == null) {
                return '-';
            }
            return $this->role;
        })->sortable();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Activity::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('category', __('Category'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Activity());
        $form->disableReset();
        $form->disableViewCheck();
        $form->disableCreatingCheck();

        $form->text('name', __('Activity Name'))->rules('required');
        $form->hidden('category', __('Category'))->default(1);
        $form->radio('type', 'Activity Name')->options([
            'General' => 'General activity',
            'Departmental' => 'Department based activity',
            'Role' => 'Role based activity'
        ])
            ->when('Departmental', function ($f) {
                $f->select('department_id', __('Select Department'))
                    ->options(Department::where([])->orderBy('department', 'asc')->get()->pluck('department', 'id'))
                    ->rules('required');
            })
            ->when('Role', function ($f) {
                $f->select('role', __('Select role access level'))
                    ->options([
                        'Ministry' => 'Ministry level',
                        'District' => 'District level',
                        'Subcounty' => 'Subcounty level',
                    ])
                    ->rules('required');
            })
            ->rules('required');
        return $form;
    }
}
