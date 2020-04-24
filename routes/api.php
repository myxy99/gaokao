<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//汤海
Route::prefix('schoolselect')->namespace('SchoolSelect')->group(function () {
    Route::get('getbatch', 'SelectController@GetBatch');//获取批次
    Route::get('getprovince', 'SelectController@GetProvince');//获取学校省份
    Route::get('getschoolbyconditions', 'SelectController@GetSchoolByConditions');//按照条件获取学校信息
    Route::get('getschoolbyname', 'SelectController@GetSchoolByName');//根据学校名称查询学校

});
//汤海
Route::prefix('volunteerhtml')->namespace('VolunteerHtml')->group(function () {
    Route::get('getvolunteerhtml', 'VolunteerController@GetVolunteerHtml');//获取志愿填报页面

});

//欧阳生林
Route::prefix('schoolRmd')->namespace('SchoolRmd')->group(function () {
    Route::get('getRmd', 'SchoolRmdController@getRmd');//获取动图学校信息
});

Route::prefix('user')->namespace('User')->group(
    function () {
        Route::get('getInfo', 'SchoolInfoController@getInfo');//获取学校详情
        Route::get('suggest', 'SuggestController@suggest');//查询学校推荐
    });
