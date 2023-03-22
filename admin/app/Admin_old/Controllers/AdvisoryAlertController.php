<?php

namespace App\Admin\Controllers;

use App\Models\AdvisoryAlert;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdvisoryAlertController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AdvisoryAlert';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdvisoryAlert());

        $grid->column('id', __('Id'));
        $grid->column('alert_type', __('Alert type'));
        $grid->column('alert_type_id', __('Alert type id'));
        $grid->column('language_id', __('Language id'));
        $grid->column('status', __('Status'));
        $grid->column('message', __('Message'));
        $grid->column('user_id', __('User id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(AdvisoryAlert::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('alert_type', __('Alert type'));
        $show->field('alert_type_id', __('Alert type id'));
        $show->field('language_id', __('Language id'));
        $show->field('status', __('Status'));
        $show->field('message', __('Message'));
        $show->field('user_id', __('User id'));
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
        $form = new Form(new AdvisoryAlert());

        $form->text('alert_type', __('Alert type'));
        $form->number('alert_type_id', __('Alert type id'));
        $form->number('language_id', __('Language id'));
        $form->text('status', __('Status'))->default('pending');
        $form->textarea('message', __('Message'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}
