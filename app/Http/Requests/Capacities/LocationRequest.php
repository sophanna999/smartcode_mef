<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class LocationRequest extends Request
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
            'code' => 'unique:mef_locations,code'.($this->route() ? ','. $this->route('id') : '' ).'|max:10',
            'name' => 'required|max:255',
            // 'department' => 'required|exists:mef_department,Id',
        ];
    }

    public function attributes()
    {
        return [
            'code' => trans('location.code'),
            'name' => trans('location.name'),
            // 'department' => trans( 'general.for_department'),
        ];
    }
}
