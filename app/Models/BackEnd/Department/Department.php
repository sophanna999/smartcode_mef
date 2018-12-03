<?php

namespace App\Models\BackEnd\Department;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'mef_department';
    protected $primaryKey = 'Id';
    
    public function generalDepartment()
    {
        return $this->belongsTo('App\Models\BackEnd\GeneralDepartment\GeneralDepartment','mef_secretariat_id');
    }

    public function getNameWithParentAttribute()
    {
        if($this->generalDepartment){
            return $this->Name.' - '.$this->generalDepartment->Name;
        }

        return $this->Name;
    }
}
