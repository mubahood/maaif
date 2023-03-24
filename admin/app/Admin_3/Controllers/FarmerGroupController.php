<?php

namespace App\Admin\Controllers;

use App\Models\FarmerGroup;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FarmerGroupController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'FarmerGroup';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FarmerGroup());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('id_str', __('Id str'));
        $grid->column('name', __('Name'));
        $grid->column('lat', __('Lat'));
        $grid->column('lng', __('Lng'));
        $grid->column('parish_id', __('Parish id'));
        $grid->column('a1', __('A1'));
        $grid->column('a2', __('A2'));
        $grid->column('a3', __('A3'));
        $grid->column('a4', __('A4'));
        $grid->column('a5', __('A5'));
        $grid->column('a6', __('A6'));
        $grid->column('a7', __('A7'));
        $grid->column('a8', __('A8'));
        $grid->column('a9', __('A9'));
        $grid->column('a10', __('A10'));
        $grid->column('a11', __('A11'));
        $grid->column('a12', __('A12'));
        $grid->column('a13', __('A13'));
        $grid->column('a14', __('A14'));
        $grid->column('a15', __('A15'));
        $grid->column('a16', __('A16'));
        $grid->column('a17', __('A17'));
        $grid->column('a18', __('A18'));
        $grid->column('a19', __('A19'));
        $grid->column('a20', __('A20'));
        $grid->column('a21', __('A21'));
        $grid->column('a22', __('A22'));
        $grid->column('a23', __('A23'));
        $grid->column('a24', __('A24'));
        $grid->column('a25', __('A25'));
        $grid->column('a26', __('A26'));
        $grid->column('a27', __('A27'));
        $grid->column('a28', __('A28'));
        $grid->column('a29', __('A29'));
        $grid->column('a30', __('A30'));

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
        $show = new Show(FarmerGroup::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('id_str', __('Id str'));
        $show->field('name', __('Name'));
        $show->field('lat', __('Lat'));
        $show->field('lng', __('Lng'));
        $show->field('parish_id', __('Parish id'));
        $show->field('a1', __('A1'));
        $show->field('a2', __('A2'));
        $show->field('a3', __('A3'));
        $show->field('a4', __('A4'));
        $show->field('a5', __('A5'));
        $show->field('a6', __('A6'));
        $show->field('a7', __('A7'));
        $show->field('a8', __('A8'));
        $show->field('a9', __('A9'));
        $show->field('a10', __('A10'));
        $show->field('a11', __('A11'));
        $show->field('a12', __('A12'));
        $show->field('a13', __('A13'));
        $show->field('a14', __('A14'));
        $show->field('a15', __('A15'));
        $show->field('a16', __('A16'));
        $show->field('a17', __('A17'));
        $show->field('a18', __('A18'));
        $show->field('a19', __('A19'));
        $show->field('a20', __('A20'));
        $show->field('a21', __('A21'));
        $show->field('a22', __('A22'));
        $show->field('a23', __('A23'));
        $show->field('a24', __('A24'));
        $show->field('a25', __('A25'));
        $show->field('a26', __('A26'));
        $show->field('a27', __('A27'));
        $show->field('a28', __('A28'));
        $show->field('a29', __('A29'));
        $show->field('a30', __('A30'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FarmerGroup());

        $form->text('id_str', __('Id str'));
        $form->text('name', __('Name'));
        $form->decimal('lat', __('Lat'));
        $form->decimal('lng', __('Lng'));
        $form->number('parish_id', __('Parish id'));
        $form->text('a1', __('A1'));
        $form->text('a2', __('A2'));
        $form->text('a3', __('A3'));
        $form->text('a4', __('A4'));
        $form->text('a5', __('A5'));
        $form->text('a6', __('A6'));
        $form->text('a7', __('A7'));
        $form->text('a8', __('A8'));
        $form->text('a9', __('A9'));
        $form->text('a10', __('A10'));
        $form->text('a11', __('A11'));
        $form->text('a12', __('A12'));
        $form->text('a13', __('A13'));
        $form->text('a14', __('A14'));
        $form->text('a15', __('A15'));
        $form->text('a16', __('A16'));
        $form->text('a17', __('A17'));
        $form->text('a18', __('A18'));
        $form->text('a19', __('A19'));
        $form->text('a20', __('A20'));
        $form->text('a21', __('A21'));
        $form->text('a22', __('A22'));
        $form->text('a23', __('A23'));
        $form->text('a24', __('A24'));
        $form->text('a25', __('A25'));
        $form->text('a26', __('A26'));
        $form->text('a27', __('A27'));
        $form->text('a28', __('A28'));
        $form->text('a29', __('A29'));
        $form->text('a30', __('A30'));

        return $form;
    }
}
