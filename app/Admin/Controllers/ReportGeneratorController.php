<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use App\Models\FinancialYear;
use App\Models\ReportGenerator;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class ReportGeneratorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Report Generator';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ReportGenerator());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('Created'));
        $grid->column('user_id', __('Generated by'));
        $grid->column('type', __('Type'));
        /*         $grid->column('generated', __('Generated'));
        $grid->column('departments', __('Departments'));
        $grid->column('districts', __('Districts'));
        $grid->column('users', __('Users')); */

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
        $show = new Show(ReportGenerator::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('user_id', __('User id'));
        $show->field('type', __('Type'));
        $show->field('generated', __('Generated'));
        $show->field('departments', __('Departments'));
        $show->field('districts', __('Districts'));
        $show->field('users', __('Users'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ReportGenerator());

        $u = Admin::user();
        $form->hidden('user_id', __('User id'))->default($u->id);
        $years = FinancialYear::where([])->orderBy('id', 'desc')->get()->pluck('name', 'id');

        $form->select('year_id', __('Report'))->options($years)->rules('required');
        $form->radio('type', __('Report'))->options([
            'District' => 'District',
            'Departmental' => 'Departmental',
            'Extension officers' => 'Extension officers',
        ])
            ->when('Extension officers', function ($f) {
                $f->radio('for_all_members', __('Members'))
                    ->options([
                        'All' => 'All my members',
                        'Specific' => 'Specific members',
                    ])
                    ->when('Specific', function ($f) {
                        $u = Admin::user();
                        $users = User::where([
                            'district_id' => $u->district_id,
                            'department_id' => $u->department_id,
                        ])->get()->pluck('name', 'id');
                        $f->multipleSelect('users', __('Select Members'))
                            ->options($users)
                            ->rules('required');
                    })
                    ->rules('required');
            })
            ->when('Departmental', function ($f) {
                $f->select('departments', __('Select Department'))
                    ->options(Department::where([])->orderBy('department', 'asc')->get()->pluck('department', 'id'))
                    ->rules('required');
            })->rules('required');

        if ($form->isCreating()) {
            $form->hidden('generated', __('Generated'))->value('No')->default('No');
        } else {
            $form->radio('generated', __('Re-Generat Reports'))
                ->options([
                    'Yes' => 'No',
                    'No' => 'Yes',
                ])
                ->default('No');
        }

        $form->textarea('districts', __('Districts'));
        return $form;
    }
}
