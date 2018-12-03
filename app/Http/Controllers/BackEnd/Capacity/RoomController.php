<?php

namespace App\Http\Controllers\BackEnd\Capacity;
use App\Http\Controllers\BackendController;
use App\Repositories\Capacities\RoomRepository;
use App\Repositories\Capacities\LocationRepository;
use App\Models\BackEnd\Capacity\Room;
use App\Models\BackEnd\User\User;
use App\Models\BackEnd\GeneralDepartment\GeneralDepartment;
use App\Models\BackEnd\Department\Department;
use Illuminate\Http\Request;
use App\Http\Requests\Capacities\RoomRequest;
use App\Http\Requests\Capacities\DeleteRoomRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class RoomController extends BackEndController
{
    protected $module = 'back-end.capacity.room';
    protected $repository;
    protected $room;

    public function __construct(RoomRepository $repo,Room $room)
    {
        parent::__construct();

        $this->room = $room;
        $this->repository = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LocationRepository $location_repo)
    {
        return view($this->module.'.index')->with($this->data);
    }

    public function lists()
    {
        $rooms = $this->repository->paginate(request()->all());
        return $rooms;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LocationRepository $location_repo)
    {
        $locations = $location_repo->getAll()->pluck('code_with_name', 'id','is_default')->toJson();
        
        $departments = Department::with('generalDepartment')->groupBy('mef_secretariat_id')->get(['Name','Id','mef_secretariat_id'])->pluck('Name','Id')->toJson();
        return view($this->module.'.new',compact('locations','departments'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $request->request->add(['location_id' => $request->location]);

        $this->repository->create($request->all());

        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('room.room')])]);
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
    public function edit(LocationRepository $location_repo,$id)
    {
        $room = $this->repository->findOrfail($id);
        $locations = $location_repo->getAll()->pluck('code_with_name', 'id')->toJson();
        $departments = Department::with('generalDepartment')->groupBy('mef_secretariat_id')->get(['Name','Id','mef_secretariat_id'])->pluck('Name','Id')->toJson();

        return view($this->module.'.edit',compact('room','locations','departments'))->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, $id)
    {
        if($this->unaccessible($request))
            return response()->json(['message' => trans('general.permission_denied')],403);

        $request->request->add(['location_id' => $request->location]);

        $this->repository->update($id,$request->all());

        return response()->json(['message' => trans('general.success_update',['attribute' => trans('room.room')])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRoomRequest $request)
    { 
        if( $undeleteable = $this->unaccessible($request))
            return response()->json(['message' => trans('general.permission_denied'),'data' => $undeleteable],403);
        
        $this->repository->delete($request->id);

        return response()->json(['message' => trans('general.success_delete_multi',['attribute' => trans('room.room'),'amount' => count(request('id'))])]);
    }

    private function unaccessible(Request $request){
        $rooms = $this->repository->getAll()->filter(function($q){
            return $q->public == 1;
        });
        
        $publics = collect($rooms->pluck('id')->toArray());
       
        if(! isAdmin() && $publics->intersect($request->id)->count()){

            $not_deleteabled = $rooms->filter(function($q) use ($publics,$request) {
                return $publics->intersect($request->id)->contains($q->id);
            })->pluck('name');
            
            return $not_deleteabled;
        }

        return false;
    }
}
