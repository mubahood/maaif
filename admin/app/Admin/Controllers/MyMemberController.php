<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Model;
use Encore\Admin\Show;







class MyMemberController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'My Members';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());
        $grid->model()->orderBy('name', 'asc');
        $grid->quickSearch('name');
        $grid->disableBatchActions();

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('gender', __('Sex'))
            ->using([
                'F' => 'Female',
                'M' => 'Male',
            ])
            ->filter([
                'F' => 'Female',
                'M' => 'Male',
            ])
            ->sortable();
        $grid->column('phone', __('Phone number'));
        $grid->column('email', __('Email'));
        $grid->column('district_id', __('District'))
            ->display(function () {
                return $this->district->name;
            })
            ->sortable();
        $grid->column('department_id', __('Department'))
            ->display(function ($x) {
                return $x;
                $dep = $this->department;
                if ($dep == null) {
                    return $x;
                }
                return $this->dep->name;
            })
            ->hide()
            ->sortable();
        $grid->column('user_category_id', __('Designation'))
            ->display(function ($x) {
                $dep = $this->designation;
                if ($dep == null) {
                    return $x;
                }
                return $dep->name;
            })
            ->label()
            ->sortable();
        $grid->column('education', __('Education'))->hide();
        $grid->column('year_working', __('Year working'))->hide();
        $grid->column('activies', __('Activities'))
            ->display(function () {
                $activies = '<p style="font-weight: bolder; padding: 0px; margin: 0px; text-align: center; font-size: 20px;">
                <a title="View Activities" href="quaterly-outputs?user_id=' . $this->id . '" >' . count($this->activities) . '</a></p>';
                return $activies;
            });
        $grid->column('bugdet', __('Bugdet'))
            ->display(function () {
                $activies = number_format($this->bugdet());
                return 'UGX ' . $activies;
            });

        $grid->column('actions', __('Actions'))->display(function () {


            $addActivity  =   '<div class="dropdown show dropleft  h4  m-0">
            <a class="px-0" href="#" role="button" id="dropdownMenuLink' . $this->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink' . $this->id . '">
              <a class="dropdown-item py-2" href="quaterly-outputs/create?user=' . $this->id . '" >Add activity</a>
              <a class="dropdown-item py-2"  href="quaterly-outputs/?user_id=' . $this->id . '" >View Workplan</a>
              <a class="dropdown-item py-2"  href="evaluations/?user_id=' . $this->id . '" >View Evaluation</a>
              <a class="dropdown-item py-2"  href="javascript:;" >Print Workplan</a>
              <a class="dropdown-item py-2" href="worklplan-clones/create?user=' . $this->id . '" >Clone Workplan</a>
            </div>
          </div>';

            //$addActivity .= '<p class="p-0 m-0"><a href="quaterly-outputs/create?user=' . $this->id . '" >Generate report</a></p>';
            return $addActivity;
        });

        $grid->disableActions();



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
        $show->field('created', __('Created'));
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
        $show->field('created_at', __('Created at'));
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

        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->text('username', __('Username'));
        $form->email('email', __('Email'));
        $form->textarea('password', __('Password'));
        $form->datetime('created', __('Created'))->default(date('Y-m-d H:i:s'));
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
