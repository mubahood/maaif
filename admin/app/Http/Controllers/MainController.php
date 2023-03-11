<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Event;
use App\Models\NewsPost;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;

class MainController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index()
    {

    /*     die("<h1>Something really cool is coming soon! 🥰</h1>"); */
        $members = Administrator::where([])->orderBy('updated_at', 'desc')->limit(8)->get();
        $profiles = [];
        $_profiles = [];
        foreach (Administrator::where([])->orderBy('updated_at', 'desc')->limit(15)->get() as $key => $v) {
            $profiles[] = $v;
        }

        foreach ($profiles as $key => $pro) {
            if ($pro->intro == null || strlen($pro->intro) < 3) {
                $pro->intro = "Hi there, I'm $pro->name . I call upon you to join the team!";
            }
            $_profiles[] = $pro;
        }

        $posts = [];
        foreach (NewsPost::all() as $key => $v) {
            $posts[] = $v;
        }
        shuffle($posts);
        $_posts = [];
        $i = 0;
        foreach ($posts as $key => $v) {
            $_posts[] = $v;
            $i++;
            if ($i > 2) {
                break;
            }
        }

        return view('index', [
            'members' => $members,
            'profiles' => $_profiles,
            'posts' => $_posts,
        ]);
    }
    public function about_us()
    {
        return view('about-us');
    }
    public function our_team()
    {
        return view('our-team');
    }
    public function news_category()
    {
        return view('news-category');
    }

    public function dinner()
    {
        $p = Event::find(1);
        if ($p == null) {
            die("Post not found.");
        }
        return view('dinner', [
            'd' => $p
        ]);
    }

    public function news(Request $r)
    {
        $p = NewsPost::find($r->id);
        if ($p == null) {
            die("Post not found.");
        }

        $posts = [];
        foreach (NewsPost::all() as $key => $v) {
            $posts[] = $v;
        }
        shuffle($posts);
        $_posts = [];
        $i = 0;
        foreach ($posts as $key => $v) {
            $_posts[] = $v;
            $i++;
            if ($i > 2) {
                break;
            }
        }

        return view('news-post', [
            'p' => $p,
            'post' => $p,
            'posts' => $_posts,
        ]);
    }
    public function members()
    {
        $members = Administrator::where([])->orderBy('id', 'desc')->limit(12)->get();
        return view('members', [
            'members' => $members
        ]);
    }


    function generate_variables()
    {
        $data = '
id
created_at
association_id
administrator_id
administrator_text
association_text
group_id
group_text
name
address
parish
village
phone_number
email
district_id
district_text
subcounty_id
subcounty_text
disability_id
disability_text
phone_number_2
dob
sex
education_level
employment_status
has_caregiver
caregiver_name
caregiver_sex
caregiver_phone_number
caregiver_age
caregiver_relationship
photo
deleted_at
status
        ';

        $recs = preg_split('/\r\n|\n\r|\r|\n/', $data);
        MainController::createNew($recs);
        MainController::from_json($recs);
        MainController::fromJson($recs);
        MainController::generate_vars($recs);
        MainController::create_table($recs, 'people');
        //MainController::to_json($recs);
    }


    function createNew($recs)
    {

        $_data = "";

        foreach ($recs as $v) {
            $key = trim($v);

            $_data .= "\$obj->{$key} =  \$r->{$key};<br>";
        }

        print_r($_data);
        die("");
    }


    function fromJson($recs)
    {

        $_data = "";

        foreach ($recs as $v) {
            $key = trim($v);

            if ($key == 'id') {
                $_data .= "obj.{$key} = Utils.int_parse(m['{$key}']);<br>";
            } else {
                $_data .= "obj.{$key} = Utils.to_str(m['{$key}'],'');<br>";
            }
        }

        print_r($_data);
        die("");
    }



    function create_table($recs, $table_name)
    {

        $_data = "CREATE TABLE  IF NOT EXISTS  $table_name (  ";
        $i = 0;
        $len = count($recs);
        foreach ($recs as $v) {
            $key = trim($v);

            if ($key == 'id') {
                $_data .= 'id INTEGER PRIMARY KEY';
            } else {
                $_data .= " $key TEXT";
            }

            $i++;
            if ($i != $len) {
                $_data .= ',';
            }
        }

        $_data .= ')';
        print_r($_data);
        die("");
    }


    function from_json($recs)
    {

        $_data = "";
        foreach ($recs as $v) {
            $key = trim($v);
            if (strlen($key) < 2) {
                continue;
            }
            $_data .= "$key : $key,<br>";
        }

        echo "<pre>";
        print_r($_data);
        die("");
    }


    function to_json($recs)
    {
        $_data = "";
        foreach ($recs as $v) {
            $key = trim($v);
            if (strlen($key) < 2) {
                continue;
            }
            $_data .= "'$key' : $key,<br>";
        }

        echo "<pre>";
        print_r($_data);
        die("");
    }

    function generate_vars($recs)
    {

        $_data = "";
        foreach ($recs as $v) {
            $key = trim($v);
            if (strlen($key) < 2) {
                continue;
            }
            $_data .= "String $key = \"\";<br>";
        }

        echo "<pre>";
        print_r($_data);
        die("");
    }
}
