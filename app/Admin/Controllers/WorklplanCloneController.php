<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\WorklplanClone;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class WorklplanCloneController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Worklplan Cloning';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    protected function grid()
    {
        /*  WorklplanClone::do_cone(WorklplanClone::find(1));
        dd("dopne"); */
        $grid = new Grid(new WorklplanClone());

        $grid->model([
            'created_by' => Auth::user()->id
        ])->orderBy('id', 'desc');
        $grid->disableBatchActions();
        $grid->column('id', __('ID'))->sortable();
        $grid->column('source_id', __('Source'))
            ->display(function ($x) {
                $u = User::find($x);
                if ($u == null) {
                    return '-';
                }
                return $u->name;
            })
            ->sortable();
        $grid->column('destination_id', __('Destination'))
            ->display(function ($x) {
                $u = User::find($x);
                if ($u == null) {
                    return '-';
                }
                return $u->name;
            })
            ->sortable();
        $grid->column('description', __('Details'));
/*      $grid->column('processed', __('Processed')); */
        $grid->disableFilter();
        $grid->disableExport();
        $grid->actions(function ($x) {
            $x->disableEdit();
            $x->disableView();
        });
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
        $show = new Show(WorklplanClone::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('source_id', __('Source id'));
        $show->field('destination_id', __('Destination id'));
        $show->field('created_by', __('Created by'));
        $show->field('description', __('Description'));
        $show->field('processed', __('Processed'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WorklplanClone());

        $hasUser = false;
        if (isset($_GET['user'])) {
            $u_id = ((int)($_GET['user']));
            $officer = User::find($u_id);
            if ($officer != null) {
                $hasUser = true;
            }
        }

        $ajax_url = url(
            '/api/ajax?'
                . "search_by_1=name"
                . "&search_by_2=id"
                . "&model=User"
        );


        if ($hasUser) {
            $form->select('source_id', "Copy from Officer (Source)")
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
            $form->select('source_id', "Extension Officer")
                ->options(function ($id) {
                    $a = User::find($id);
                    if ($a) {
                        return [$a->id => "#" . $a->id . " - " . $a->name];
                    }
                })
                ->ajax($ajax_url)->rules('required');
        }


        $form->select('destination_id', "Copy to Officer (Destination)")
            ->options(function ($id) {
                $a = User::find($id);
                if ($a) {
                    return [$a->id => "#" . $a->id . " - " . $a->name];
                }
            })
            ->ajax($ajax_url)->rules('required');


        $form->hidden('created_by', __('Created by'))->default(Auth::user()->id);
        $form->radio('description', __('Are you sure you need to copy this year\'s work plan to selected officer?'))
            ->options(['Yes' => 'Yes'])->required();
        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();
        $form->disableReset();
        return $form;
    }
}
