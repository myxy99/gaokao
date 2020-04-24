<?php

namespace App\Http\Controllers\SchoolRmd;

use App\Http\Controllers\Controller;
use App\Models\SchoolRecommendation;

class SchoolRmdController extends Controller
{
    /**
     * 获取动图学校推荐
     * @return mixed
     */
    public function getRmd()
    {
        $data = SchoolRecommendation::showSchoolRe();
        return $data == null ?
            response()->fail(100, '失败') :
            response()->success(200, '成功', $data);
    }
}
