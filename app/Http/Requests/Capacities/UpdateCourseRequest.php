<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class UpdateCourseRequest extends Request
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
            'code' => 'unique:mef_courses,code'.($this->route() ? ','. $this->route('id') : '' ).'|max:10',
            'title' => 'required|max:255',
            'subjects' => 'required|exists:mef_subjects,id',
        ];
    }

    public function attributes()
    {
        return [
            'code' => trans('course.code'),
            'title' => trans('course.title'),
            'subjects' => trans('subject.subject'),
        ];
    }
}
