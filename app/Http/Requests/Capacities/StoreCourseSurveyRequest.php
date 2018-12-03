<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class StoreCourseSurveyRequest extends Request
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
            'name' => 'required|max:255',
            'question' => 'required|array|exists:mef_questions,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('survey.name'),
            'question' => trans('survey.question'),
        ];
    }
}
