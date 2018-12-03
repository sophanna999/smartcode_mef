<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;

class UpdateTrainingRequest extends Request
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
            'prefix' => 'required|max:10',
            'code' => 'required|max:10|unique:mef_trainings,code,'.$this->route('id'),
            'course' => 'required|exists:mef_courses,id',
            'start_date' => 'required|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
            'location' => 'required_without:outside_location|exists:mef_locations,id',
            'outside_location' => 'boolean',
            'name_of_outside_location' => 'required_with:outside_location',
            'attachments' => 'mimes:jpeg,png,jpg,pdf,doc',
            'status' => 'boolean',
            'participants' => 'array|exists:mef_members,id',
            'type' => 'array|in:trainer,trainee,assistant',
            'send_notification' => 'boolean'
        ];
    }

    public function attributes()
    {
        return [
            'prefix' => trans('training.prefix'),
            'code' => trans('training.code'),
            'start_date' => trans('training.start_date'),
            'end_date' => trans('training.end_date'),
            'course' => trans('course.course'),
            'location' => trans('location.location'),
            'attachments' => trans('training.attachment'),
            'status' => trans('training.status'),
            'participants' => trans('training.participant'),
            'type' => trans('training.type'),
            'send_notification' => trans('general.send_notification'),
            'name_of_outside_location' => trans('training.name_of_outside_location'),
            'outside_location' => trans('training.outside_location'),
        ];
    }
}
