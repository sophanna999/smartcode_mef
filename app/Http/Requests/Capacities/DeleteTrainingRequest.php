<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class DeleteTrainingRequest extends Request
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
            'ids' => 'required|exists:mef_trainings,id',
        ];
    }

    public function attributes()
    {
        return [
            'ids' => trans('training.id'),
        ];
    }
}
