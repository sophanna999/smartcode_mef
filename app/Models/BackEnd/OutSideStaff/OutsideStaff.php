<?php

namespace App\Models\BackEnd\OutSideStaff;

use Illuminate\Database\Eloquent\Model;

class OutsideStaff extends Model
{
    protected $table = 'mef_outside_staffs';

    protected $fillable = ['nationality', 'education', 'phone_number', 'email', 'company_tel', 'company_email', 'company_address', 'company_website', 'status'];

    protected $appends = ['full_name', 'latin_name','avatar'];

    public function profile()
    {
        return $this->morphOne('App\Models\BackEnd\Profile', 'profileable');
    }

    public function getFullNameAttribute($value)
    {
        return $this->profile->full_name;
    }

    public function getLatinNameAttribute($value)
    {
        return ucfirst($this->profile->english);
    }

    public function getAvatarAttribute($value)
    {
        return $this->profile->avatar;
    }

    public function scopeFilterByEmail($q, $email = null)
    {
        if (! $email) {
            return $q;
        }

        return $q->where('email', 'like', '%'.$email.'%');
    }

    public function scopeFilterByFullName($q, $full_name = null)
    {
        if (! $full_name) {
            return $q;
        }

        return $q->whereHas('profile', function ($q1) use ($full_name) {
            $q1->where('full_name', 'like', '%'.$full_name.'%');
        });
    }

    public function scopeFilterByLatinName($q, $latin_name = null)
    {
        if (! $latin_name) {
            return $q;
        }

        return $q->whereHas('profile', function ($q1) use ($latin_name) {
            $q1->where('latin_name', 'like', '%'.$latin_name.'%');
        });
    }
}