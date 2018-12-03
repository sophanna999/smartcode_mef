<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class SubjectRequest extends Request
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
            'code' => 'unique:mef_subjects,code'.($this->route() ? ','. $this->route('id') : '' ).'|max:10',
            'name' => 'required|max:255',
            'department' => 'required|exists:mef_department,Id',
        ];
    }

    public function attributes()
    {
        return [
            'code' => trans('subject.code'),
            'name' => trans('subject.name'),
            'department' => trans('department.department'),
        ];
    }
}
