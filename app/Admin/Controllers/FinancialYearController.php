<?php

namespace App\Admin\Controllers;

use App\Models\AnnualWorkplan;
use App\Models\FinancialYear;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FinancialYearController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Financial Years';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        // $x = FinancialYear::find(7);
        // FinancialYear::generate_plans($x); 
        // dd($x);   
        //AnnualWorkplan::generate_work_plan($plan);

        $grid = new Grid(new FinancialYear());
        $grid->disableExport();

        $grid->actions(function ($a) {
            $a->disableDelete();
            $a->disableView();
        });

        $grid->model()->orderBy('name', 'desc');
        $grid->disableBatchActions();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('data_entry', __('Year under planning'))
            ->using([
                1 => 'Active',
                0 => 'Not active',
            ])
            ->label([
                1 => 'success',
                0 => 'danger',
            ]);


        $grid->column('active', __('Implementation'))
            ->using([
                1 => 'Active',
                0 => 'Not active',
            ])
            ->label([
                1 => 'success',
                0 => 'danger',
            ]);

        $grid->column('workplan', __('Workplans'))->display(function () {
            return count($this->workplans);
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
        $show = new Show(FinancialYear::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('active', __('Active'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FinancialYear());
        $years = [];

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();
        $form->disableReset();

        $start_year = 2017;
        $thisYear = date('Y');
        for ($i = 0; $start_year <= $thisYear; $i++) {
            $year = $start_year . "/" . ($start_year + 1);
            $years[$year] = $year;
            $start_year++;
        }
        $years = array_reverse($years);

        $form->select('name', __('Year'))
            ->options($years)
            ->rules('required')->required();


        $form->radio('data_entry', __('Year under planning'))->options([
            '0' => 'Not active',
            '1' => 'Active',
        ])->rules('required')->required();

        $form->radio('active', __('Implementation year'))->options([
            '0' => 'Not active',
            '1' => 'Active',
        ])->rules('required')->required();



        return $form;
    }
}
