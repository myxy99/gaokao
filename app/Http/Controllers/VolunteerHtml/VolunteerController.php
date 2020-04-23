<?php

namespace App\Http\Controllers\VolunteerHtml;

use App\Http\Controllers\Controller;
use App\Http\Requests\Volunteer\GetVolunteerHtmlRequest;
use App\Models\Province;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    /***
     * 获取志愿填报页面
     * @param GetVolunteerHtmlRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function GetVolunteerHtml(GetVolunteerHtmlRequest $request){
        $data = Province::getVolunteerHtml($request['province']);
        return $data == null ?
            response()->fail(100, '失败') :
            response()->success(200, '成功', $data);
    }
}
