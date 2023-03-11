<?php

namespace App\Admin\Controllers;

use App\Models\DailyActivity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DailyActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'DailyActivity';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DailyActivity());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('date', __('Date'));
        $grid->column('topic', __('Topic'));
        $grid->column('gps_latitude', __('Gps latitude'));
        $grid->column('gps_longitude', __('Gps longitude'));
        $grid->column('entreprise', __('Entreprise'));
        $grid->column('photo', __('Photo'));
        $grid->column('village_id', __('Village id'));
        $grid->column('notes', __('Notes'));
        $grid->column('num_ben_males', __('Num ben males'));
        $grid->column('num_ben_total', __('Num ben total'));
        $grid->column('num_ben_females', __('Num ben females'));
        $grid->column('ben_ref_name', __('Ben ref name'));
        $grid->column('ben_ref_phone', __('Ben ref phone'));
        $grid->column('ben_group', __('Ben group'));
        $grid->column('user_id', __('User id'));
        $grid->column('quarterly_activity_id', __('Quarterly activity id'));
        $grid->column('activity_type', __('Activity type'));

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
        $show = new Show(DailyActivity::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('date', __('Date'));
        $show->field('topic', __('Topic'));
        $show->field('gps_latitude', __('Gps latitude'));
        $show->field('gps_longitude', __('Gps longitude'));
        $show->field('entreprise', __('Entreprise'));
        $show->field('photo', __('Photo'));
        $show->field('village_id', __('Village id'));
        $show->field('notes', __('Notes'));
        $show->field('num_ben_males', __('Num ben males'));
        $show->field('num_ben_total', __('Num ben total'));
        $show->field('num_ben_females', __('Num ben females'));
        $show->field('ben_ref_name', __('Ben ref name'));
        $show->field('ben_ref_phone', __('Ben ref phone'));
        $show->field('ben_group', __('Ben group'));
        $show->field('user_id', __('User id'));
        $show->field('quarterly_activity_id', __('Quarterly activity id'));
        $show->field('activity_type', __('Activity type'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DailyActivity());

        $form->datetime('date', __('Date'))->default(date('Y-m-d H:i:s'));
        $form->text('topic', __('Topic'))->default('119');
        $form->text('gps_latitude', __('Gps latitude'));
        $form->text('gps_longitude', __('Gps longitude'));
        $form->text('entreprise', __('Entreprise'))->default('198');
        $form->text('photo', __('Photo'));
        $form->text('village_id', __('Village id'))->default('1');
        $form->textarea('notes', __('Notes'));
        $form->text('num_ben_males', __('Num ben males'));
        $form->number('num_ben_total', __('Num ben total'));
        $form->text('num_ben_females', __('Num ben females'));
        $form->text('ben_ref_name', __('Ben ref name'));
        $form->text('ben_ref_phone', __('Ben ref phone'));
        $form->text('ben_group', __('Ben group'));
        $form->text('user_id', __('User id'));
        $form->text('quarterly_activity_id', __('Quarterly activity id'))->default('52');
        $form->number('activity_type', __('Activity type'));

        return $form;
    }
}
