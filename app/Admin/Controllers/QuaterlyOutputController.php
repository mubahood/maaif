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
    protected $title = 'Quaterly activities';

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
        /*        set_time_limit(-1);
        
        foreach (QuaterlyOutput::all() as $key => $v) {
            $v->remarks = '';
            $v->save();
            echo($v->id."<br>"); 
        }
        dd("done"); */

        $grid = new Grid(new QuaterlyOutput());

        $u = Admin::user();
        if ($u->can('ministry')) {
            $grid->disableCreateButton();
        } else if ($u->can('district')) {
            //$grid->disableActions();
            //$grid->disableCreateButton();
            $grid->model()->where('district_id', $u->district_id);
        } else if ($u->can('subcounty')) {
            $grid->model()->where('user_id', $u->id);
            $grid->disableExport();
        } else {
            $grid->model()->where('department_id', $u->department_id);
        }



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

            return '<p title="' . $this->topic_text . '">' . Str::limit($this->topic_text, 60) . '</p>';
        });



        $grid->column('annual_id', __('Annual Output'))
            ->display(function ($x) {
                if ($this->output == null) {
                    return $x;
                }
                return '<p title="' . $this->output->name_text . '">' . Str::limit($this->output->name_text, 60) . '</p>';
            })->sortable();

        $grid->column('quarter', __('Quarter'))->display(function ($x) {
            return '<b>' . Utils::addOrdinalSuffix($x) . '</b>';
        })->filter([
            '1' => '1st Quarter',
            '2' => '4th Quarter',
            '3' => '3rd Quarter',
            '4' => '4th Quarter',
        ])->sortable();

        $grid->column('num_target_ben', __('No. target'))->sortable();
        $grid->column('budget', __('Budget'))
            ->display(function ($x) {
                return '<b>UGX ' . number_format($x) . '</b>';
            })->totalRow(function ($x) {
                return '<b>UGX ' . number_format($x) . '</b>';
            })->sortable();


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

        $year = Utils::data_entry_year();

        if ($year == null) {
            die("data entry year not found.");
        }

        $form = new Form(new QuaterlyOutput());

        if ($form->isCreating()) {
            $form->hidden('created_by')->value(Auth::user()->id)->default(Auth::user()->id);
        }

        $form->disableCreatingCheck();
        /* $form->disableEditingCheck(); */
        $form->disableViewCheck();
        $form->disableReset();
        $u = Admin::user();
        $ajax_url = url('/api/usersByDistrict?district_id=' . $u->district_id . "&department_id=" . $u->department_id);
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

                    $v = User::find($u_id);
                    return [$v->id => '#' . $v->id . " - " . $v->name . ", " . $v->district->name];
                })
                ->default($u_id)
                ->readOnly()
                ->ajax($ajax_url)->rules('required');
        } else {


            $form->select('user_id', "Extension Officer")
                ->options(function ($id) {
                    $v = User::find($id);
                    if ($v == null) {
                        $v = Auth::user();
                    }
                    if ($v) {
                        return [$v->id => '#' . $v->id . " - " . $v->name . ", " . $v->district->name];
                    }
                })
                ->default(Auth::user()->id)
                ->ajax($ajax_url)->rules('required');
        }


        $ajax_url = url(
            '/api/AnnualOutputController?district_id=' . $u->district_id .
                "&department_id=" . $u->department_id .
                "&year=" . $year->name
        );
        $form->select('key_output_id', __('Select Annual Output'))
            ->options(function ($id) {
                $a = AnnualOutput::find($id);
                if ($a) {
                    return [$a->id => "#" . $a->id . " - " . $a->key_output];
                }
            })
            ->ajax($ajax_url)
            ->load('annual_activity_id', url('api/AnnualOutputHasActivity'))
            ->rules('required');
   
        $form->select('annual_activity_id', "Select Activity From Annual Activitiy for this Quarter")
            ->options(function($id){
                $an = Activity::where([ 
                    'id' => ((int)($id))
                ])->first();
                if($an == null){
                    return [
                         
                    ];
                }
                return [
                    $an->id => $an->name_text
                ];

            })
            ->required();
 
      $topics = Topic::where([
            'department_id' => Admin::user()->department_id
        ])->orderby('name', 'asc')->get()->pluck('name', 'id');

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
        $form->decimal('num_planned', __('Planned Number of Times this Quarter'))->required();
        $form->decimal('num_target_ben', __('Number of Target Beneficiaries this Quarter'))->required();

        $form->radio('add_another', __('Do you want to add another output to this officer?'))->options([
            "Yes" => 'YES',
            "No" => 'No',
        ])->required();

        return $form;
    }
}
