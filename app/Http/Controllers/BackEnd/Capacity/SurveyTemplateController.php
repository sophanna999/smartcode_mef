<?php

namespace App\Http\Controllers\BackEnd\Capacity;
use App\Http\Controllers\BackendController;
use App\Models\BackEnd\User\User;
use App\Repositories\Capacities\SurveyTemplateRepository;
use App\Repositories\Capacities\QuestionRepository;
use App\Models\BackEnd\Capacity\SurveyTemplate;
use Illuminate\Http\Request;
use App\Http\Requests\Capacities\StoreSurveyTemplateRequest;
use App\Http\Requests\Capacities\UpdateSurveyTemplateRequest;
use App\Http\Requests\Capacities\DeleteSurveyTemplateRequest;
use App\Models\BackEnd\Department\Department;
use App\Models\BackEnd\GeneralDepartment\GeneralDepartment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SurveyTemplateController extends BackEndController
{
    protected $module = 'back-end.capacity.surveytemplate';
    protected $repository;
    protected $surveyTemplate;
    protected $question;

    public function __construct(SurveyTemplateRepository $repo,QuestionRepository $question,SurveyTemplate $surveyTemplate)
    {
        parent::__construct();

        $this->surveyTemplate = $surveyTemplate;
        $this->repository = $repo;
        $this->question = $question;
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
        $surveyTemplates = $this->repository->paginate(request()->all());

        return $surveyTemplates;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $questions = $this->question->getAll()->pluck('title','id')->toJson();
        $answer_types = collect(config('system.answer_types'))->toJson();

        return view($this->module.'.new',compact('questions'),compact('result','answer_types'))->with($this->data);
    }

    public function createQuestion() {
        $answer_types = collect(config('system.answer_types'))->toJson();

        return view($this->module.'.new_question',compact('answer_types'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveyTemplateRequest $request)
    {
        $this->repository->create($request->all());

        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('survey.survey_template')])]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $survey_template = $this->repository->findOrfail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $survey_template = $this->repository->findOrfail($id);
        $questions = $this->question->getAll()->pluck('title','id')->toJson();
        $answer_types = collect(config('system.answer_types'))->toJson();

        return view($this->module.'.edit',compact('survey_template','questions','answer_types'))->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurveyTemplateRequest $request, $id)
    {
        $survey_template = $this->repository->findOrfail($id);

        $this->repository->update($id,$request->all());

        return response()->json(['message' => trans('general.success_update',['attribute' => trans('survey.survey_template')])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteSurveyTemplateRequest $request)
    {
        $this->repository->delete($request->id);

        return response()->json(['message' => trans('general.success_delete_multi',['attribute' => trans('survey.survey_template'),'amount' => count(request('id'))])]);
    }

}
