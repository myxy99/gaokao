<?php

namespace App\Models;

use App\Utils\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;
    protected $table = 'school';

    /**
     * 按照条件批次地址获取学校
     * @param $province
     * @param $batch
     * @return bool
     * @throws \Exception
     */
    public static function getGetSchool($province, $batch)
    {
        try {
            if ($province == null && $batch == null) {
                return self::select('code', 'name', 'province_id', 'batch_id')
                    ->paginate(env("PAGE_NUM")
                    );
            } else if ($province == null) {
                return self::where('batch_id', $batch)
                    ->select('code', 'name', 'province_id', 'batch_id')
                    ->paginate(env("PAGE_NUM")
                    );
            } else if ($batch == null) {
                return self::where('province_id', $province)
                    ->select('code', 'name', 'province_id', 'batch_id')
                    ->paginate(env("PAGE_NUM")
                    );
            } else {
                return self::where('province_id', $province)
                    ->where('batch_id', $batch)
                    ->select('code', 'name', 'province_id', 'batch_id')
                    ->paginate(env("PAGE_NUM")
                    );
            }

        } catch (\Exception $e) {
            Logs::logError('按照条件批次地址获取学校错误', [$e->getMessage()]);
            return false;
        }
    }

    /***
     * 根据学校名称查询学校
     * @param $name
     * @return bool
     * @throws \Exception
     */
    public static function getSchoolByName($name)
    {
        try {
            return self::where('name', $name)
                ->select('code', 'name', 'province_id', 'batch_id')
                ->get();
        } catch (\Exception $e) {
            Logs::logError('按照条件批次地址获取学校错误', [$e->getMessage()]);
            return false;
        }
    }

    public function profile()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

    /**
     * 获得该高校的详细信息
     * @author Varsion
     * @param  [type] $code [description]
     * @return |null
     * @throws \Exception
     */
    public static function getSchoolInfo($code)
    {
        try {
            $res = self::select('code', 'name', 'web1', 'web2', 'web3')
                ->where('code', $code)
                ->get();
            return $res;
        } catch (\Exception $e) {
            Logs::logError('学校详细信息获取失败！', [$e->getMessage()]);
            return null;
        }
    }
}
