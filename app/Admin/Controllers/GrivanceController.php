<?php

namespace App\Admin\Controllers;

use App\Models\Grivance;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GrivanceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Grivance';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Grivance());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('parish_id', __('Parish id'));
        $grid->column('complainant_name', __('Complainant name'));
        $grid->column('complainant_age', __('Complainant age'));
        $grid->column('complainant_gender', __('Complainant gender'));
        $grid->column('complainant_phone', __('Complainant phone'));
        $grid->column('complainant_feedback_mode', __('Complainant feedback mode'));
        $grid->column('complainant_anonymous', __('Complainant anonymous'));
        $grid->column('date_of_grivance', __('Date of grivance'));
        $grid->column('grievance_nature_id', __('Grievance nature id'));
        $grid->column('grivance_type_id', __('Grivance type id'));
        $grid->column('grievance_type_if_not_specified', __('Grievance type if not specified'));
        $grid->column('mode_of_receipt_id', __('Mode of receipt id'));
        $grid->column('description', __('Description'));
        $grid->column('past_actions', __('Past actions'));
        $grid->column('gps_latitude', __('Gps latitude'));
        $grid->column('gps_longitude', __('Gps longitude'));
        $grid->column('ref_number', __('Ref number'));
        $grid->column('days_at_sgrc', __('Days at sgrc'));
        $grid->column('days_at_dgrc', __('Days at dgrc'));
        $grid->column('days_at_ngrc', __('Days at ngrc'));
        $grid->column('grivance_status_id', __('Grivance status id'));
        $grid->column('grievance_settlement_id', __('Grievance settlement id'));
        $grid->column('date_dgrc', __('Date dgrc'));
        $grid->column('date_ngrc', __('Date ngrc'));

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
        $show = new Show(Grivance::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('parish_id', __('Parish id'));
        $show->field('complainant_name', __('Complainant name'));
        $show->field('complainant_age', __('Complainant age'));
        $show->field('complainant_gender', __('Complainant gender'));
        $show->field('complainant_phone', __('Complainant phone'));
        $show->field('complainant_feedback_mode', __('Complainant feedback mode'));
        $show->field('complainant_anonymous', __('Complainant anonymous'));
        $show->field('date_of_grivance', __('Date of grivance'));
        $show->field('grievance_nature_id', __('Grievance nature id'));
        $show->field('grivance_type_id', __('Grivance type id'));
        $show->field('grievance_type_if_not_specified', __('Grievance type if not specified'));
        $show->field('mode_of_receipt_id', __('Mode of receipt id'));
        $show->field('description', __('Description'));
        $show->field('past_actions', __('Past actions'));
        $show->field('gps_latitude', __('Gps latitude'));
        $show->field('gps_longitude', __('Gps longitude'));
        $show->field('ref_number', __('Ref number'));
        $show->field('days_at_sgrc', __('Days at sgrc'));
        $show->field('days_at_dgrc', __('Days at dgrc'));
        $show->field('days_at_ngrc', __('Days at ngrc'));
        $show->field('grivance_status_id', __('Grivance status id'));
        $show->field('grievance_settlement_id', __('Grievance settlement id'));
        $show->field('date_dgrc', __('Date dgrc'));
        $show->field('date_ngrc', __('Date ngrc'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Grivance());

        $form->number('parish_id', __('Parish id'));
        $form->text('complainant_name', __('Complainant name'));
        $form->number('complainant_age', __('Complainant age'));
        $form->text('complainant_gender', __('Complainant gender'));
        $form->text('complainant_phone', __('Complainant phone'));
        $form->number('complainant_feedback_mode', __('Complainant feedback mode'));
        $form->switch('complainant_anonymous', __('Complainant anonymous'));
        $form->date('date_of_grivance', __('Date of grivance'))->default(date('Y-m-d'));
        $form->number('grievance_nature_id', __('Grievance nature id'));
        $form->number('grivance_type_id', __('Grivance type id'));
        $form->textarea('grievance_type_if_not_specified', __('Grievance type if not specified'));
        $form->number('mode_of_receipt_id', __('Mode of receipt id'));
        $form->textarea('description', __('Description'));
        $form->textarea('past_actions', __('Past actions'));
        $form->text('gps_latitude', __('Gps latitude'));
        $form->text('gps_longitude', __('Gps longitude'));
        $form->text('ref_number', __('Ref number'));
        $form->number('days_at_sgrc', __('Days at sgrc'));
        $form->number('days_at_dgrc', __('Days at dgrc'));
        $form->number('days_at_ngrc', __('Days at ngrc'));
        $form->number('grivance_status_id', __('Grivance status id'));
        $form->number('grievance_settlement_id', __('Grievance settlement id'))->default(7);
        $form->date('date_dgrc', __('Date dgrc'))->default(date('Y-m-d'));
        $form->date('date_ngrc', __('Date ngrc'))->default(date('Y-m-d'));

        return $form;
    }
}
