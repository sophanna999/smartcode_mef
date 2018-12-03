<?php

namespace App\Http\Controllers\BackEnd\Capacity;
use App\Http\Controllers\BackendController;
use App\Repositories\Capacities\SubjectRepository;
use App\Models\BackEnd\Capacity\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\Capacities\SubjectRequest;
use App\Http\Requests\Capacities\DeleteSubjectRequest;
use App\Models\BackEnd\Department\Department;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubjectController extends BackEndController
{
    protected $module = 'back-end.capacity.subject';
    protected $repository;
    protected $subject;

    public function __construct(SubjectRepository $repo,Subject $subject)
    {
        parent::__construct();

        $this->subject = $subject;
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
        $subjects = $this->repository->paginate(request()->all());

        return $subjects;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::with('generalDepartment')->orderBy('mef_secretariat_id')->get()->pluck('name_with_parent','Id')->toJson();
    
        return view($this->module.'.new',compact('departments'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        $this->repository->create($request->all());

        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('subject.subject')])]);
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
        $subject = $this->repository->findOrfail($id);
        $departments = Department::with('generalDepartment')->orderBy('mef_secretariat_id')->get()->pluck('name_with_parent','Id')->toJson();

        return view($this->module.'.edit',compact('subject','departments'))->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, $id)
    {
        if($this->unaccessible($request))
            return response()->json(['message' => trans('general.permission_denied')],403);

        $this->repository->update($id,$request->all());

        return response()->json(['message' => trans('general.success_update',['attribute' => trans('subject.subject')])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteSubjectRequest $request)
    {
        if( $undeleteable = $this->unaccessible($request))
            return response()->json(['message' => trans('general.permission_denied'),'data' => $undeleteable],403);

        $this->repository->delete($request->id);

        return response()->json(['message' => trans('general.success_delete_multi',['attribute' => trans('subject.subject'),'amount' => count(request('id'))])]);
    }

    private function unaccessible($request){
        $subjects = $this->repository->getAll()->filter(function($q){
            return $q->public == 1;
        });
       
        $publics = collect($subjects->pluck('id')->toArray());
    
        if(! isAdmin() && $publics->intersect($request->id)->count()){

            $not_deleteabled = $subjects->filter(function($q) use ($publics,$request) {
                return $publics->intersect($request->id)->contains($q->id);
            })->pluck('name');
            
            return $not_deleteabled;
        }

        return false;
    }
}
