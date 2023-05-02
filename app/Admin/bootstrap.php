<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use App\Models\Utils;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Auth;
use App\Admin\Extensions\Nav\Shortcut;
use App\Admin\Extensions\Nav\Dropdown;
use App\Models\FinancialYear;


if (isset($_GET['change_dpy_to'])) {
    $ay = ((int)(trim($_GET['change_dpy_to'])));
    if ($ay != null) {
        $fy = FinancialYear::find($ay);
        if ($fy != null) {
            $fy->active = 1;
            $fy->save();
        }

        $red_link = admin_url();
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != null && strlen($_SERVER['HTTP_REFERER']) > 10) {
            $red_link = $_SERVER['HTTP_REFERER'];
        }
        Admin::disablePjax();
        header('location: ' . $red_link);
        die();
    }
}

Utils::system_boot();


Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {

    $u = Auth::user();
    $navbar->left(view('admin.search-bar', [
        'u' => $u
    ]));

    $navbar->left(Shortcut::make([
        'Daily activity' => '#',
        'Quarterly activity' => 'products/create',
        'New evaluation' => 'jobs/create',
    ], 'fa-plus')->title('ADD NEW'));


    $navbar->left(new Dropdown());

    $navbar->right(Shortcut::make([
        'How to update your profile' => '',
        'How to update change your password' => '',
        'How to update download mobile App' => '',
        'How to ............ ' => '',
        'How to ............ ' => '',
        'How to ............ ' => '',
        'How to ............ ' => '',
    ], 'fa-question')->title('HELP'));



/*     $navbar->right(view('widgets.admin-links', [
        'years' => FinancialYear::where([])->orderby('id', 'desc')->get(),
    ])); */
});




Encore\Admin\Form::forget(['map', 'editor']);
Admin::css(url('/assets/css/bootstrap.css'));
Admin::css('/assets/css/styles.css');
Admin::js('/js/charts.js');
