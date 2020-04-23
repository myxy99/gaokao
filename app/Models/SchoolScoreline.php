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
}
