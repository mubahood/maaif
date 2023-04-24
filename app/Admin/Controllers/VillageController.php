<?php

namespace App\Admin\Controllers;

use App\Models\County;
use App\Models\Parish;
use App\Models\Region;
use App\Models\Subcounty;
use App\Models\Village;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VillageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Parishes';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Village());

        $grid->disableActions();
        $grid->disableBatchActions();
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->quickSearch('name')->placeholder('Search by name...');
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('parish_id', __('Parish'))->display(function ($x) {
            if ($this->parish == null) {
                return $x;
            }
            return $this->parish->name;
        })->sortable();
        /*  $grid->column('districts', __('Sub counties'))->display(function () {
            return count($this->sub_counties);
        }); */
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
        $show = new Show(Village::findOrFail($id));

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
        $form = new Form(new Village());

        $form->text('name', __('Name'));

        return $form;
    }
}
