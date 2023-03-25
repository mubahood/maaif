<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\AnnualOutput;
use App\Models\AnnualOutputHasActivity;
use App\Models\AnnualWorkplan;
use App\Models\FinancialYear;
use App\Models\QuaterlyOutput;
use App\Models\User;
use App\Models\Utils;
use content;
use Encore\Admin\Controllers\AdminController;
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
        
        /* 
        $m = AnnualOutput::find(4557);
        ```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````  $m->indicators .= rand(11,1111);
        $m->save();
        dd($m);``````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````` */

        /*   $years = [1, 2, 3, 4, 5, 8, 9];
        foreach (QuaterlyOutput::all() as $key => $v) {
            $v->annual_id = shuffle($years);
            $v->save();
            echo $v->id . " <hr> ";
            continue;
            $years[rand(0, 5)];
            dd($v);
            $u = User::find($v->user_id);
            if ($u == null) {
                continue;
            }
            if (in_array($u->year_working, $years)) {
                continue;
            }
            $years[] = $u->year_working;
            echo $u->year_working . "<hr>";
            continue;
            dd($u->year_working);
            dd($v);
        }
        die('save'); */
        $grid = new Grid(new QuaterlyOutput());
        $grid->disableBatchActions();
        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', __('ID'))->sortable()->hide();
        $grid->column('created_at', __('Date'))->display(function ($x) {
            return Utils::my_date($x);
        })->sortable();

        $grid->column('topic', __('Topics'))->display(function ($x) {
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
        /* foreach (QuaterlyOutput::all() as $key => $v) {
            //dd($v); 

            if($v->output!= null){
                continue; 
            }

            $ans = AnnualOutputHasActivity::where([
                'annual_output_id' => $v->work_plan->id
            ])->get();

            $v->key_output_id = $ans[rand(0, count($ans))]->id;
            $v->save();
        
            echo $v->id."<br>";
            die();
        }
        die("done"); */
        $form = new Form(new QuaterlyOutput());
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





        /* 
        $form->select('annual_id', __('Annual workplan'))->options(
            AnnualWorkplan::where([])->orderBy('id', 'desc')->get()->pluck('name', 'id')
        )->rules('required');
 */

        /*  $outs = []; 
        foreach (AnnualOutputHasActivity::where([])->orderBy('id', 'desc')->limit(200)->get() as $value) {
            $outs[$value->id] = $value->name_text;
        }
        
  */
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

        $topics = Topic
        ext_topics

        $form->multipleSelect('topic', __('Topics'))->required();
 

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

        return $form;
    }
}
