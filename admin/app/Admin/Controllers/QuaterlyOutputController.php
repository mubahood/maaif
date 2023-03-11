<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\AnnualOutput;
use App\Models\AnnualWorkplan;
use App\Models\QuaterlyOutput;
use App\Models\User;
use App\Models\Utils;
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
        $form = new Form(new QuaterlyOutput());
        $ajax_url = url(
            '/api/ajax?'
                . "search_by_1=name"
                . "&search_by_2=id"
                . "&model=User"
        );
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


        $form->select('annual_workplan_id', __('Annual workplan'))->options(
            AnnualWorkplan::where([])->orderBy('id', 'desc')->get()->pluck('name', 'id')
        )->rules('required');


        $ajax_url = url(
            '/api/ajax?'
                . "search_by_1=year"
                . "&search_by_2=id"
                . "&model=AnnualOutput"
        );
        $form->multipleSelect('annual_id', "Outputs")
            ->options(function ($id) {
                $a = AnnualOutput::find($id);
                if ($a) {
                    return [$a->id => "#" . $a->id . " - " . $a->name];
                }
            })
            ->ajax($ajax_url)->rules('required');

        $form->text('topic', __('Outputs to Fullfill'))
            ->options(AnnualOutput::getArray(Auth::user()->id))
            ->rules('required');



        $form->text('key_output_id', __('key_output_id'));
        $form->text('entreprizes', __('Entreprizes'));
        $form->number('num_planned', __('Num planned'));
        $form->number('num_target_ben', __('Num target ben'));
        $form->number('num_carried_out', __('Num carried out'));
        $form->number('num_reached_ben', __('Num reached ben'));
        $form->textarea('remarks', __('Remarks'));
        $form->textarea('lessons', __('Lessons'));
        $form->textarea('recommendations', __('Recommendations'));
        $form->number('budget', __('Budget'));

        $form->number('quarter', __('Quarter'));

        return $form;
    }
}
