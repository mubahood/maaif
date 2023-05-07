<?php

namespace App\Admin\Controllers;

use App\Models\DailyActivity;
use App\Models\Enterprise;
use App\Models\QuaterlyOutput;
use App\Models\Topic;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DailyActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Daily Activities';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DailyActivity());

        $grid->model([])->orderBy('id', 'desc');
        $grid->disableBatchActions();

        $u = Admin::user();
        if ($u->can('ministry')) {
        } else if ($u->can('district')) {
            $grid->disableActions();
            //$grid->disableCreateButton();
            $grid->model()->where([
                'district_id' => $u->district_id,
                'department_id' => $u->department_id,
            ]);
        } else if ($u->can('subcounty')) {
            $grid->model()->where('user_id', $u->id);
            $grid->disableExport();
        } else {
            $grid->model()->where('department_id', $u->department_id);
        }



        $grid->column('id', __('Id'))->hide();
        $grid->column('date', __('Date'))->display(function ($x) {
            return Utils::my_date($x);
        })->sortable();
        $grid->column('topic', __('Topic'))->display(function () {
            return $this->topic_text;
        })->sortable();
        $grid->column('gps_latitude', __('Gps latitude'))->hide();
        $grid->column('gps_longitude', __('Gps longitude'))->hide();
        $grid->column('entreprise', __('Entreprise'))->display(function () {
            return $this->entreprise_text;
        })->label()->sortable();

        $grid->column('village_id', __('Village'))->display(function () {
            return $this->village_text;
        })->sortable();
        $grid->column('notes', __('Notes'))->hide();
        $grid->column('num_ben_males', __('No. of Males'))->sortable();
        $grid->column('num_ben_females', __('No. of Females'))->sortable();
        $grid->column('num_ben_total', __('Total'))->sortable();
        $grid->column('ben_ref_name', __('Ben. name'))->sortable();
        $grid->column('ben_ref_phone', __('Ben. phone'))->sortable();
        $grid->column('ben_group', __('Ben. group'))->hide();
        $grid->column('user_id', __('Officer'))->sortable();
        $grid->column('quarterly_activity_id', __('Quarterly activity'))
            ->display(function () {
                if ($this->activity == null) {
                    return '-';
                }
                return '<p title="' . $this->activity->topic_text . '">' . Str::limit($this->activity->topic_text, 35) . '</p>';
            })->sortable();
        $grid->column('activity_type', __('Activity type'))->hide();
        $grid->column('photo', __('Photo'))
            ->display(function ($pic) {
                if ($pic == null || strlen($pic) < 2) {
                    return 'No Photo';
                }

                $a = url('storage/' . $pic);
                $img = '<a title="Open full photo" target="_blank" href="' . $a . '" ><img width="50" src="' . $a . '" /></a>';
                return $img;
            })->sortable();

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

        $form->date('date', __('Activity Date'))->default(date('Y-m-d H:i:s'));


        $year = Utils::data_entry_year();
        if ($year == null) {
            die("data entry year not found.");
        }

        $quarterly_activities = [];
        foreach (QuaterlyOutput::where(['year' => $year->name])->orderBy('id', 'desc')->get() as $v) {
            $quarterly_activities[$v->id] = Str::limit($v->name, 100, '...');
        }

        $form->select('quarterly_activity_id', __('Select Quarterly Output'))
            ->options($quarterly_activities)
            ->load('topic', url('api/QuaterlyOutputTopics'))
            ->rules('required');

        $form->select('topic', __('Select Topic'))->options(function ($id) {
            $t = Topic::find($id);
            if ($t == null) {
                return [];
            }
            return [
                $t->id => $t->name
            ];
        })
            ->rules('required');


        $form->image('photo', __('Photo'));

        $entreprizes = Enterprise::all()->pluck('name', 'id');
        $form->select('entreprise', __('Entreprise'))
            ->options($entreprizes)
            ->required();


        $form->divider();

        $form->decimal('num_ben_males', __('Number of males beneficiaries'));
        $form->decimal('num_ben_females', __('Number of female beneficiaries'));
        $form->decimal('num_ben_total', __('Total number of beneficiaries'));

        $form->divider();

        $form->hidden('gps_latitude', __('Gps latitude'))->default('0.00');
        $form->hidden('gps_longitude', __('Gps longitude'))->default('0.00');
        $form->hidden('village_id', __('Village id'))->default(1);

        $form->text('ben_ref_name', __('Ben ref name'));
        $form->text('ben_ref_phone', __('Ben ref phone'));
        $form->text('ben_group', __('Ben group'));
        $form->textarea('notes', __('Notes'));
        $form->hidden('user_id', __('User'))->default(Auth::user()->id);
        $form->hidden('activity_type', __('Activity type'))->default(1);

        $form->disableReset();
        return $form;
    }
}
