<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;
use App\Models\BackEnd\Capacity\Member;

class UpdateMemberRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');
        $member = Member::find($id);

        if(Request::input('type'))
        {
            return [
                'type' => 'boolean',
                'code' => 'max:10|unique:mef_members,code,'. $id,
                'subjects' => 'array|exists:mef_subjects,id',
                'full_name' => 'required|max:255',
                'latin_name' => 'required|max:255',
                'gender' => 'in:m,f',
                'date_of_birth' => 'date_format:Y-m-d',
                'phone_number' => 'required|max:255|unique:mef_members,phone_number,' . $id,
                'email' => 'required|email|max:255|unique:mef_members,email,' . $id,
                'position' => 'max:255',
                'company' => 'max:255',
                'username' => 'required|alpha_dash|min:4,|unique:mef_officer,user_name,' . $member->officer_id.',Id',
                'password' => 'min:6',
            ];
        }

        return [
            'type' => 'boolean',
            'code' => 'max:10|unique:mef_members,code,' .$id,
            'officer' => 'required|exists:mef_officer,Id|unique:mef_members,officer_id,' .$id,
        ];
    }

    public function attributes()
    {
        return [
            'type' => trans('profile.type'),
            'officer' => trans('profile.officer'),
            'code' => trans('profile.code'),
            'subjects' => trans('subject.subject'),
            'full_name' => trans('profile.full_name'),
            'latin_name' => trans('profile.latin_name'),
            'gender' => trans('profile.gender'),
            'date_of_birth' => trans('profile.date_of_birth'),
            'address' => trans('profile.address'),
            'position' => trans('profile.position'),
            'company' => trans('profile.company'),
            'phone_number' => trans('profile.phone_number'),
            'email' => trans('profile.email'),
            'note' => trans('profile.note'),
            'username' => trans('profile.username'),
            'password' => trans('profile.password'),
        ];
    }
}
