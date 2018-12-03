<?php

namespace App\Models\BackEnd\Capacity;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'mef_members';

    protected $fillable = ['type','code','email','phone_number'];

    protected $appends = ['full_name','latin_name','position','company'];

    public function profile()
    {
        return $this->morphOne('App\Models\BackEnd\Profile','profileable');
    }

    public function subject()
    {
        return $this->belongsToMany('App\Models\BackEnd\Capacity\Subject','mef_member_subject');
    }

    public function training()
    {
        return $this->belongsToMany('App\Models\BackEnd\Capacity\Member','mef_member_training')->withPivot('type')->withTimestamps();
    }

    public function officer()
    {
        return $this->belongsTo('App\Models\BackEnd\Officer\Officer');
    }

    public function getFullNameAttribute($value)
    {
        return $this->profile->full_name;
    }

    public function getLatinNameAttribute($value)
    {
        return ucfirst($this->profile->latin_name);
    }

    public function getNameAttribute($value)
    {
        return $this->profile->full_name.' '. ucfirst($this->profile->latin_name);
    }

    public function getPositionAttribute($value)
    {
        return $this->profile->position;
    }

    public function getCompanyAttribute($value)
    {
        return $this->profile->company;
    }

    public function scopeFilterByCode($q, $code = null)
    {
        if (! $code) {
            return $q;
        }

        return $q->where('code', 'like', '%'.$code.'%');
    }

    public function scopeFilterByEmail($q, $email = null)
    {
        if (! $email) {
            return $q;
        }

        return $q->where('email', 'like', '%'.$email.'%');
    }

    public function scopeFilterByFirstName($q, $first_name = null)
    {
        if (! $first_name) {
            return $q;
        }

        return $q->whereHas('profile', function ($q1) use ($first_name) {
            $q1->where('first_name', 'like', '%'.$first_name.'%');
        });
    }

    public function scopeFilterByLastName($q, $last_name = null)
    {
        if (! $last_name) {
            return $q;
        }

        return $q->whereHas('profile', function ($q1) use ($last_name) {
            $q1->where('last_name', 'like', '%'.$last_name.'%');
        });
    }

    public function scopeFilterByKhmerName($q, $last_name = null)
    {
        if (! $last_name) {
            return $q;
        }

        return $q->whereHas('profile', function ($q1) use ($last_name) {
            $q1->where('last_name', 'like', '%'.$last_name.'%');
        });
    }

}
