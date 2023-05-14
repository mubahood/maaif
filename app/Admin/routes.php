<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->get('forms/form-1', 'FormController@form1');
    $router->get('forms/form-2', 'FormController@form2');
    $router->get('forms/form-3', 'FormController@form3');
    $router->get('forms/form-4', 'FormController@form4');
    $router->get('forms/settings', 'FormController@settings');
    $router->get('forms/register', 'FormController@register');
    


    $router->resource('districts', DistrictController::class);


    $router->resource('annual-outputs', AnnualOutputController::class);
    $router->resource('quaterly-outputs', QuaterlyOutputController::class);
    $router->resource('daily-activities', DailyActivityController::class);
    $router->resource('evaluations', EvaluationController::class);
    $router->resource('area-profiles', AreaProfileController::class);
    $router->resource('popular-commodities', PopularCommodityController::class);
    $router->resource('potenial-commodities', PotenialCommodityController::class);
    $router->resource('farmers', FarmerController::class);
    $router->resource('farmer-groups', FarmerGroupController::class);
    $router->resource('farmer-questions', FarmerQuestionController::class);
    $router->resource('advisory-alerts', AdvisoryAlertController::class);
    $router->resource('grievances', GrivanceController::class);
    $router->resource('meetings', MeetingController::class);
    $router->resource('activities', ActivityController::class);
    $router->resource('activity-categories', ActivityCategoryController::class);
    $router->resource('departments', DepartmentController::class);
    $router->resource('annual-workplans', AnnualWorkplanController::class);
    $router->resource('ext-topics', ExtTopicController::class);
    $router->resource('my-members', MyMemberController::class);
    $router->resource('users', UserController::class);
    $router->resource('financial-years', FinancialYearController::class);
    $router->resource('worklplan-clones', WorklplanCloneController::class);
    $router->resource('regions', RegionController::class);
    $router->resource('counties', CountyController::class);
    $router->resource('sub-counties', SubcountyController::class);
    $router->resource('parishes', ParishController::class);
    $router->resource('villages', VillageController::class);
    $router->resource('topics', ExtTopicController::class);
    $router->resource('system-configs', SystemCinfigController::class);
    $router->resource('directorates', DirectorateController::class);
    $router->resource('ministry-departments', MinistryDepartmentController::class);
    $router->resource('ministry-divisions', MinistryDivisionController::class);
    $router->resource('positions', PositionController::class);

    $router->resource('report-annual-workplans', ReportAnnualWorkplanController::class);
    $router->resource('report-departments', ReportDepartmentController::class);
    $router->resource('report-districts', ReportDistrictController::class);
    $router->resource('report-generators', ReportGeneratorController::class);
    $router->resource('report-members', OfficerReportController::class);  

    /* =============NEW=============== */
    $router->resource('service-providers', ServiceProviderController::class);
    $router->resource('groups', GroupController::class);
    $router->resource('associations', AssociationController::class);
    $router->resource('people', PersonController::class);
    $router->resource('disabilities', DisabilityController::class);
    $router->resource('institutions', InstitutionController::class);
    $router->resource('counselling-centres', CounsellingCentreController::class);
    $router->resource('jobs', JobController::class);
    $router->resource('job-applications', JobApplicationController::class);

    $router->resource('course-categories', CourseCategoryController::class);
    $router->resource('courses', CourseController::class);
    $router->resource('settings', UserController::class);
    $router->resource('participants', ParticipantController::class);
    $router->resource('members', MembersController::class);
    $router->resource('post-categories', PostCategoryController::class);
    $router->resource('news-posts', NewsPostController::class);
    $router->resource('events', EventController::class);
    $router->resource('event-bookings', EventBookingController::class);
    $router->resource('products', ProductController::class);
    $router->resource('product-orders', ProductOrderController::class);

});
