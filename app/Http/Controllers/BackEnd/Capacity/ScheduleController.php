<?php

namespace App\Http\Controllers\BackEnd\Capacity;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BackendController;
use App\Repositories\Capacities\MemberRepository;
use App\Repositories\Capacities\ScheduleRepository;
use App\Repositories\Capacities\TrainingRepository;
use App\Repositories\Capacities\RoomRepository;
use App\Repositories\Capacities\SubjectRepository;
use App\Http\Requests\Capacities\StoreScheduleRequest;
use App\Http\Requests\Capacities\UpdateScheduleRequest;

class ScheduleController extends BackEndController
{
    protected $module = 'back-end.capacity.training';
    protected $repository;
    protected $room;
    protected $subject;
    protected $member;
    protected $training;

    public function __construct(
        ScheduleRepository $schedule,
        MemberRepository $member,
        TrainingRepository $training,
        RoomRepository $room,
        SubjectRepository $subject
        )
    {
        parent::__construct();
        $this->room = $room;
        $this->subject = $subject;
        $this->member = $member;
        $this->training = $training;
        $this->repository = $schedule;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($training_id,Request $request)
    {
        $data = collect([]);

        foreach($this->repository->getAll($training_id) as $schedule){
            $row = [
                'id'            => $schedule->id,
                'title'         => $schedule->subject->name,
                'start'         => date('c',strtotime($schedule->time_in)),
                'end'           => date('c',strtotime($schedule->time_out)),
                'allDay'        => false,
                'room'          => $schedule->room_id,
                'custom_room'   => $schedule->custom_room,
                'subject'       => $schedule->subject_id,
                'trainer'       => $schedule->member()->wherePivot('type','primary_trainer')->first()->id,
                'assistant'     => ($schedule->member()->wherePivot('type','primary_assistant')->first() ? $schedule->member()->wherePivot('type','primary_assistant')->first()->id : null),
                'description'   => $schedule->description,
            ];
            
            $data[] = $row;
        };

        if($request->has('participate') || $request->has('subject') || $request->has('room')) {
            foreach($this->repository->getFilter($training_id,$request) as $schedule){
                $row = [
                    'id'            => $schedule->id,
                    'title'         => $schedule->subject->name,
                    'start'         => date('c',strtotime($schedule->time_in)),
                    'end'           => date('c',strtotime($schedule->time_out)),
                    'allDay'        => false,
                    'room'          => $schedule->room_id,
                    'custom_room'   => $schedule->custom_room,
                    'subject'       => $schedule->subject_id,
                    'trainer'       => $schedule->member()->wherePivot('type','primary_trainer')->first()->id,
                    'assistant'     => ($schedule->member()->wherePivot('type','primary_assistant')->first() ? $schedule->member()->wherePivot('type','primary_assistant')->first()->id : null),
                    'description'   => $schedule->description,
                    'color'         => '#5fba7d',
                ];
                
                $data[] = $row;
            }
        }

        $data = $data->toJson();

        return response()->json(['schedules' => $data]);
    }

    public function busyCoordinate(Request $request){

        $this->validate($request,[
            'time_in' => 'required|date_format:Y-m-d H:i:s',
            'time_out' => 'required|date_format:Y-m-d H:i:s'
        ]);

        $duplicated = $this->repository->duplicatedTime($request->time_in,$request->time_out);

        $trainers = $duplicated->map(function($m){
            return $m->member->pluck('id')->toArray();
        })->flatten();
        
        $assistants = $duplicated->map(function($m){
            return $m->member->pluck('id')->toArray();
        })->flatten();

        $rooms = $duplicated->map(function($m){
            return $m->room->id;
        });
        
        $trainers = collect($trainers->all())->unique()->values()->toJson();
        $assistants = collect($assistants->all())->unique()->values()->toJson();
        $rooms = collect($rooms->all())->unique()->values()->toJson();

        return response()->json(compact('rooms','assistants','trainers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($training_id)
    {
        $training = $this->training->findOrFail($training_id);

        $rooms = $this->room->getAll($training->location_id)->pluck('name','id')->toJson();

        $course_subjects = $training->course->subject()->get()->filter(function($q){
            return $q->status == 1;
        })->pluck('id')->toArray();

        $subjects = $this->subject->getAll()->filter(function($q) use ($course_subjects){
            return in_array($q->id,$course_subjects); 
        })->pluck('name','id')->toJson();

        $trainers = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'trainer';
        })->pluck('name','id');

        $assistants = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'assistant';
        })->pluck('name','id');

        return view($this->module.'.new_schedule',compact('assistants','trainers','training','rooms','subjects'))->with($this->data);
    }

    public function copy($id)
    {
        $schedule = $this->repository->findOrFail($id);
        $training = $this->training->findOrFail($schedule->training_id);

        $rooms = $this->room->getAll($training->location_id)->pluck('name','id')->toJson();

        $course_subjects = $training->course->subject()->get()->filter(function($q){
            return $q->status == 1;
        })->pluck('id')->toArray();

        $subjects = $this->subject->getAll()->filter(function($q) use ($course_subjects){
            return in_array($q->id,$course_subjects); 
        })->pluck('name','id')->toJson();

        $trainers = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'trainer';
        })->pluck('name','id');

        $assistants = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'assistant';
        })->pluck('name','id');
        
        return view($this->module.'.copy_schedule',compact('assistants','trainers','training','rooms','subjects','schedule'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleRequest $request,$training_id)
    {
        $training = $this->training->findOrFail($training_id);

        if($this->repository->validateDuplicate($request,$training_id))
            return $this->repository->validateDuplicate($request,$training_id);

        $this->repository->create($request);

        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('training.schedule')])]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = $this->repository->findOrFail($id);
        $training = $this->training->findOrFail($schedule->training_id);

        $rooms = $this->room->getAll($training->location_id)->pluck('name','id')->toJson();

        $course_subjects = $training->course->subject()->get()->filter(function($q){
            return $q->status == 1;
        })->pluck('id')->toArray();

        $subjects = $this->subject->getAll()->filter(function($q) use ($course_subjects){
            return in_array($q->id,$course_subjects); 
        })->pluck('name','id')->toJson();

        $trainers = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'trainer' && $t->status == 1;
        })->pluck('name','id');

        $assistants = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'assistant' && $t->status == 1;
        })->pluck('name','id');

        return view($this->module.'.edit_schedule',compact('assistants','trainers','training','rooms','subjects','schedule'))->with($this->data);
    }

    public function validateDuplicate($request,$training_id,$schedule = null){

        if($schedule)
            $schedule = $this->repository->findOrFail($id);

        $training = $this->training->findOrFail($training_id);

        $duplicated = $this->repository->duplicatedTime($request->time_in,$request->time_out);

        if($schedule){
            $duplicated->filter(function($q) use ($schedule) {
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScheduleRequest $request, $id)
    {
        $schedule = $this->repository->findOrFail($id);

        $training = $this->training->findOrFail($schedule->training_id);
        
        if($this->repository->validateDuplicate($request,$schedule->training_id,$schedule->id))
            return $this->repository->validateDuplicate($request,$schedule->training_id,$schedule->id);

        $request->request->add(['training' => $training->id]);

        $this->repository->update($id,$request);

        return response()->json(['message' => trans('general.success_update',['attribute' => trans('training.schedule')])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = $this->repository->findOrFail($id);

        $this->repository->delete([$id]);

        return response()->json(['message' => trans('general.success_delete',['attribute' => trans('training.training')])]);
    }
}
