<?php

namespace App\Admin\Controllers;

use App\Models\AnnualWorkplan;
use App\Models\Department;
use App\Models\District;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReportAnnualWorkplanController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Annual Workplans - Reports';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AnnualWorkplan());
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableActions();

        $grid->model()->orderBy('id', 'desc');
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
        $grid->column('export', __('Report'))->display(function () {
            $link = '<a target="_blank" href="' . url('report-annual-workplans-print?id=' . $this->id) . '">Generate Report</a>';
            return $link;
        });

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

        $ajax_url = url(
            '/api/ajax?'
                . "search_by_1=name"
                . "&search_by_2=id"
                . "&model=District"
        );
        $form->select('district_id', "Select district")
            ->options(function ($id) {
                $a = District::find($id);
                if ($a) {
                    return [$a->id => "#" . $a->id . " - " . $a->name];
                }
            })
            ->ajax($ajax_url)->rules('required');


        $form->select('department_id', "Select department")
            ->options(Department::where([])->orderBy('department', 'Asc')
                ->get()
                ->pluck('department', 'id'))
            ->rules('required');
        $form->select('year', __('Year'))->options(YEARS)->rules('required');
        $form->textarea('description', __('Description'));

        return $form;
    }
}
