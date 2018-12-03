<?php

namespace App\Models\BackEnd\Capacity;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'mef_rooms';

    protected $fillable = ['code','name','location_id','description','department_id','public'];

    public function location(){
        return $this->belongsTo('App\Models\BackEnd\Capacity\Location');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\BackEnd\Department\Department');
    }

    public function getNameWithCodeAttribute()
    {
        return $this->code.' '. $this->name;
    }

    public function scopeFilterByCode($q, $code = null)
    {
        if (! $code) {
            return $q;
        }

        return $q->where('code', 'like', '%'.$code.'%');
    }

    public function scopeFilterByName($q, $name = null)
    {
        if (! $name) {
            return $q;
        }

        return $q->where('name', 'like', '%'.$name.'%');
    }

    public function scopeFilterByDescription($q, $description = null)
    {
        if (! $description) {
            return $q;
        }

        return $q->where('description', 'like', '%'.$description.'%');
    }

    public function scopeFilterByLocation($q, $location = null)
    {
        if (! $location) {
            return $q;
        }

        return $q->where('location_id', $location);
    }

    public function scopeFilterByUsers($q, $users = null)
    {
        if (! $users) {
            return $q;
        }

        return $q->whereIn('user_id', $users->toArray());
    }

}
