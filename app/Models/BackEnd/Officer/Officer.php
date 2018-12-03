<?php

namespace App\Models\BackEnd\Officer;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $table = 'mef_officer';
    protected $primaryKey = 'Id';

    protected $fillable = ['user_name','password'];

    public $timestamps = false;

    protected $appends = ['name_with_khmer'];

    public function member()
    {
        return $this->hasOne('App\Models\BackEnd\Capacity\Member','officer_id');
    }
    
    public function personalInfo()
    {
        return $this->hasOne('App\Models\BackEnd\Officer\PersonalInfo','MEF_OFFICER_ID');
    }

    public function getNameWithKhmerAttribute($value)
    {
        return ucfirst($this->personalInfo->FULL_NAME_EN).' '.$this->personalInfo->FULL_NAME_KH;
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeApproved($query)
    {
        return $query->where(function($q){
            $q->whereNull('approve')->orWhere('approve','');
        });
    }


}
