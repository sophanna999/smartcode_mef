<?php
namespace App\Repositories\Capacities;

use App\Models\BackEnd\Capacity\Schedule;
use App\Models\BackEnd\Capacity\Member;
use App\Models\BackEnd\Capacity\Training;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Mail;

class ScheduleRepository
{
    protected $schedule;
    protected $member;
    protected $training;

    public function __construct(Schedule $schedule, Member $member,Training $training)
    {
        $this->member  = $member;
        $this->training  = $training;
        $this->schedule  = $schedule;
    }

    public function getQuery()
    {
        return $this->schedule;
    }

    public function count()
    {
        return $this->schedule->count();
    }

    public function listAll()
    {
        return $this->schedule->all()->pluck('title', 'id')->all();
    }

    public function listId()
    {
        return $this->schedule->all()->pluck('id')->all();
    }

    public function getAll($training_id)
    {
        return $this->schedule->with('subject','room','member')->whereTrainingId($training_id)->get();
    }

    public function findOrFail($id)
    {
        $schedule = $this->schedule->with('member')->find($id);

        if (! $schedule) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('schedule.schedule')]]);
        }

        return $schedule;
    }

    public function getFilter($training_id,$request){
        $training = $this->training->findOrFail($training_id);
        $schedules = $this->schedule->with('subject','room','member');

        if($request->participate) {
            $schedules->whereHas('member',function($q) use ($request) {
                $q->where('mef_members.id',$request->participate);
            });
        }

        if($request->room) {
            $schedules->whereRoomId($request->room);
        }
        
        if($request->subject) {
            $schedules->whereSubjectId($request->subject);
        }

        $schedules->where('time_in','>=',$training->start_date);
        $schedules->where('time_out','<=',$training->end_date);

        return $schedules->get();
    }

    public function validateDuplicate($request,$training_id,$schedule = null){

        if($schedule)
            $schedule = $this->findOrFail($schedule);

        $training = $this->training->findOrFail($training_id);

        $duplicated = $this->duplicatedTime($request->time_in,$request->time_out);

        if($schedule){
            $duplicated = $duplicated->filter(function($q) use ($schedule) {
                return $q->id != $schedule->id;
            });
        }
        
        $duplicated_trainer = $duplicated->filter(function($q) use ($request){
            return $q->member->filter(function($q) use ($request) { 
                return $q->id == $request->trainer;
            });
        })->count();

        if($duplicated_trainer)
            return response()->json(['message' => trans('training.attribute_busy_with_other_training',['attr' => trans('training.trainer')])],400);

        $duplicated_assistant = $duplicated->filter(function($q) use ($request){
            return $q->member->filter(function($q) use ($request) { 
                return $q->id == $request->assistant;
            });
        })->count();

        if($duplicated_assistant)
            return response()->json(['message' => trans('training.attribute_busy_with_other_training',['attr' => trans('training.assistant')])],400);

        if($duplicated->whereLoose('training_id',$training_id)->count())
            return response()->json(['message' => trans('training.duplicated_time')],400);

        if($duplicated->whereLoose('room_id',$request->room)->count())
            return response()->json(['message' => trans('training.attribute_busy_with_other_training',['attr' => trans('training.room')])],400);

        if(date('Y-m-d',strtotime($request->time_in)) < $training->start_date || date('Y-m-d',strtotime($request->time_out)) > $training->end_date )
            return response()->json(['message' => trans('training.overload_training')],400);  

        return false;
    }

    public function duplicatedTime($time_in, $time_out){
        
        $busy = $this->schedule->with('member')
            ->where(function($q) use ($time_in, $time_out){
                $q->where(function($q) use ($time_in, $time_out) {
                    $q->where('time_in','<=',$time_in);
                    $q->where('time_out','>=',$time_in);
                })->orWhere(function($q) use ($time_in, $time_out) {
                    $q->where('time_in','<=',$time_out);
                    $q->where('time_out','>=',$time_out);
                });
            })->orWhere(function($q) use ($time_in,$time_out) {
                $q->where('time_in','>=',$time_in);
                $q->where('time_out','<=',$time_out);
            })->get();

        return $busy;
    }

    public function create($request)
    {
        $schedule = $this->schedule->forceCreate($this->formatParams($request,true));

        $this->assign($schedule->id,$request);

        return $schedule;
    }

    public function assign($id, $request)
    {
        $schedule = $this->findOrFail($id);
        
        $members = [$request->trainer => ['type' => 'primary_trainer']];

        if($request->assistant)
            $members[$request->assistant] = ['type' => 'primary_assistant'];

        return $schedule->member()->sync($members);
    }

    private function formatParams($request,$create = false)
    {
        $formatted = [
            'time_in'       => $request->time_in ?  : null,
            'time_out'      => $request->time_out ?  : null,
            'training_id'   => $request->training ?  : null,
            'subject_id'    => $request->subject ?  : null,
            'room_id'       => $request->room ?  : null,
            'custom_room'   => $request->custom_room ?  : null,
            'description'   => $request->description ?  : null,
        ];

        if($create)
            $formatted['user_id'] = session('sessionUser')->id;

        return $formatted;
    }

    public function update($id,$params)
    {
        $schedule = $this->findOrFail($id);

        return $schedule->forceFill($this->formatParams($params))->save();
    }

    public function deletable($ids)
    {
        $schedules = $this->schedule->whereIn('id',$ids)->get();

        if($schedules->count() != count($ids)){
            throw ValidationException::withMessages(['message' => trans('general.something_went_wrong')]);
        }

        return $schedules;
    }

    public function delete($ids)
    {
        $schedules = $this->deletable($ids);

        return $this->schedule->whereIn('id',$ids)->delete();
    }

}