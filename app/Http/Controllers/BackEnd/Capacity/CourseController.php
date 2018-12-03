<?php

namespace App\Http\Controllers\BackEnd\Capacity;
use App\Http\Controllers\BackendController;
use App\Repositories\Capacities\CourseRepository;
use App\Repositories\Capacities\SubjectRepository;
use App\Models\BackEnd\Capacity\CourseSurvey;
use App\Models\BackEnd\Capacity\Course;
use App\Models\BackEnd\Capacity\Subject;
use App\Repositories\Capacities\QuestionRepository;
use App\Repositories\Capacities\SurveyTemplateRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Capacities\StoreCourseRequest;
use App\Http\Requests\Capacities\StoreCourseSurveyRequest;
use App\Http\Requests\Capacities\UpdateCourseRequest;
use App\Http\Requests\Capacities\DeleteCourseRequest;
use App\Repositories\Capacities\MemberRepository;
use App\Models\BackEnd\Capacity\Member;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CourseController extends BackEndController
{
    protected $module = 'back-end.capacity.course';
    protected $repository;
    protected $subject;
    protected $member;
    protected $member_model;
    protected $question;
    protected $question_template;

    public function __construct(CourseRepository $repo,
        SubjectRepository $subject, 
        MemberRepository $member, 
        Member $member_model,
        QuestionRepository $question,
        SurveyTemplateRepository $question_template
        )
    {
        parent::__construct();
        $this->repository = $repo;
        $this->subject = $subject;
        $this->member = $member;
        $this->member_model = $member_model;
        $this->question = $question;
        $this->question_template = $question_template;
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
        $courses = $this->repository->paginate(request()->all());

        return $courses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = $this->subject->getAll()->filter(function($q) {
            return $q->status == 1;
        })->pluck('name','id')->toJson();
        $members = $this->member_model->with('profile')->get()->pluck('name','id')->toJson();
        $questions = $this->question->getAll()->pluck('title','id')->toJson();
        $question_templates = $this->question_template->getAll()->pluck('name','id')->toJson();
        $answer_types = collect(config('system.answer_types'))->toJson();
        return view($this->module.'.new',compact('subjects','members','questions','question_templates','answer_types'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        $this->repository->create($request->all());
        
        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('course.course')])]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = $this->repository->findOrfail($id);

        return view($this->module.'.show',compact('course'))->with($this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = $this->repository->findOrfail($id);
        $subjects_selected = $course->subject()->get()->pluck('id');
        $members_selected = $course->member()->get()->pluck('id');
        $subjects = $this->subject->getAll()->filter(function($q) use ($subjects_selected) {
            return collect($subjects_selected)->contains($q->id) || $q->status == 1;
        })->pluck('name','id')->toJson();

        $members = $this->member->getAll()->filter(function($q) use ($members_selected){
            return collect($members_selected)->contains($q->id) || $q->status ==1;
        })->pluck('name','id')->toJson();
        $subjects_selected = $subjects_selected->toJson();
        $members_selected = $members_selected->toJson();

        return view($this->module.'.edit',compact('course','subjects','subjects_selected','members_selected','members'))->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        $this->repository->update($id,$request->all());

        return response()->json(['message' => trans('general.success_update',['attribute' => trans('course.course')])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteCourseRequest $request)
    {
        $this->repository->delete($request->id);

        return response()->json(['message' => trans('general.success_delete_multi',['attribute' => trans('course.course'),'amount' => count(request('id'))])]);
    }

    public function basic($id)
    {
        $course = $this->repository->findOrfail($id);

        return view($this->module.'.survey.basic',compact('course'))->with($this->data);
    }

    public function survey($id)
    {
        $course = $this->repository->findOrfail($id);

        return view($this->module.'.survey.list',compact('course'))->with($this->data);
    }

    public function surveyList($id)
    {
        $course = $this->repository->findOrfail($id);

        $surveies = $course->survey->toJson();

        return $surveies;
    }

    public function surveyCreate($id)
    {
        $course = $this->repository->findOrfail($id);

        $questions = $this->question->getAll()->pluck('title','id')->toJson();
        $question_templates = $this->question_template->getAll()->pluck('name','id')->toJson();
        $answer_types = collect(config('system.answer_types'))->toJson();

        return view($this->module.'.survey.new',compact('answer_types','question_templates','questions','course'))->with($this->data);
    }

    public function surveyStore($id, StoreCourseSurveyRequest $request)
    {
        $course = $this->repository->findOrfail($id);

        $survey = CourseSurvey::create([
            'course_id' => $id,
            'name' => $request->name,
        ]);

        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('survey.survey')])]);
    }
}
