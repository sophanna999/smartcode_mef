<?php

namespace App\Http\Controllers\BackEnd\Capacity;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Capacity\Subject;
use App\Models\BackEnd\Capacity\Member;
use App\Models\BackEnd\Officer\Officer;
use App\Models\BackEnd\Profile;
use App\Http\Requests\Capacities\StoreMemberRequest;
use App\Http\Requests\Capacities\UpdateMemberRequest;
use App\Http\Requests\Capacities\DeleteMemberRequest;
use App\Repositories\Capacities\MemberRepository;
use App\Repositories\Capacities\SubjectRepository;

class MemberController extends BackEndController
{
    protected $module = 'back-end.capacity.member';

    protected $request;
    protected $repository;

    public function __construct(Request $request,MemberRepository $member)
    {
        parent::__construct();

        $this->request = $request;
        $this->repository = $member;
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
        $members = $this->repository->paginate($this->request->all());

        return $members;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(SubjectRepository $subject)
    {
        $subjects = $subject->getAll()->filter(function($q) {
            return $q->status == 1;
        })->pluck('name','id')->toJson();

        $officers = collect(officer::with('personalInfo')
                    ->doesntHave('member')
                    ->active()
                    ->approved()
                    ->get()
                    )->pluck('name_with_khmer','Id')->toJson();

        return view($this->module.'.new',compact('subjects','officers'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        $this->repository->create($request);

        return response()->json(['message' => trans('general.success_insert',['attribute'=>trans('member.member')])]);
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
        $member = Member::with('profile','officer')->findOrFail($id);

        $subjects = Subject::select('name','id')->get()->toJson();
        
        $officers = officer::with('personalInfo')->active()->approved()->orWhere('Id',$member->officer_id)->doesntHave('member')->get()->pluck('name_with_khmer','Id')->toJson();
        
        return view($this->module.'.edit',compact('subjects','officers','member'))->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        $this->repository->update($id,$request);

        return response()->json(['message' => trans('general.success_update',['attribute'=>trans('member.member')])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteMemberRequest $request)
    {
        $this->repository->delete($request->id);
        
        return response()->json(['message' => trans('general.success_delete_multi',['attribute' => trans('member.member'),'amount' => count(request('id'))])]);
    }
}
