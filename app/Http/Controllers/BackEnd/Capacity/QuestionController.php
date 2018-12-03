<?php

namespace App\Http\Controllers\BackEnd\Capacity;
use App\Http\Controllers\BackendController;
use App\Models\BackEnd\User\User;
use App\Repositories\Capacities\QuestionRepository;
use App\Models\BackEnd\Capacity\Question;
use Illuminate\Http\Request;
use App\Http\Requests\Capacities\StoreQuestionRequest;
use App\Http\Requests\Capacities\DeleteQuestionRequest;
use App\Models\BackEnd\Department\Department;
use App\Models\BackEnd\GeneralDepartment\GeneralDepartment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionController extends BackEndController
{
    protected $module = 'back-end.capacity.question';
    protected $repository;
    protected $surveyTemplate;

    public function __construct(QuestionRepository $repo,Question $surveyTemplate)
    {
        parent::__construct();

        $this->surveyTemplate = $surveyTemplate;
        $this->repository = $repo;
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

    public function create() {
        $answer_types = collect(config('system.answer_types'))->toJson();

        return view($this->module.'.new',compact('answer_types'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = $this->repository->create($request->all());

        return response()->json(['question' => $question,'message' => trans('general.success_insert',['attribute' => trans('survey.question')])]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->repository->findOrfail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surveyTemplate = $this->repository->findOrfail($id);
        $departments = Department::with('generalDepartment')->groupBy('mef_secretariat_id')->get(['Name','Id','mef_secretariat_id'])->pluck('Name','Id')->toJson();
        return view($this->module.'.edit',compact('surveyTemplate','departments'))->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, $id)
    {
        $undeleteable = $this->unaccessible($request);

        if( $undeleteable)
            return response()->json(['message' => trans('general.permission_denied')],403);

        $surveyTemplate = $this->repository->findOrfail($id);
        if(! isAdmin() && !getUserMemberId()->push(session('sessionUser')->id)->contains($surveyTemplate->user_id)){
            return response()->json(['message' => trans('general.permission_denied')],403);
        }

        $this->repository->update($id,$request->all());

        return response()->json(['message' => trans('general.success_update',['attribute' => trans('survey.question')])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteQuestionRequest $request)
    {
        if( $undeleteable = $this->unaccessible($request))
            return response()->json(['message' => trans('general.permission_denied'),'data' => $undeleteable],403);
      
        $this->repository->delete($request->id);

        return response()->json(['message' => trans('general.success_delete_multi',['attribute' => trans('survey.question'),'amount' => count(request('id'))])]);
    }

    private function unaccessible($request){
        $surveyTemplates = $this->repository->getAll()->filter(function($q){
            return $q->public == 1;
        });
       
        $publics = collect($surveyTemplates->pluck('id')->toArray());


        if(! isAdmin() && $publics->intersect($request->id)->count()){

            $not_deleteabled = $surveyTemplates->filter(function($q) use ($publics,$request) {
                return $publics->intersect($request->id)->contains($q->id);
            })->pluck('name');

            return $not_deleteabled;
        }

        return false;
    }
}
