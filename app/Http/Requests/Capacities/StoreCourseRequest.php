<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class StoreCourseRequest extends Request
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
            'code' => 'unique:mef_courses,code|max:10',
            'title' => 'required|max:255',
            'subjects' => 'required|exists:mef_subjects,id',
            'members' => 'required|exists:mef_members,id',
            'question' => 'array|exists:mef_questions,id',
        ];
    }

    public function attributes()
    {
        return [
            'code' => trans('course.code'),
            'title' => trans('course.title'),
            'subjects' => trans('subject.subject'),
            'members' => trans('training.trainer'),
            'question' => trans('survey.question'),
        ];
    }
}
