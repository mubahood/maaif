<?php

namespace App\Admin\Controllers;

use App\Models\MinistryDepartment;
use App\Models\MinistryDivision;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MinistryDivisionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Ministry Divisions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MinistryDivision());

 

        $grid->disableExport();
        $grid->disableBatchActions();
        $grid->column('ministry_department.name', __('Department'))->sortable();
        $grid->column('name', __('Name'))->sortable();


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
        $show = new Show(MinistryDivision::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('ministry_department_id', __('Ministry department id'));
        $show->field('name', __('Name'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MinistryDivision());


        $items = [];
        foreach (MinistryDepartment::where([])->orderby('name', 'asc')->get() as $key => $v) {
            $items[$v->id] = $v->directorate->directorate . ", " . $v->name;
        }
        $form->select('ministry_department_id', __('Ministry department'))->options(
            $items
        )->required();
        $form->text('name', __('Name'))->required();
        $form->disableReset();
        $form->disableViewCheck();

        return $form;
    }
}
