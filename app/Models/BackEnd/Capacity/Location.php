<?php

namespace App\Models\BackEnd\Capacity;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'mef_locations';
    protected $fillable = ['code','name','description','public','department_id'];

    public function room(){
        return $this->hasMany('App\Models\BackEnd\Capacity\Room');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\BackEnd\Department\Department');
    }

    public function getCodeWithNameAttribute($value)
    {
        return ($this->code ? $this->code.'-': '').$this->name;
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

    public function scopeFilterByUsers($q, $users = null)
    {
        if (! $users) {
            return $q;
        }

        return $q->whereIn('user_id', $users->toArray());
    }
}
