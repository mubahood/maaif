<?php

namespace App\Admin\Controllers;

use App\Models\AreaProfile;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AreaProfileController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AreaProfile';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AreaProfile());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('user_id', __('User id'));
        $grid->column('parish_id', __('Parish id'));
        $grid->column('pop_males', __('Pop males'));
        $grid->column('pop_females', __('Pop females'));
        $grid->column('pop_ben_groups', __('Pop ben groups'));

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
        $show = new Show(AreaProfile::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('user_id', __('User id'));
        $show->field('parish_id', __('Parish id'));
        $show->field('pop_males', __('Pop males'));
        $show->field('pop_females', __('Pop females'));
        $show->field('pop_ben_groups', __('Pop ben groups'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AreaProfile());

        $form->number('user_id', __('User id'));
        $form->number('parish_id', __('Parish id'));
        $form->number('pop_males', __('Pop males'));
        $form->number('pop_females', __('Pop females'));
        $form->number('pop_ben_groups', __('Pop ben groups'));

        return $form;
    }
}
