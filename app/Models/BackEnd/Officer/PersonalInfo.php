<?php

namespace App\Models\BackEnd\Officer;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    protected $table = 'mef_personal_information';

    protected $appends = ['full_name_with_latin_name'];

    public function officer()
    {
        return $this->belongsTo('App\Models\BackEnd\Officer\Officer');
    }

    public function getFullNameWithLatinNameAttribute()
    {
        return ucfirst($this->FULL_NAME_EN).' '.$this->profile->FULL_NAME_KH;
    }
}
