<?php

namespace App\Admin\Controllers;

use App\Models\Meeting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MeetingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Meeting';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Meeting());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('theme', __('Theme')); 
        $grid->column('proceedings', __('Proceedings'));
        $grid->column('discussions', __('Discussions'));
        $grid->column('recommendations', __('Recommendations'));
        $grid->column('attendees', __('Attendees'));
        $grid->column('status_id', __('Status id'));
        $grid->column('location_id', __('Location id'));
        $grid->column('user_id', __('User id'));

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
        $show = new Show(Meeting::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('theme', __('Theme'));
        $show->field('created', __('Created'));
        $show->field('proceedings', __('Proceedings'));
        $show->field('discussions', __('Discussions'));
        $show->field('recommendations', __('Recommendations'));
        $show->field('attendees', __('Attendees'));
        $show->field('status_id', __('Status id'));
        $show->field('location_id', __('Location id'));
        $show->field('user_id', __('User id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Meeting());

        $form->text('theme', __('Theme'));
        $form->datetime('created', __('Created'))->default(date('Y-m-d H:i:s'));
        $form->textarea('proceedings', __('Proceedings'));
        $form->textarea('discussions', __('Discussions'));
        $form->textarea('recommendations', __('Recommendations'));
        $form->textarea('attendees', __('Attendees'));
        $form->number('status_id', __('Status id'));
        $form->number('location_id', __('Location id'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}
