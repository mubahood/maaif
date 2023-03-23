<?php

namespace App\Admin\Controllers;

use App\Models\FarmerQuestion;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FarmerQuestionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'FarmerQuestion';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FarmerQuestion());

        $grid->column('id', __('Id'));
        $grid->column('keyword_id', __('Keyword id'));
        $grid->column('keyword', __('Keyword'));
        $grid->column('farmer_id', __('Farmer id'));
        $grid->column('parish_id', __('Parish id'));
        $grid->column('telephone', __('Telephone'));
        $grid->column('body', __('Body'));
        $grid->column('sender', __('Sender'));
        $grid->column('other', __('Other'));
        $grid->column('has_media', __('Has media'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('enterprise_id', __('Enterprise id'));
        $grid->column('inquiry_source', __('Inquiry source'));
        $grid->column('user_id', __('User id'));
        $grid->column('image_one', __('Image one'));
        $grid->column('image_two', __('Image two'));
        $grid->column('image_three', __('Image three'));

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
        $show = new Show(FarmerQuestion::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('keyword_id', __('Keyword id'));
        $show->field('keyword', __('Keyword'));
        $show->field('farmer_id', __('Farmer id'));
        $show->field('parish_id', __('Parish id'));
        $show->field('telephone', __('Telephone'));
        $show->field('body', __('Body'));
        $show->field('sender', __('Sender'));
        $show->field('other', __('Other'));
        $show->field('has_media', __('Has media'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('enterprise_id', __('Enterprise id'));
        $show->field('inquiry_source', __('Inquiry source'));
        $show->field('user_id', __('User id'));
        $show->field('image_one', __('Image one'));
        $show->field('image_two', __('Image two'));
        $show->field('image_three', __('Image three'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FarmerQuestion());

        $form->number('keyword_id', __('Keyword id'));
        $form->text('keyword', __('Keyword'));
        $form->number('farmer_id', __('Farmer id'));
        $form->number('parish_id', __('Parish id'));
        $form->text('telephone', __('Telephone'));
        $form->textarea('body', __('Body'));
        $form->text('sender', __('Sender'));
        $form->textarea('other', __('Other'));
        $form->switch('has_media', __('Has media'));
        $form->number('enterprise_id', __('Enterprise id'));
        $form->text('inquiry_source', __('Inquiry source'));
        $form->number('user_id', __('User id'));
        $form->text('image_one', __('Image one'));
        $form->text('image_two', __('Image two'));
        $form->text('image_three', __('Image three'));

        return $form;
    }
}
