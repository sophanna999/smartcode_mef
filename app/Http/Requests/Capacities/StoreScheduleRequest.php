<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;
use App\Repositories\Capacities\TrainingRepository;

class StoreScheduleRequest extends Request
{
    protected $training;

    public function __construct(TrainingRepository $training)
    {
        parent::__construct();
        $this->training = $training;
    }

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
        $data = [
            'subject' => 'required|exists:mef_subjects,id',
            'time_in' => 'required|date_format:Y-m-d H:i:s|before:time_out',
            'time_out' => 'required|date_format:Y-m-d H:i:s|after:time_in',
            'trainer' => 'required|exists:mef_members,id',
            'assistant' => 'exists:mef_members,id',
        ];
        $training = $this->training->findOrFail($this->route('training'));

        if($training->location_id)
            $data['room'] = 'required|exists:mef_rooms,id';
        else 
            $data['custom_room'] = 'required';

        return $data;
    }

    public function attributes()
    {
        return [
            'room' => trans('room.room'),
            'subject' => trans('subject.subject'),
            'time_in' => trans('training.time_in'),
            'time_out' => trans('training.time_out'),
            'trainer' => trans('training.trainer'),
            'assistant' => trans('training.assistant'),
            'custom_room' => trans('room.room'),
        ];
    }
}
