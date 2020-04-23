<?php

namespace App\Models;

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
}
