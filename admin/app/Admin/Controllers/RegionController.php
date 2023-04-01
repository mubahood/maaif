<?php

namespace App\Admin\Controllers;

use App\Models\Region;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RegionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Regions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Region());

        $grid->disableActions();
        $grid->disableBatchActions();
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableColumnSelector(); 
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('capital', __('Capital'));
        $grid->column('area_km', __('Area km'));
        $grid->column('area_mil', __('Area mil'));
        $grid->column('elevation', __('Elevation'));
        $grid->column('districts', __('Districts'))->display(function(){
            return count($this->districts);
        });
        $grid->column('brief', __('Brief'))->hide();

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
        $show = new Show(Region::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('capital', __('Capital'));
        $show->field('area_km', __('Area km'));
        $show->field('area_mil', __('Area mil'));
        $show->field('elevation', __('Elevation'));
        $show->field('brief', __('Brief'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Region());

        $form->text('name', __('Name'));
        $form->text('capital', __('Capital'));
        $form->text('area_km', __('Area km'));
        $form->text('area_mil', __('Area mil'));
        $form->text('elevation', __('Elevation'));
        $form->textarea('brief', __('Brief'));

        return $form;
    }
}
