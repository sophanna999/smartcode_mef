<?php

namespace App\Http\Controllers\BackEnd\Capacity;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BackendController;
use App\Models\BackEnd\Capacity\Member;
use App\Repositories\Capacities\LocationRepository;
use App\Repositories\Capacities\TrainingRepository;
use App\Http\Requests\Capacities\StoreTrainingRequest;
use App\Http\Requests\Capacities\UpdateTrainingRequest;
use App\Http\Requests\Capacities\DeleteTrainingRequest;
use App\Http\Requests\Capacities\AssignParticipantsRequest;
use App\Repositories\Capacities\CourseRepository;
use App\Repositories\Capacities\RoomRepository;
use App\Models\BackEnd\Capacity\Course;
use App\Repositories\Capacities\MemberRepository;
use App\Http\Controllers\BackEnd\File\FileController;
use Uuid;
use App\Repositories\File\FileRepository;

class TrainingController extends BackEndController
{
    protected $module = 'back-end.capacity.training';
    protected $repository;
    protected $file_repo;
    protected $member_model;
    protected $course_repo;
    protected $room_repo;

    public function __construct(TrainingRepository $training, 
        MemberRepository $member, 
        FileController $file_controller, 
        FileRepository $file_repo, 
        Member $member_model, 
        CourseRepository $course_repo,
        RoomRepository $room_repo
        )
    {
        parent::__construct();
        $this->member = $member;
        $this->repository = $training;
        $this->file_controller = $file_controller;
        $this->file_repo = $file_repo;
        $this->member_model = $member_model;
        $this->course_repo = $course_repo;
        $this->room_repo = $room_repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->module.'.index')->with($this->data);
    }

    public function lists()
    {
        $trainings = $this->repository->paginate(request()->all());

        return $trainings;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CourseRepository $course,LocationRepository $location)
    {
        $locations = $location->getAll()->filter(function($q) {
            return $q->status == 1;
        })->pluck('name','id')->toJson();

        $courses = $course->getAll()->filter(function($q){
            return $q->status == 1;
        })->pluck('title_with_code','id')->toJson();

        $members = $this->member_model->with('profile')->get()->pluck('name','id')->toJson();

        return view($this->module.'.new',compact('locations','courses','members'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingRequest $request)
    {
        $course_id = $request->course;
        $members = $request->members;
        $request->request->add([
            'custom_location' => $request->name_of_outside_location,
        ]);

        if($request->attachments){
            try{
                $files = collect([]);
                
                $request->request->add([
                    'module' => 'capacity_building',
                    'token' => Uuid::generate(),
                ]);

                $uploads = collect([]);
                $errors = collect([]);

                foreach($request->attachments as $attachment){

                    $request->request->add([
                        'file' => $attachment,
                    ]);

                    $upload = $this->file_repo->upload($request);

                    if(is_array($upload)){
                        $errors->push($upload);
                    }else{
                        $files->push( $upload );
                    }
                }

                if($errors->count()){
                    return response()->json(['attachments' => $errors->flatten()->values()->all() ],422);
                }

            }catch(\Exception $e){
                return response()->json(['message' => $e->getMessage()],422);
            }
        }

        $request->request->add(['participants' => $request->members]);

        $type = [];
        foreach($request->participants as $participant){
            $type[] = 'trainer';
        }

        $request->request->add(['type' => $type]);
        
        $training = $this->repository->create($request);

        if($request->attachments){
            $this->file_repo->store('capacity_building', $training->id, $files->first()->upload_token);
        }

        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('training.training')])]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $training = $this->repository->findOrFail($id);
        
        return view($this->module.'.detail',compact('training'))->with($this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,LocationRepository $location,CourseRepository $course)
    {
        $training = $this->repository->findOrFail($id);
        $member_selected = $training->member()->get()->pluck('id');
        $member_selected = $member_selected->toJson();
        $cours_id = $training->course_id;
        $course_data = $course->findOrfail($cours_id);
        $course_selected = $course_data->member()->get()->pluck('id');
        $locations = $location->getAll()->filter(function($q) use ($training) {
            return $q->status == 1 || $q->id == $training->course_id;
        })->pluck('name','id')->toJson();

        $courses = $course->getAll()->filter(function($q) use ($training){
            return $q->status == 1 || $q->id == $training->course_id;
        })->pluck('title_with_code','id')->toJson();

        $members = $this->member->getAll()->filter(function($q) use ($course_selected){
            return collect($course_selected)->contains($q->id) || $q->status ==1;
        })->pluck('name','id')->toJson();

        $member_data = $this->member->getAll()->filter(function($q) use ($member_selected){
            return collect($member_selected)->contains($q->id) || $q->status ==1;
        })->pluck('name','id')->toJson();

        return view($this->module.'.edit',compact('training','locations','courses','members','course_selected','member_selected','member_data'))->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingRequest $request, $id)
    {
        $members = $request->members;
        $request->request->add([
            'custom_location' => $request->name_of_outside_location,
        ]);
        
        $request->request->add(['participants' => $request->members]);

        $type = [];
        foreach($request->participants as $participant){
            $type[] = 'trainer';
        } 
        $request->request->add(['type' => $type]);
        $training = $this->repository->update($id,$request);

        return response()->json(['message' => trans('general.success_update',['attribute' => trans('training.training')])]);
    }

    public function createParticipant(Request $request, $id)
    {
        $this->validate($request,[
            'type' => 'required|in:trainee,trainer,assistant'
        ]);
        
        $type = $request->type;

        $training = $this->repository->findOrFail($id);
        $participants = $this->member->getAll()->filter(function($q) use ($training){
            return $q->status == 1 || in_array($q->id,$training->member()->get()->pluck('id')->toArray());
        })->pluck('name','id');

        $trainees = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'trainee';
        });

        $trainers = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'trainer';
        });
        
        $assistants = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'assistant';
        });

        return view($this->module.'.create_participant',compact('training','type','participants','assistants','trainers','trainees'));
    }

    public function storeParticipant(Request $request, $id)
    {
        $this->validate($request,[
            'participants' => 'required|array|exists:mef_members,id',
            'type' => 'required|in:trainer,trainee,assistant',
            'send_notification' => 'boolean'
        ]);

        $type = [];

        foreach($request->participants as $participant){
            $type[] = $request->type;
        }

        $request->request->add(['type' => $type]);

        $this->repository->assign($id,$request);

        return response()->json(['message' => trans('training.success_assigned',['type' => trans('training.'.$request->type[0])])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteTrainingRequest $request)
    {
        $this->repository->delete($request->ids);

        return response()->json(['message' => trans('general.success_delete_multi',['attribute' => trans('training.training'),'amount' => count(request('ids'))])]);
    }

    public function basic($id,MemberRepository $member)
    {
        $training = $this->repository->findOrFail($id);
        
        $participants = $member->getAll()->filter(function($q) use ($training){
            return $q->status == 1 || in_array($q->id,$training->member()->get()->pluck('id')->toArray());
        })->pluck('name','id');

        $trainees = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'trainee';
        });

        $trainers = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'trainer';
        });

        $assistants = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'assistant';
        });

        return view($this->module.'.basic',compact('training','participants','assistants','trainers','trainees'));
    }

    public function attendance($id,MemberRepository $member)
    {
        $training = $this->repository->findOrFail($id);
        $participants = $member->getAll()->filter(function($q) use ($training){
            return $q->status == 1 || in_array($q->id,$training->member()->get()->pluck('id')->toArray());
        })->pluck('name','id');

        $trainees = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'trainee';
        });

        $trainers = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'trainer';
        });

        $assistants = $training->member()->get()->filter(function($t){
            return $t->pivot->type == 'assistant';
        });

        return view($this->module.'.attendance',compact('training','participants','assistants','trainers','trainees'));
    }

    public function survey($id)
    {
        return view($this->module.'.survey');
    }

    public function document($id)
    {
        return view($this->module.'.document');
    }
    
    public function schedule($id,MemberRepository $member)
    {
        $training = $this->repository->findOrFail($id);
        $participants = $member->getAll()->filter(function($q) use ($training){
            return $q->status == 1 || in_array($q->id,$training->member()->get()->pluck('id')->toArray());
        })->pluck('name','id');

        $rooms = collect([]);
        if($training->location_id)
            $rooms = $this->room_repo->getAll($training->location_id);

        return view($this->module.'.schedule',compact('training','participants','rooms'));
    }

    public function assignParticipants($id,AssignParticipantsRequest $request)
    {
        $this->repository->assign($id,$request);

        return response()->json(['message' => trans('training.participant_assigned')]);
    }

    public function getcoursebyid(Request $request)
    {
        $course_id = $request->input('course_id');
        $course_data = $this->course_repo->findOrfail($course_id);
        $course_selected = $course_data->member()->get()->pluck('id');
        $return['course_selected'] = $course_selected;
        $return['members'] = $this->member->getAll()->filter(function($q) use ($course_selected){
            return collect($course_selected)->contains($q->id) || $q->status ==1;
        })->pluck('name','id')->toJson();
        return $return;

    }
}
