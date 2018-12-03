<?php

namespace App\Models\BackEnd\Mission;

use Illuminate\Database\Eloquent\Model;

class MissionProvince extends Model
{
    //
    protected $table = 'mef_mission_province';

    
    public function province()
	{
		return $this->belongsTo('App\Models\BackEnd\Province\Province','province_id','id');
	}
}
