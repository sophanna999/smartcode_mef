<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'mef_profiles';

    protected $fillable = ['full_name','latin_name','gender','date_of_birth','address','avatar','position','company','remark'];

    public function profileable()
    {
        return $this->morphTo();
    }

    public function attachements()
    {
        return $this->hasMany(Profile::class);
    }
}
