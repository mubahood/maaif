<?php

namespace App\Admin\Controllers;

use App\Models\QuaterlyOutput;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EvaluationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'QuaterlyOutput';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new QuaterlyOutput());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('topic', __('Topic'));
        $grid->column('entreprizes', __('Entreprizes'));
        $grid->column('num_planned', __('Num planned'));
        $grid->column('num_target_ben', __('Num target ben'));
        $grid->column('num_carried_out', __('Num carried out'));
        $grid->column('num_reached_ben', __('Num reached ben'));
        $grid->column('remarks', __('Remarks'));
        $grid->column('lessons', __('Lessons'));
        $grid->column('recommendations', __('Recommendations'));
        $grid->column('budget', __('Budget'));
        $grid->column('annual_id', __('Annual id'));
        $grid->column('quarter', __('Quarter'));
        $grid->column('user_id', __('User id'));
        $grid->column('key_output_id', __('Key output id'));

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
        $show = new Show(QuaterlyOutput::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('topic', __('Topic'));
        $show->field('entreprizes', __('Entreprizes'));
        $show->field('num_planned', __('Num planned'));
        $show->field('num_target_ben', __('Num target ben'));
        $show->field('num_carried_out', __('Num carried out'));
        $show->field('num_reached_ben', __('Num reached ben'));
        $show->field('remarks', __('Remarks'));
        $show->field('lessons', __('Lessons'));
        $show->field('recommendations', __('Recommendations'));
        $show->field('budget', __('Budget'));
        $show->field('annual_id', __('Annual id'));
        $show->field('quarter', __('Quarter'));
        $show->field('user_id', __('User id'));
        $show->field('key_output_id', __('Key output id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new QuaterlyOutput());

        $form->text('topic', __('Topic'));
        $form->text('entreprizes', __('Entreprizes'));
        $form->number('num_planned', __('Num planned'));
        $form->number('num_target_ben', __('Num target ben'));
        $form->number('num_carried_out', __('Num carried out'));
        $form->number('num_reached_ben', __('Num reached ben'));
        $form->textarea('remarks', __('Remarks'));
        $form->textarea('lessons', __('Lessons'));
        $form->textarea('recommendations', __('Recommendations'));
        $form->number('budget', __('Budget'));
        $form->number('annual_id', __('Annual id'));
        $form->number('quarter', __('Quarter'));
        $form->number('user_id', __('User id'));
        $form->text('key_output_id', __('Key output id'));

        return $form;
    }
}
