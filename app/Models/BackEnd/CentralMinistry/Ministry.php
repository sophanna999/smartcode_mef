<?php

namespace App\Models\BackEnd\CentralMinistry;

use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    protected $table = 'mef_ministry';
    protected $primaryKey = 'Id';
    
    public function generalMinistry()
    {
        return $this->hasMany('App\Models\BackEnd\GeneralMinistry\GeneralDepartment','mef_secretariat_id');
    }

    
}
