<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class DeleteLocationRequest extends Request
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
            'id' => 'required|exists:mef_locations,id',
        ];
    }

    public function attributes()
    {
        return [
            'id' => trans('location.id'),
        ];
    }
}