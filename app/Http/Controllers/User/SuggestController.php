<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SuggestRequest;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\SchoolScoreline;

class SuggestController extends Controller
{

    /**
     * 学校推荐
     * @author Varsion
     * @param  Request $request [description]
     * @return
     * @throws \Exception
     */
    public function Suggest(SuggestRequest $request)
    {
        $score = $request->score;
        $area = Province::getID($request->area);

        /*
            随机推荐学校个数 ABC三类学校
         */
        $countA = random_int(3, 6);
        $countB = random_int(4, 8);
        $countC = random_int(5, 10);

        $suggest = SchoolScoreline::Suggest($countA, $countB, $countC, $score, $area);

        return $suggest ?
            response()->success(200, '获取学校推荐成功！', $suggest) :
            response()->fail(100, '获取学校推荐失败！');
    }
}
