<?php

namespace App\Admin\Controllers;

use App\Models\Position;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PositionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Position';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Position());
        $grid->disableBatchActions();
        $grid->model()->orderby('id', 'desc');
        $grid->column('name', __('Name'))->sortable();
        $grid->column('category', __('Category'))->sortable();

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
        $show = new Show(Position::findOrFail($id));

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
        $form = new Form(new Position());

        $form->text('name', __('Name'))->required();
        $form->select('category', __('Position Level'))->options([
            'Ministry' => 'Ministry - User Level',
            'District' => 'District - User Level',
            'Subcounty' => 'Subcounty - User Level',
        ])->required();
        $form->disableReset();
        return $form;
    }
}
