<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class AssignParticipantsRequest extends Request
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
            'participants' => 'required|array|exists:mef_members,id',
            'type' => 'required|array|in:trainer,trainee,assistant',
            'send_notification' => 'boolean'
        ];
    }

    public function attributes()
    {
        return [
            'participants' => trans('training.participant'),
            'type' => trans('training.type'),
            'send_notification' => trans('general.send_notification'),
        ];
    }
}
