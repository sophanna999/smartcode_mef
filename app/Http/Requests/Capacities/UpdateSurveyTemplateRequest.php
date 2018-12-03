<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class UpdateSurveyTemplateRequest extends Request
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
            'code' => 'max:20',
            'name' => 'required|max:255',
            'question' => 'required|array',
        ];
    }

    public function attributes()
    {
        return [
            'code' => trans('survey.code'),
            'name' => trans('survey.name'),
            'question' => trans('survey.question'),
        ];
    }
}
