<?php

namespace App\Models;

use App\Utils\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use SoftDeletes;
    protected $table = 'batch';

    /***
     * 获取批次线
     * @return bool|\Illuminate\Support\Collection
     * @throws \Exception
     */
    public static function getAllBath($batch){
        try {
            if ($batch==null){
                return self::select('id','name')->get();
            }else{
                return self::where('id','=',$batch)->select('id','name')->get();
            }
        } catch (\Exception $e) {
            Logs::logError('获取全部批次错误', [$e->getMessage()]);
            return false;
        }
    }
}
