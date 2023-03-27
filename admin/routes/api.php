<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiResurceController;
use App\Models\AnnualOutput;
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

Route::get('AnnualOutputController', function (Request $r) {

    $data = [];
    $ans = AnnualOutput::where(
        'key_output',
        'like',
        "%$r->q%"
    )
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
