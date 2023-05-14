<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use App\Models\Subcounty;
use App\Models\User;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Model;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

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
        $grid = new Grid(new Administrator());
        $grid->model()->orderBy('id', 'Desc');
        $grid->quickSearch('name');
        $grid->disableBatchActions();

        $u = Admin::user();
        if ($u->can('ministry') || $u->can('administrator')) {
        } else if ($u->can('district')) {
            $grid->model()->where('district_id', $u->district_id);
            $grid->model()->where('department_id', $u->department_id);
        } else if ($u->can('subcounty')) {
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->model()->where('user_id', $u->id);
            $grid->disableExport();
        } else {
            $grid->model()
            ->where([
                'department_id' => $u->department_id,
                'district_id' => $u->district_id,
            ]);
            $grid->disableCreateButton();
        }



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
                if ($this->district == null) {
                    return '-';
                }
                return $this->district->name;
            })
            ->sortable();

        $grid->column('subcounty_id', __('Subcounty'))
            ->display(function () {
                if ($this->subcounty == null) {
                    return "-";
                }
                return $this->subcounty->name;
            })
            ->sortable();
        $grid->column('department_id', __('Department'))
            ->display(function ($x) {
                if ($this->department == null) {
                    return '-';
                }
                return $this->department->department;
            })
            ->sortable();
        $grid->column('roles', trans('admin.roles'))->pluck('name')->label();

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
              <a class="dropdown-item py-2" href="quaterly-outputs/create?user=' . $this->id . '" >Add quarterly activity</a>
              <a class="dropdown-item py-2"  href="quaterly-outputs/?user_id=' . $this->id . '" >View Workplan</a>
              <a class="dropdown-item py-2"  href="evaluations/?user_id=' . $this->id . '" >View Evaluation</a>
              <a class="dropdown-item py-2"  href="javascript:;" >Print Workplan</a>
              <a class="dropdown-item py-2" href="worklplan-clones/create?user=' . $this->id . '" >Clone Workplan</a>
              <a class="dropdown-item py-2" href="my-members/' . $this->id . '/edit" >Edit user profile</a>
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
        /*      $u = Administrator::find(226);
        $u->job_title .= '1';
        $u->save();
        dd(""); */
        $form = new Form(new Administrator());
        $roleModel = config('admin.database.roles_model');
        $u = Admin::user();

        $form->divider('Bio Data');
        $form->text('first_name', __('First name'))->rules('required');
        $form->text('last_name', __('Last name'))->rules('required');
        $form->radio('gender', __('Sex'))->options(['M' => 'Male', 'F' => 'Female'])->rules('required');

        $form->text('phone', __('Phone number'));


        $form->text('job_title', __('Job title'));
        $form->text('education', __('Education'))->default('Primary');
        $form->text('year_working', __('Year working'))->default('2018');
        $form->text('year_maaif', __('Year maaif'))->default('2018');
        $form->text('device_assigned', __('Device assigned'));
        $form->text('device_serial', __('Device serial'));

        $form->divider('Roles');

        $ajax_link = '/api/Subcounty?district_id=' . $u->district_id;
        if (
            $u->can('ministry') ||
            $u->can('administrator')
        ) {
            $ajax_link = '/api/Subcounty';
        }

        $form->select('subcounty_id', __('Subcounty'))
            ->options(function ($id) {
                $a = Subcounty::find($id);
                if ($a != null) {
                    return [$a->id => $a->name_text];
                }
            })
            ->rules('required')
            ->help('Work station sub-county')
            ->ajax(url(
                $ajax_link
            ));


        if ($u->can('ministry') || $u->can('administrator')) {
            $form->select('department_id', __('Department'))->options(Department::where([])->orderBy('department', 'asc')->get()->pluck('department', 'id'))
                ->rules('required')
                ->required();
        } else {
            $form->select('department_id', __('Department'))->options(Department::where([])->orderBy('department', 'asc')->get()->pluck('department', 'id'))
                ->rules('required')
                ->default($u->department_id)
                ->readOnly()
                ->required();
        }

        $roles = [];
        foreach ($roleModel::all() as $key => $role) {
            if (
                !$u->can('administrator') &&
                !$u->can('ministry')

            ) {
                if (
                    $role->can('administrator') ||
                    $role->can('district') ||
                    $role->can('ministry')
                ) {
                    continue;
                }
            }
            $roles[$role->id] = $role->name;
        }


        $form->multipleSelect('roles', trans('admin.roles'))->options($roles);

        $form->radio('is_verified', __('Is verified?'))
            ->options([
                1 => 'Verified',
                0 => 'NOT Verified',
            ])->default(0)->required();




        $form->divider();
        $form->image('avatar', __('Photo'))->default('user.png');
        $form->text('username', __('Username'));
        $form->email('email', __('Email'))->rules('required');


        $form->radio('want_password_changed', __('Want to change Password?'))->options([
            1 => 'Yes'
        ])->when(1, function ($form) {
            $form->password('password', trans('admin.password'))->rules('confirmed|required');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });
        });




        $form->ignore(['password_confirmation', 'want_password_changed']);

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = Hash::make($form->password);
            }
        });


        return $form;
    }
}
