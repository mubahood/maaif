<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\AnnualOutput;
use App\Models\AnnualOutputHasActivity;
use App\Models\AnnualWorkplan;
use App\Models\Enterprise;
use App\Models\FinancialYear;
use App\Models\QuaterlyOutput;
use App\Models\Topic;
use App\Models\User;
use App\Models\Utils;
use content;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuaterlyOutputController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Quaterly Outputs';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $m = QuaterlyOutput::where([
            'created_by' => Auth::user()->id
        ])->orderBy('id', 'desc')->first();
        if ($m != null && $m->add_another == 'Yes') {
            Admin::script('window.location.replace("' . admin_url('quaterly-outputs/create?user=' . $m->user_id) . '");');
            return 'Loading...';
        }


        $grid = new Grid(new QuaterlyOutput());


        $grid->filter(function ($filter) {
            // Remove the default id filter
            $filter->disableIdFilter();

            $filter->equal('annual_id', 'Filter by Workplan')
                ->select(AnnualWorkplan::where([])->orderBy('id', 'desc')->get()->pluck('name', 'id'));


            $ajax_url = url(
                '/api/ajax?'
                    . "search_by_1=name"
                    . "&search_by_2=id"
                    . "&model=User"
            );
            $filter->equal('user_id', 'Filter by officer')
                ->select(function ($id) {
                    $a = User::find($id);
                    if ($a) {
                        return [$a->id => "#" . $a->id . " - " . $a->name];
                    }
                })->ajax($ajax_url);


            $filter->group('budget', 'Filter by Budget', function ($group) {
                $group->gt('greater than');
                $group->lt('less than');
                $group->equal('equal to');
            });

            $filter->between('created_at', 'Filter by date between')->date();
        });




        $grid->disableBatchActions();
        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', __('ID'))->sortable()->hide();
        $grid->column('created_at', __('Date'))->display(function ($x) {
            return Utils::my_date($x);
        })->sortable();

        $grid->column('topic', __('Topics'))->display(function ($x) {
            return "name_text";
            if ($this->topic != null) {
            }

            return '<p title="' . $x . '">' . Str::limit($x, 50) . '</p>';
        });

        $grid->column('budget', __('Budget'))
            ->display(function ($x) {
                return '<b>UGX ' . number_format($x) . '</b>';
            })->totalRow(function ($x) {
                return '<b>UGX ' . number_format($x) . '</b>';
            })->sortable();
        $grid->column('num_target_ben', __('No. target'))->sortable();
        $grid->column('num_carried_out', __('No. carried out'))->sortable();
        $grid->column('num_reached_ben', __('No. reached'))->sortable();
        $grid->column('remarks', __('Remarks'))->sortable();
        $grid->column('annual_id', __('Output'))
            ->display(function ($x) {

                if ($this->output == null) {
                    return $x;
                }
                return $this->output->activities_text;
            })->sortable();
        $grid->column('quarter', __('Quarter'))->sortable();
        $grid->column('user_id', __('Officer'))->display(function ($x) {
            if ($this->user == null) {
                return $x;
            }
            return $this->user->name;
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
        /*  foreach (QuaterlyOutput::all() as $key => $v) {
            $v->created_by = $v->user_id;
            $v->save();
            echo $v->id."<hr>"; 
        } */

        $form = new Form(new QuaterlyOutput());

        if ($form->isCreating()) {
            $form->hidden('created_by')->value(Auth::user()->id)->default(Auth::user()->id);
        }

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();
        $form->disableReset();
        $ajax_url = url(
            '/api/ajax?'
                . "search_by_1=name"
                . "&search_by_2=id"
                . "&model=User"
        );

        $hasUser = false;
        if (isset($_GET['user'])) {
            $u_id = ((int)($_GET['user']));
            $officer = User::find($u_id);
            if ($officer != null) {
                $hasUser = true;
            }
        }


        if ($hasUser) {
            $form->select('user_id', "Extension Officer")
                ->options(function ($id) {
                    $u_id = ((int)($_GET['user']));
                    $officer = User::find($u_id);

                    $a = User::find($u_id);
                    return [$a->id => "#" . $a->id . " - " . $a->name];
                })
                ->default($u_id)
                ->readOnly()
                ->ajax($ajax_url)->rules('required');
        } else {
            $form->select('user_id', "Extension Officer")
                ->options(function ($id) {
                    $a = User::find($id);
                    if ($a == null) {
                        $a = Auth::user();
                    }
                    if ($a) {
                        return [$a->id => "#" . $a->id . " - " . $a->name];
                    }
                })
                ->default(Auth::user()->id)
                ->ajax($ajax_url)->rules('required');
        }


        $ajax_url = url(
            '/api/AnnualOutputController'
        );
        $form->select('key_output_id', __('Select Annual Output -Activity'))
            ->options(function ($id) {
                $a = AnnualOutput::find($id);
                if ($a) {
                    return [$a->id => "#" . $a->id . " - " . $a->key_output];
                }
            })
            ->ajax($ajax_url)->rules('required');

        $topics = Topic::all()->pluck('name_text', 'id');
        $form->multipleSelect('topic', __('Topics'))
            ->options($topics)
            ->required();


        $entreprizes = Enterprise::all()->pluck('name', 'id');
        $form->multipleSelect('entreprizes', __('Enterprises'))
            ->options($entreprizes)
            ->required();


        /* annual_output_has_activity_id */
        /* 
        $form->listbox('output_activities', 'Select Activities')
            ->options([])
            ->help("Select offences involded in this case")
            ->rules('required');
 */
        /*   $form->multipleSelect('topic', "Outputs")
            ->options(function ($id) {
                $a = AnnualOutput::find($id);
                if ($a) {
                    return [$a->id => "#" . $a->id . " - " . $a->name];
                }
            })
            ->ajax($ajax_url)->rules('required'); */

        /*    $form->text('topic', __('Outputs to Fullfill'))
            ->options(AnnualOutput::getArray(Auth::user()->id))
            ->rules('required'); */

        $form->decimal('budget', __('Budget'))->help('in UGX')->required();
        $form->radio('quarter', __('Select Quarter'))->options([
            1 => '1st quarter',
            2 => '2nd quarter',
            3 => '3nd quarter',
            4 => '4th quarter',
        ])->required();
        /*  $form->text('entreprizes', __('Entreprizes')); */
        $form->decimal('num_planned', __('Number planned'))->required();
        $form->decimal('num_target_ben', __('Number target'))->required();

        $form->radio('add_another', __('Do you want to add another output to this officer?'))->options([
            "Yes" => 'YES',
            "No" => 'No',
        ])->required();

        return $form;
    }
}
