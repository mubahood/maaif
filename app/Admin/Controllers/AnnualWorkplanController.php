<?php

namespace App\Admin\Controllers;

use App\Models\AnnualWorkplan;
use App\Models\Department;
use App\Models\District;
use App\Models\FinancialYear;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AnnualWorkplanController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Annual Workplans';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
  
        $u = Admin::user();
        $grid = new Grid(new AnnualWorkplan());
        $grid->disableBatchActions();
        $grid->model()->orderBy('id', 'desc');

        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->disableActions();

        if ($u->can('ministry')) {
        } else if ($u->can('district')) {
            $grid->disableActions();
            $grid->model()->where('district_id', $u->district_id);
        } else if ($u->can('subcounty')) {
            $grid->model()->where('user_id', $u->user_id);
            $grid->disableExport();
        } else {
            $grid->model()->where('department_id', $u->department_id);
        }




        $grid->column('id', __('ID'))->sortable();
        $grid->column('year', __('Year'))->sortable();
        $grid->column('department_id', __('Department'))
            ->display(function () {
                return $this->department->department;
            })
            ->sortable();
        $grid->column('district_id', __('District'))
            ->display(function () {
                return $this->district->name;
            })
            ->sortable();
        $grid->column('outputs', __('Annual outputs'))
            ->display(function () {
                return number_format(count($this->annual_outputs));
            })
            ->sortable();
        $grid->column('description', __('Description'))->hide();

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
        $show = new Show(AnnualWorkplan::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('district_id', __('District id'));
        $show->field('department_id', __('Department id'));
        $show->field('year', __('Year'));
        $show->field('description', __('Description'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AnnualWorkplan());
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->disableReset();
        $form->disableEditingCheck();
        $u = Admin::user();
        $year = Utils::data_entry_year();
        if ($year == null) {
            die("data entry year not found.");
        }
        $ajax_url = url(
            '/api/ajax?'
                . "search_by_1=name"
                . "&search_by_2=id"
                . "&model=District"
        );

        $form->select('district_id', "Select district")
            ->options(
                District::all()->pluck('name', 'id')
            )
            ->readOnly()
            ->rules('required')
            ->default($u->district_id);


        $form->select('department_id', "Select department")
            ->options(Department::where([])->orderBy('department', 'Asc')
                ->get()
                ->pluck('department', 'id'))
            ->rules('required')
            ->readOnly()
            ->default($u->department_id);
        $form->select('year', __('Year'))->options(FinancialYear::where(['data_entry' => 1])->get()->pluck('name', 'name'))
            ->default($year->name)
            ->readOnly()
            ->rules('required');
        $form->textarea('description', __('Description'));

        return $form;
    }
}
