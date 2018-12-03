<?php

namespace App\Http\Controllers\BackEnd\Capacity;
use App\Http\Controllers\BackendController;
use App\Models\BackEnd\User\User;
use App\Repositories\Capacities\LocationRepository;
use App\Models\BackEnd\Capacity\Location;
use Illuminate\Http\Request;
use App\Http\Requests\Capacities\LocationRequest;
use App\Http\Requests\Capacities\DeleteLocationRequest;
use App\Models\BackEnd\Department\Department;
use App\Models\BackEnd\GeneralDepartment\GeneralDepartment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LocationController extends BackEndController
{
    protected $module = 'back-end.capacity.location';
    protected $repository;
    protected $location;

    public function __construct(LocationRepository $repo,Location $location)
    {
        parent::__construct();

        $this->location = $location;
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
        $locations = $this->repository->paginate(request()->all());

        return $locations;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $departments = Department::with('generalDepartment')->orderBy('mef_secretariat_id')->get()->pluck('name_with_parent','Id')->toJson();
        $general_departments = GeneralDepartment::orderBy('mef_ministry_id')->get()->pluck('name_with_parent','Id')->toJson();

        // query department where user login in
        if(!isAdmin()){
            $departiment_detail = User::find( session('sessionUser')->id);
            $result = Department::find($departiment_detail->mef_department_id);
        }else{
            $result =  null;
        }
        return view($this->module.'.new',compact('departments','general_departments'),compact('result'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
        $this->repository->create($request->all());

        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('location.location')])]);
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
        $location = $this->repository->findOrfail($id);
        $departments = Department::with('generalDepartment')->groupBy('mef_secretariat_id')->get(['Name','Id','mef_secretariat_id'])->pluck('Name','Id')->toJson();
        return view($this->module.'.edit',compact('location','departments'))->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocationRequest $request, $id)
    {
        $undeleteable = $this->unaccessible($request);

        if( $undeleteable)
            return response()->json(['message' => trans('general.permission_denied')],403);

        $location = $this->repository->findOrfail($id);
        if(! isAdmin() && !getUserMemberId()->push(session('sessionUser')->id)->contains($location->user_id)){
            return response()->json(['message' => trans('general.permission_denied')],403);
        }

        $this->repository->update($id,$request->all());

        return response()->json(['message' => trans('general.success_update',['attribute' => trans('location.location')])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteLocationRequest $request)
    {
        if( $undeleteable = $this->unaccessible($request))
            return response()->json(['message' => trans('general.permission_denied'),'data' => $undeleteable],403);
      
        $this->repository->delete($request->id);

        return response()->json(['message' => trans('general.success_delete_multi',['attribute' => trans('location.location'),'amount' => count(request('id'))])]);
    }

    private function unaccessible($request){
        $locations = $this->repository->getAll()->filter(function($q){
            return $q->public == 1;
        });
       
        $publics = collect($locations->pluck('id')->toArray());


        if(! isAdmin() && $publics->intersect($request->id)->count()){

            $not_deleteabled = $locations->filter(function($q) use ($publics,$request) {
                return $publics->intersect($request->id)->contains($q->id);
            })->pluck('name');

            return $not_deleteabled;
        }

        return false;
    }
}
