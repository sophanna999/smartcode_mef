<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class StoreQuestionRequest extends Request
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
            'title' => 'required|max:255',
            'type' => 'required|in:'.implode(',',array_keys(config('system.answer_types'))),
            'option' => 'required_if:type,1,2,3',
        ];
    }

    public function attributes()
    {
        return [
            'title' => trans('survey.title'),
            'type' => trans('survey.type'),
            'option' => trans('survey.option'),
        ];
    }
}
