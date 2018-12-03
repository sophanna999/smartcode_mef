<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class StoreMemberRequest extends Request
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
        if(Request::input('type'))
        {
            return [
                'type' => 'boolean',
                'code' => 'unique:mef_members,code|max:10',
                'subjects' => 'array|exists:mef_subjects,id',
                'full_name' => 'required|max:255',
                'latin_name' => 'required|max:255',
                'gender' => 'in:ប្រុស,ស្រី',
                'date_of_birth' => 'date_format:Y-m-d',
                'phone_number' => 'required|unique:mef_members,phone_number|max:255',
                'email' => 'required|unique:mef_members,email|email|max:255',
                'position' => 'max:255',
                'company' => 'max:255',
                'username' => 'required|unique:mef_officer,user_name|alpha_dash|min:4',
                'password' => 'required|min:6',
            ];
        }

        return [
            'type' => 'boolean',
            'code' => 'unique:mef_members,code|max:10',
            'officer' => 'required|exists:mef_officer,Id|unique:mef_members,officer_id',
        ];
    }

    public function attributes()
    {
        return [
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
