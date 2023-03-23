<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\AnnualOutput;
use App\Models\AnnualWorkplan;
use App\Models\User;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AnnualOutputController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Annual outputs';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new AnnualOutput());


        $grid->filter(function ($filter) {
            // Remove the default id filter
            $filter->disableIdFilter();

            $filter->equal('annual_workplan_id', 'Filter by Workplan')
                ->select(AnnualWorkplan::where([])->orderBy('id', 'desc')->get()->pluck('name', 'id'));


            $ajax_url = url(
                '/api/ajax?'
                    . "search_by_1=name"
                    . "&search_by_2=id"
                    . "&model=User"
            );
            $filter->equal('user_id', 'Filter by account')
                ->select(function ($id) {
                    $a = User::find($id);
                    if ($a) {
                        return [$a->id => "#" . $a->id . " - " . $a->name];
                    }
                })->ajax($ajax_url);
            $filter->between('created_at', 'Filter by date between')->date();
            $filter->group('budget', 'Filter by Budget', function ($group) {
                $group->gt('greater than');
                $group->lt('less than');
                $group->equal('equal to');
            });
        });


        $grid->model()->orderBy('id', 'desc');
        $grid->disableBatchActions();

        $grid->column('id', __('ID'))->sortable()->hide();
        $grid->column('created_at', __('Date'))->display(function ($x) {
            return Utils::my_date($x);
        })->sortable();
        $grid->column('annual_workplan_id', __('Annual workplan'))->display(function () {
            return $this->annual_workplan->name;
        })->sortable();
        $grid->column('user_id', __('Extension Officer'))->display(function () {
            return $this->user->name;
        })->sortable();
        $grid->column('key_output', __('Key output'))->hide();
        $grid->column('activities_text', __('Activities'))
            ->display(function ($x) {
                return '<span title="' . $x . '">' . Str::limit($x, 50, '...') . '</span>';
            });
        $grid->column('indicators', __('Indicators'))->hide();
        $grid->column('target', __('Target'))->hide();
        $grid->column('year', __('Year'))->hide();
        $grid->column('budget', __('Budget (UGX )'))
            ->display(function ($x) {
                return '<b>' . number_format($x) . '</b>';
            })->totalRow(function ($x) {
                return '<b>' . number_format($x) . '</b>';
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
        $show = new Show(AnnualOutput::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('key_output', __('Key output'));
        $show->field('activities', __('Activities'));
        $show->field('indicators', __('Indicators'));
        $show->field('target', __('Target'));
        $show->field('year', __('Year'));
        $show->field('budget', __('Budget'));
        $show->field('user_id', __('User id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AnnualOutput());


        //$form->select('year', __('Financial Year'))->options(YEARS)->rules('required');
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
            ->ajax($ajax_url)->rules('required');

        $form->select('annual_workplan_id', __('Select Annual workplan'))->options(
            AnnualWorkplan::where([])->orderBy('id', 'desc')->get()->pluck('name', 'id')
        )->rules('required');


        $form->textarea('key_output', __('Key output'))->rules('required');


        $form->listbox('output_activities', 'Select Activities')->options(Activity::all()->pluck('name_text', 'id'))
            ->help("Select offences involded in this case")
            ->rules('required');


        /* $form->multipleSelect('activities', __('Planned Activities'))
            ->options(Activity::getArray()) 
            ->rules('required'); */
        $form->textarea('indicators', __('Indicators'))->rules('required');
        $form->textarea('target', __('Key targets'))
            ->rules('required');

        $form->decimal('budget', __('Budget'))->rules('required');




        return $form;
    }
}
