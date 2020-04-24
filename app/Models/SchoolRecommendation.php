<?php

namespace App\Models;

use App\Utils\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolRecommendation extends Model
{
    use SoftDeletes;
    protected $table = 'school_recommendation';

    public function profile()
    {
        return $this->hasOne(School::class, 'code', 'school_code');
    }

    public static function showSchoolRe()
    {
        try {
            return self::join('school', 'school_code', '=', 'code')
                ->select('code', 'name', 'web1', 'web2', 'web3')->paginate(8);
        } catch (\Exception $e) {
            Logs::logError('获取动图学校信息失败', [$e->getMessage()]);
            return false;
        }
    }
}
