<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\InfoRequest;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Province;
use App\Models\SchoolScoreline;

class SchoolInfoController extends Controller
{
    /**
     * 获取学校详细信息
     * @author Varsion
     * @param InfoRequest $request [description]
     * @return  [type]           [description]
     * @throws \Exception
     */
    public function getInfo(InfoRequest $request)
    {
        $code = $request->code;
        $area = Province::getID($request->area);

        $schoolInfo = School::getSchoolInfo($code);
        $scoreLine = SchoolScoreline::getScore($code, $area);
        //分别获取学校信息和分数线信息

        $result = [
            'info' => $schoolInfo,
            'scoreLine' => $scoreLine
        ];

        return $result ?
            response()->success(200, '学校信息获取成功！', $result) :
            response()->fail(100, '学校信息获取失败！');

    }
}
