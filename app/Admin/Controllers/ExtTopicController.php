<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\User\TopicBatchSetDepartment;
use App\Models\Department;
use App\Models\Topic;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ExtTopicController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Topics';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Topic());
        $grid->batchActions(function ($batch) {

            $batch->add(new TopicBatchSetDepartment());
            $batch->disabledelete();
        });

        $grid->model()->orderBy('name', 'asc');
        $grid->column('name', __('Topics'))->sortable();
        $grid->column('department_id', __('Department'))->display(function () {
            if ($this->department == null) {
                return '-';
            }
            return $this->department->department;
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
        $show = new Show(Topic::findOrFail($id));

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
        $form = new Form(new Topic());

        $form->text('name', __('Name'))->rules('required');
        $form->hidden('category', __('Category'))->default(1);
        $form->select('department_id', __('Select Department'))
            ->options(Department::where([])->orderBy('department', 'asc')->get()->pluck('department', 'id'))
            ;

        return $form;
    }
}
