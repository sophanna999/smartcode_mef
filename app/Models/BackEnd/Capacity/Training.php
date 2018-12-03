<?php

namespace App\Models\BackEnd\Capacity;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'mef_trainings';
    protected $filable = ['prefix','code','start_date','end_date','description','location_id','course_id','status'];

    public function location()
    {
        return $this->belongsTo('App\Models\BackEnd\Capacity\Location');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\BackEnd\Capacity\Course');
    }

    public function member()
    {
        return $this->belongsToMany('App\Models\BackEnd\Capacity\Member','mef_member_training')->withPivot('type')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\BackEnd\User\User');
    }

    public function scopeFilterByUsers($q, $users = null)
    {
        if (! $users) {
            return $q;
        }

        return $q->whereIn('user_id', $users);
    }
}
