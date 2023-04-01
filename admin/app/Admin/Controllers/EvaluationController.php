<?php

namespace App\Admin\Controllers;

use App\Models\AnnualWorkplan;
use App\Models\QuaterlyOutput;
use App\Models\User;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EvaluationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Evaluation';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $m = QuaterlyOutput::where([])->orderBy('id', 'desc')->first();
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
        })->hide()->sortable();


        $grid->column('user_id', __('Officer'))->display(function ($x) {
            if ($this->user == null) {
                return $x;
            }
            return $this->user->id . ". " . $this->user->name;
        })->sortable();





        $grid->column('annual_id', __('Annual Output'))
            ->display(function ($x) {
                if ($this->output == null) {
                    return $x;
                }
                return '<p title="' . $this->output->name_text . '">' . Str::limit($this->output->name_text, 45) . '</p>';
            })->sortable();
        $grid->column('quarter', __('Quarter'))->display(function ($x) {
            return '<b>' . Utils::addOrdinalSuffix($x) . '</b>';
        })->filter([
            '1' => '1st Quarter',
            '2' => '4th Quarter',
            '3' => '3rd Quarter',
            '4' => '4th Quarter',
        ])->sortable();


        $grid->column('topic', __('Topics'))->display(function ($x) {

            return '<p title="' . $this->topic_text . '">' . Str::limit($this->topic_text, 45) . '</p>';
        });


        $grid->column('num_target_ben', __('No. target'))->sortable();
        $grid->column('num_reached', __('No. reached'));


        $grid->column('budget', __('Budget'))
            ->display(function ($x) {
                return '<b>UGX ' . number_format($x) . '</b>';
            })->totalRow(function ($x) {
                return '<b>UGX ' . number_format($x) . '</b>';
            })->hide()->sortable();

        $grid->disableActions();
        $grid->disableCreateButton();

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
        $form = new Form(new QuaterlyOutput());

        $form->text('topic', __('Topic'));
        $form->text('entreprizes', __('Entreprizes'));
        $form->number('num_planned', __('Num planned'));
        $form->number('num_target_ben', __('Num target ben'));
        $form->number('num_carried_out', __('Num carried out'));
        $form->number('num_reached_ben', __('Num reached ben'));
        $form->textarea('remarks', __('Remarks'));
        $form->textarea('lessons', __('Lessons'));
        $form->textarea('recommendations', __('Recommendations'));
        $form->number('budget', __('Budget'));
        $form->number('annual_id', __('Annual id'));
        $form->number('quarter', __('Quarter'));
        $form->number('user_id', __('User id'));
        $form->text('key_output_id', __('Key output id'));

        return $form;
    }
}
