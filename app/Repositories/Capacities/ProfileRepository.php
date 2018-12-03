<?php
namespace App\Repositories\Capacities;

use App\Models\BackEnd\Profile;

class ProfileRepository
{
    protected $profile;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Profile $profile)
    {
        $this->profile  = $profile;
    }

    public function assignAttribute($profile,$request)
    {
        $profile->full_name            = $request->full_name ? : $profile->full_name;
        $profile->latin_name           = $request->latin_name ? : $profile->latin_name;
        $profile->address              = $request->address ? : $profile->address;
        $profile->gender               = $request->gender ? : $profile->gender;
        $profile->date_of_birth        = $request->date_of_birth ? : $profile->date_of_birth;
        $profile->position             = $request->position ? : $profile->position;
        $profile->company              = $request->company ? : $profile->company;
        $profile->remark               = $request->remark ? : $profile->remark;
       
        return $profile;
    }
}