<?php

namespace App\Models\BackEnd\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'mef_user';
    protected $primaryKey = 'id';

    public function officer()
    {
        return $this->belongsTo('App\Models\BackEnd\Officer\Officer','mef_officer_id');
    }

    public function getFullNameAttribute($value)
    {
        if($this->mef_officer_id)
            return $this->officer->personalInfo->FULL_NAME_KH;
        elseif(!$this->mef_officer_id)
            return trans('general.administor');
        else
            return trans('general.unknown');
    }
}
