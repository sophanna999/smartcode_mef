<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreOutsideStaff extends Request
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
        return [
            'full_name' => 'required|max:255',
            'latin_name' => 'required|max:255',
            'gender' => 'in:m,f',
//            'date_of_birth' => 'date_format:Y-m-d',
            'phone_number' => 'required|max:255',
            'email' => 'required|email|max:255',
            'position' => 'max:255',
            'company' => 'max:255',
        ];
    }

    public function attributes()
    {
        return [
            'full_name' => trans('profile.full_name'),
            'latin_name' => trans('profile.latin_name'),
            'gender' => trans('profile.gender'),
            'date_of_birth' => trans('profile.date_of_birth'),
            'address' => trans('profile.address'),
            'position' => trans('profile.position'),
            'company' => trans('profile.company'),
            'phone_number' => trans('profile.phone_number'),
            'email' => trans('profile.email'),
        ];
    }
}
