<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolScoreline extends Model
{
    use SoftDeletes;
    protected $table = 'school_scoreline';

    public function school()
    {
        return $this->hasOne(School::class, 'code', 'school_code');
    }

    public function province()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

    public function batch()
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    /**
     * 获取院校的历届分数线
     * @author Varsion
     * @param  [type] $code [description]
     * @param  [type] $area [description]
     * @return [type]       [description]
     * @throws \Exception
     */
    public static function getScore($code, $area)
    {
        try {
            $res1 = self::select('year', 'min')
                ->where('school_code', $code)
                ->where('province_id', $area)
                ->where('project_id', 1)
                ->groupBy('year')
                ->orderBy('year')
                ->get();

            $res2 = self::select('year', 'min')
                ->where('school_code', $code)
                ->where('province_id', $area)
                ->where('project_id', 2)
                ->groupBy('year')
                ->orderBy('year')
                ->get();
            //分别获取文科理科历年分数线
            //在合并json
            $res = [
                '理科' => $res1,
                '文科' => $res2
            ];
            return $res;
        } catch (\Exception $e) {
            \App\Utils\Logs::logError('学校分数信息获取失败！', [$e->getMessage()]);
            return null;
        }
    }

    /**
     * 推荐学校
     * @author Varsion
     * @param  [type] $countA [A级学校个数]
     * @param  [type] $counrB [B级学校个数]
     * @param  [type] $countC [C级学校个数]
     * @param  [type] $socre  [实际分数]
     * @return array|null
     * @throws \Exception
     */
    public static function Suggest($countA, $countB, $countC, $score, $area)
    {
        try {
            //(x+5,x+12]
            $resA = self::join('school as info', 'school_scoreline.school_code', 'info.code')
                ->join('province as pro', 'info.province_id', 'pro.id')
                ->select('info.code', 'info.name as school_name', 'pro.name as province')
                ->where('school_scoreline.province_id', $area)
                ->where('school_scoreline.forecast', '>', $score + 5)
                ->where('school_scoreline.forecast', '<=', $score + 12)
                ->inRandomOrder()
                ->take($countA)
                ->get();
            //[x-5,x+5)
            $resB = self::join('school as info', 'school_scoreline.school_code', 'info.code')
                ->join('province as pro', 'info.province_id', 'pro.id')
                ->select('info.code', 'info.name as school_name', 'pro.name as province')
                ->where('school_scoreline.province_id', $area)
                ->where('school_scoreline.forecast', '>=', $score - 5)
                ->where('school_scoreline.forecast', '<', $score + 5)
                ->inRandomOrder()
                ->take($countB)
                ->get();
            //[x-12,x-5)
            $resC = self::join('school as info', 'school_scoreline.school_code', 'info.code')
                ->join('province as pro', 'info.province_id', 'pro.id')
                ->select('info.name as school_name', 'pro.name as province')
                ->where('school_scoreline.province_id', $area)
                ->where('school_scoreline.forecast', '>=', $score - 12)
                ->where('school_scoreline.forecast', '<', $score - 5)
                ->inRandomOrder()
                ->take($countC)
                ->get();
            $res = [
                '30%' => $resA,
                '60%' => $resB,
                '75%' => $resC
            ];

            return $res;
        } catch (\Exception $e) {
            \App\Utils\Logs::logError('学校推荐或许失败！', [$e->getMessage()]);
            return null;
        }

    }
}
