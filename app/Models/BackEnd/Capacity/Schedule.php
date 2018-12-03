<?php

namespace App\Models\BackEnd\Capacity;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'mef_schedules';
    protected $filable = [];

    public function training()
    {
        return $this->belongsTo('App\Models\BackEnd\Capacity\Training');
    }

    public function room()
    {
        return $this->belongsTo('App\Models\BackEnd\Capacity\Room');
    }

    public function member()
    {
        return $this->belongsToMany('App\Models\BackEnd\Capacity\Member','mef_member_schedule');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\BackEnd\Capacity\Subject');
    }
}
