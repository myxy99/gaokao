<?php

namespace App\Http\Controllers\SchoolSelect;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolSelect\GetSchoolByConditionsRequest;
use App\Http\Requests\SchoolSelect\GetSchoolByNameRequest;
use App\Models\Batch;
use App\Models\Province;
use App\Models\School;
use Illuminate\Http\Request;

class SelectController extends Controller
{
    /***
     * 获取批次
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function GetBatch(Request $request){
        $data = Batch::getAllBath($request['batch']);
        return $data == null ?
            response()->fail(100, '失败') :
            response()->success(200, '成功', $data);
    }

    /***
     * 获取省份
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function GetProvince(Request $request){
        $data = Province::getAllProvince($request['province']);
        return $data == null ?
            response()->fail(100, '失败') :
            response()->success(200, '成功', $data);
    }

    /***
     * 按照批次地区获取学校
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function GetSchoolByConditions(Request $request){
        $data = School::getGetSchool($request['province'],$request['batch']);
        return $data == null ?
            response()->fail(100, '失败') :
            response()->success(200, '成功', $data);

    }

    /***
     * 根据学校名称查询学校
     * @param GetSchoolByNameRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function GetSchoolByName(GetSchoolByNameRequest $request){
        $data = School::getSchoolByName($request['name']);
        return $data == null ?
            response()->fail(100, '失败') :
            response()->success(200, '成功', $data);
    }
}
