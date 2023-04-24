<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class MemberController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $u = Auth::user();
        if($u->isRole('admin')){
            $grid->model()->where([
                'id' => '1000'
            ]);
        }

        $grid->quickSearch('first_name')->placeholder('Seach by name..');
        $grid->column('id', __('Id'));
        $grid->column('first_name', __('First name'))
        ->editable()
        ->sortable();
        $grid->column('username', __('Username'))->display(
            function($u){
                return $this->first_name." ".$this->last_name;
            }
        );
        $grid->column('email', __('Email'));
        $grid->column('password', __('Password')); 
        $grid->column('phone', __('Phone'));
        $grid->column('location_id', __('Location id'));
        $grid->column('district_id', __('District id'));
        $grid->column('user_category_id', __('User category id'));
        $grid->column('photo', __('Photo'));
        $grid->column('gender', __('Gender'));
        $grid->column('job_title', __('Job title'));
        $grid->column('education', __('Education'));
        $grid->column('year_working', __('Year working'));
        $grid->column('year_maaif', __('Year maaif'));
        $grid->column('device_assigned', __('Device assigned'));
        $grid->column('device_serial', __('Device serial'));
        $grid->column('directorate_id', __('Directorate id'));
        $grid->column('department_id', __('Department id'));
        $grid->column('division_id', __('Division id'));
        $grid->column('subcounty_id', __('Subcounty id'));
        $grid->column('zone_id', __('Zone id'));
        $grid->column('parish_id', __('Parish id'));
        $grid->column('municipality_id', __('Municipality id'));
        $grid->column('is_verified', __('Is verified'));
        $grid->column('password_changed', __('Password changed'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('created_at', __('Created at'));
        $grid->column('remember_token', __('Remember token'));
        $grid->column('name', __('Name'));
        $grid->column('avatar', __('Avatar'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('username', __('Username'));
        $show->field('email', __('Email'));
        $show->field('password', __('Password'));
        $show->field('phone', __('Phone'));
        $show->field('location_id', __('Location id'));
        $show->field('district_id', __('District id'));
        $show->field('user_category_id', __('User category id'));
        $show->field('photo', __('Photo'));
        $show->field('gender', __('Gender'));
        $show->field('job_title', __('Job title'));
        $show->field('education', __('Education'));
        $show->field('year_working', __('Year working'));
        $show->field('year_maaif', __('Year maaif'));
        $show->field('device_assigned', __('Device assigned'));
        $show->field('device_serial', __('Device serial'));
        $show->field('directorate_id', __('Directorate id'));
        $show->field('department_id', __('Department id'));
        $show->field('division_id', __('Division id'));
        $show->field('subcounty_id', __('Subcounty id'));
        $show->field('zone_id', __('Zone id'));
        $show->field('parish_id', __('Parish id'));
        $show->field('municipality_id', __('Municipality id'));
        $show->field('is_verified', __('Is verified'));
        $show->field('password_changed', __('Password changed'));
        $show->field('updated_at', __('Updated at')); 
        $show->field('remember_token', __('Remember token'));
        $show->field('name', __('Name'));
        $show->field('avatar', __('Avatar'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        if($form->isEditing()){
            $form->text('first_name', __('First name'))->rules('required'); 
        }


        $form->text('last_name', __('Last name'));
        $form->text('username', __('Username'));
        $form->email('email', __('Email'));
        $form->textarea('password', __('Password')); 
        $form->mobile('phone', __('Phone'));
        $form->number('location_id', __('Location id'));
        $form->number('district_id', __('District id'));
        $form->number('user_category_id', __('User category id'));
        $form->text('photo', __('Photo'))->default('user.png');
        $form->text('gender', __('Gender'));
        $form->text('job_title', __('Job title'));
        $form->text('education', __('Education'))->default('Primary');
        $form->text('year_working', __('Year working'))->default('2018');
        $form->text('year_maaif', __('Year maaif'))->default('2018');
        $form->text('device_assigned', __('Device assigned'));
        $form->text('device_serial', __('Device serial'));
        $form->number('directorate_id', __('Directorate id'));
        $form->number('department_id', __('Department id'));
        $form->number('division_id', __('Division id'));
        $form->number('subcounty_id', __('Subcounty id'));
        $form->number('zone_id', __('Zone id'));
        $form->number('parish_id', __('Parish id'));
        $form->number('municipality_id', __('Municipality id'));
        $form->number('is_verified', __('Is verified'))->default(1);
        $form->switch('password_changed', __('Password changed'));
        $form->textarea('remember_token', __('Remember token'));
        $form->textarea('name', __('Name'));
        $form->textarea('avatar', __('Avatar'));

        return $form;
    }
}
