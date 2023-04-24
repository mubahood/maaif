<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\DailyActivity;
use App\Models\Group;
use App\Models\Location;
use App\Models\Person;
use App\Models\User;
use App\Models\Utils;
use Carbon\Carbon;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Form;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
use SplFileObject;

class HomeController extends Controller
{
    public function test(Content $content)
    {

        $this->dumpRequest($content);

        $content->title('Form 1');

        $form = new Widgets\Form();

        $form->method('get');

        $form->text('text');
        $form->email('email');
        $form->mobile('mobile', '电话');
        $form->url('url');
        $form->ip('ip');
        $form->color('color', '颜色');
        $form->number('number', '数字');
        $form->switch('switch', '开关');
        $form->textarea('text');
        $form->currency('currency');
        $form->rate('rate');

        $form->divider();

        $form->radio('radio')->options(['PHP', 'Java', 'Javascript'])->stacked();
        $form->checkbox('checkbox')->options(['PHP', 'Java', 'Javascript', 'C#', 'Python', 'Golang'])->canCheckAll();

        $content->body(new Widgets\Box('Form 1', $form));

        return $content;



        return $content;
    }
    public function index(Content $content)
    {


        $u = Auth::user();
        /*  $u->sendPasswordResetCode();
        die('Romina'); */
        $content
            ->title('MAAIF - extension')
            ->description('Hello ' . $u->name . "!");


        $u = Admin::user();


        $content->row(function (Row $row) {
            $row->column(3, function (Column $column) {
                $column->append(view('widgets.box-5', [
                    'is_dark' => false,
                    'title' => 'My members',
                    'sub_title' =>
                    number_format(User::where('gender', 'like', '%m%')->count()) . ' Males, ' .
                        number_format(User::where('gender', 'like', '%f%')->count()) . ' Females.',
                    'number' => number_format(User::where([])->count()),
                    'link' => 'my-members'
                ]));
            });
            $row->column(3, function (Column $column) {
                $column->append(view('widgets.box-5', [
                    'is_dark' => false,
                    'title' => 'Annual outputs',
                    'sub_title' => 'For this financial year.',
                    'number' => number_format(rand(50, 150)),
                    'link' => 'annual-outputs'
                ]));
            });
            $row->column(3, function (Column $column) {
                $column->append(view('widgets.box-5', [
                    'is_dark' => false,
                    'title' => 'My quarterly ',
                    'sub_title' => rand(100, 400) . ' new activies posted 7 days ago.',
                    'number' => number_format(rand(1000, 6000)),
                    'link' => 'quaterly-outputs'
                ]));
            });
            $row->column(3, function (Column $column) {
                $column->append(view('widgets.box-5', [
                    'is_dark' => true,
                    'title' => 'Evaluation',
                    'sub_title' =>  '143 Total activities, 132 activities done. ',
                    'number' => '94%',
                    'link' => 'javascript:;'
                ]));
            });
        });



        $content->row(function (Row $row) {
            $row->column(4, function (Column $column) {
                $column->append(view('dashboard.events', ['items' => DailyActivity::where([])->orderBy('id', 'desc')->limit(11)->get()]));
            });
            $row->column(4, function (Column $column) {
                $column->append(view('widgets.by-categories', []));
            });
            $row->column(4, function (Column $column) {
                $column->append(view('widgets.by-districts', []));
            });
        });


        return $content;

        $content->row(function (Row $row) {
            $row->column(6, function (Column $column) {
                $column->append(Dashboard::dashboard_members());
            });
            $row->column(3, function (Column $column) {
                $column->append(Dashboard::dashboard_events());
            });
            $row->column(3, function (Column $column) {
                $column->append(Dashboard::dashboard_news());
            });
        });




        return $content;
        return $content
            ->title('Dashboard')
            ->description('Description...')
            ->row(Dashboard::title())
            ->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
    }
}
