<?php

namespace App\Models;

use App\Utils\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;
    protected $table = 'province';

    /***
     * 获取批次
     * @return bool|\Illuminate\Support\Collection
     * @throws \Exception
     */
    public static function getAllProvince($province){
        try {
            if ($province==null){
                return self::select('id','name')->get();
            }else{
                return self::where('id','=',$province)->select('id','name')->get();
            }
        } catch (\Exception $e) {
            Logs::logError('获取批次错误', [$e->getMessage()]);
            return false;
        }
    }

    /***
     * 获取志愿填报页面
     * @param $province
     * @return bool
     * @throws \Exception
     */
    public static function getVolunteerHtml($province){
        try {
            return self::where('id','=',$province)
                ->select('form')
                ->get();
        } catch (\Exception $e) {
            Logs::logError('获取志愿填报错误', [$e->getMessage()]);
            return false;
        }
    }
}
