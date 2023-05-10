<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiResurceController;
use App\Models\AnnualOutput;
use App\Models\County;
use App\Models\QuaterlyOutput;
use App\Models\Subcounty;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::POST("users/login", [ApiAuthController::class, "login"]);
Route::POST("people", [ApiResurceController::class, "person_create"]);
Route::get("people", [ApiResurceController::class, "people"]);
Route::get('api/{model}', [ApiResurceController::class, 'index']);
Route::get('groups', [ApiResurceController::class, 'groups']);





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Route::get('annual-activities', function (Request $r) { 
{
    $provinceId = $request->get('q');
    $a = AnnualOutput::find($id); 
    return Ann::city()->where('parent_id', $provinceId)->get(['id', DB::raw('name as text')]);
}
 */

Route::get('QuaterlyOutputTopics', function (Request $r) { 

    $query = QuaterlyOutput::find($r->q);
    $data = [];
    if($query != null){
        foreach ($query->topics as $key => $v) {
            $data[] = [
                'id' => $key,
                'text' => $v
            ];
        }  
    }
   
    return [
        'data' => $data
    ];
});


Route::get('Subcounty', function (Request $r) { 
    $district_id = 0;
    if (isset($_GET['district_id'])) {
        $district_id = ((int)($_GET['district_id']));
    }

    $data = [];
    $query = Subcounty::where(
        'name',
        'like',
        "%$r->q%"
    );

    if ($district_id > 0) {
        $counties = [];
        foreach (County::where([
            'district_id' => $district_id
        ])->get() as $key => $county) {
            $counties[] = $county->id;
        }
        
        $query->where('county_id',$counties);
    }

    $query->orderBy('id', 'Desc')
        ->limit(30);

    $ans = $query
        ->get();

    if ($ans == null) {
        return [];
    }


    foreach ($ans as $v) {
        $data[] = [
            'id' => $v->id,
            'text' =>  $v->name_text
        ];
    }
    return [
        'data' => $data
    ];
});


Route::get('usersByDistrict', function (Request $r) {
    $data = [];
    $ans = Administrator::where(
        'name',
        'like',
        "%$r->q%"
    )
        ->where([
            'district_id' => $_GET['district_id'],
            'department_id' => $_GET['department_id'],
        ])
        ->orderBy('name', 'Asc')
        ->limit(30)
        ->get();

    if ($ans == null) {
        return [];
    }


    foreach ($ans as $v) {
        $data[] = [
            'id' => $v->id,
            'text' => '#' . $v->id . " - " . $v->name . ", " . $v->district->name . ', ' . $v->department->department
        ];
    }
    return [
        'data' => $data
    ];
});


Route::get('AnnualOutputController', function (Request $r) {
    $data = [];
    $ans = AnnualOutput::where(
        'key_output',
        'like',
        "%$r->q%"
    )
        ->where([
            'district_id' => $_GET['district_id'],
            'department_id' => $_GET['department_id'],
            'year' => $_GET['year'],
        ])
        ->orderBy('id', 'Desc')
        ->limit(30)
        ->get();

    if ($ans == null) {
        return [];
    }


    foreach ($ans as $v) {
        $data[] = [
            'id' => $v->id,
            'text' => $v->id . " - " . $v->annual_workplan->name . " - " . str_replace(['\n', '\r'], '', $v->key_output)
        ];
    }
    return [
        'data' => $data
    ];
});

Route::get('AnnualOutputHasActivity', function (Request $r) {

    $data = [];
    $an = AnnualOutput::where([
        'id' => ((int)($r->q))
    ])->first();

    if ($an == null) {
        return [];
    }

    foreach ($an->output_activities as $v) {
        $data[] = [
            'id' => $v->id,
            'text' => $v->name_text
        ];
    }
    return [
        'data' => $data
    ];
});
Route::get('ajax', function (Request $r) {

    $_model = trim($r->get('model'));
    $conditions = [];
    foreach ($_GET as $key => $v) {
        if (substr($key, 0, 6) != 'query_') {
            continue;
        }
        $_key = str_replace('query_', "", $key);
        $conditions[$_key] = $v;
    }

    if (strlen($_model) < 2) {
        return [
            'data' => []
        ];
    }

    $model = "App\Models\\" . $_model;
    $search_by_1 = trim($r->get('search_by_1'));
    $search_by_2 = trim($r->get('search_by_2'));

    $q = trim($r->get('q'));

    $res_1 = $model::where(
        $search_by_1,
        'like',
        "%$q%"
    )
        ->where($conditions)
        ->limit(20)->get();
    $res_2 = [];

    if ((count($res_1) < 20) && (strlen($search_by_2) > 1)) {
        $res_2 = $model::where(
            $search_by_2,
            'like',
            "%$q%"
        )
            ->where($conditions)
            ->limit(20)->get();
    }

    $data = [];
    foreach ($res_1 as $key => $v) {
        $name = "";
        if (isset($v->name)) {
            $name = " - " . $v->name;
        } else {
            $name = " - " . $v->$search_by_1;
        }
        $data[] = [
            'id' => $v->id,
            'text' => "#$v->id" . $name
        ];
    }
    foreach ($res_2 as $key => $v) {
        $name = "";
        if (isset($v->name)) {
            $name = " - " . $v->name;
        } else {
            $name = " - " . $v->$search_by_1;
        }
        $data[] = [
            'id' => $v->id,
            'text' => "#$v->id" . $name
        ];
    }

    return [
        'data' => $data
    ];
});


Route::get('ajax-by-id', function (Request $r) {

    $_model = trim($r->get('model'));
    $id = ((int)($r->q));
 

    $model = "App\Models\\" . $_model;
    $search_by_1 = trim($r->get('search_by_1'));
    $search_by_2 = trim($r->get('search_by_2'));

    $res_1 = $model::where([
         $search_by_2 => $id
    ])
        ->limit(20)->get(); 


    $data = [];
    foreach ($res_1 as $key => $v) {
        $name = "";
        if (isset($v->name)) {
            $name =  $v->name;
        } else {
            $name =  $v->$search_by_1;
        }
        $data[] = [
            'id' => $v->id,
            'text' => $name
        ];
    }
 

    return [
        'data' => $data
    ];
});
