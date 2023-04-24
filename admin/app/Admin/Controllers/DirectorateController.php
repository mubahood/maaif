<?php

namespace App\Admin\Controllers;

use App\Models\Directorate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DirectorateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Directorate';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Directorate());
        $grid->disableBatchActions();
        $grid->column('id', __('Id'))->sortable(); 
        $grid->column('directorate', __('Directorate'))->sortable();

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
        $show = new Show(Directorate::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('directorate', __('Directorate'));
        $show->field('description', __('Description'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Directorate());

        $form->text('directorate', __('Directorate'))->required();
        $form->textarea('description', __('Description'));

        return $form;
    }
}
