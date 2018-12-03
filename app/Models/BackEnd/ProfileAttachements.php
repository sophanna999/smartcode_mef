<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'mef_profiles';
    protected $fillable = ['profile_id','type','no','file','status'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

}
