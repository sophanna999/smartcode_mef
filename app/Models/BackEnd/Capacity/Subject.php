<?php

namespace App\Models\BackEnd\Capacity;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'mef_subjects';
    protected $fillable = ['user_id','code','name','description','public','department_id'];

    public function member()
    {
        return $this->belongsToMany('App\Models\BackEnd\Capacity\Member','mef_member_subject');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\BackEnd\Department\Department');
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(1);
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

        return $q->whereIn('user_id', $users);
    }
}
