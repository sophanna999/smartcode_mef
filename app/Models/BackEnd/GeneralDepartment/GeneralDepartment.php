<?php

namespace App\Models\BackEnd\GeneralDepartment;

use Illuminate\Database\Eloquent\Model;

class GeneralDepartment extends Model
{
    protected $table = 'mef_secretariat';
    protected $primaryKey = 'Id';
    
    public function department()
    {
        return $this->hasMany('App\Models\BackEnd\Department\Department','mef_secretariat_id','Id');
    }
    
    public function ministry()
    {
        return $this->belongsTo('App\Models\BackEnd\CentralMinistry\Ministry','mef_ministry_id');
    }

    public function getNameWithParentAttribute()
    {
        return $this->Name. ' - '. $this->ministry->Name;
    }
}
