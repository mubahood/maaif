<?php

namespace App\Admin\Controllers;

use App\Models\Directorate;
use App\Models\MinistryDepartment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MinistryDepartmentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Ministry Departments';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MinistryDepartment());
        $grid->disableExport();
        $grid->disableBatchActions();
        $grid->column('directorate.directorate', __('Directorate'))->sortable();
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
        $show = new Show(MinistryDepartment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('directorate_id', __('Directorate id'));
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
        $form = new Form(new MinistryDepartment());

        $form->select('directorate_id', __('Directorate'))->options(
            Directorate::where([])->orderby('directorate', 'asc')->get()->pluck('directorate', 'id')
        )->required();
        $form->text('name', __('Name'))->required();
        $form->disableReset();
        $form->disableViewCheck();

        return $form;
    }
}
