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

    $router->resource('members-new', MemberController::class);

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
