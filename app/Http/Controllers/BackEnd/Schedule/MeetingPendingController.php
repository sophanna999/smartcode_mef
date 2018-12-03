<?php
namespace App\Http\Controllers\BackEnd\Schedule;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BackEnd\Schedule\MeetingPendingModel;

class MeetingPendingController extends BackendController {

	public function __construct(){
		parent::__construct();
		$this->meetingPending = new MeetingPendingModel();
		$this->viewFolder = $this->viewFolder.'.schedule';
	}

	public function getIndex(){

		return view($this->viewFolder.'.meeting-pending.index')->with($this->data);
	}

	public function postIndex(Request $request){

		return $this->meetingPending->getDataGrid($request->all());
	}

	public function postApprove(Request $request){
		$meetingId = $request['Id'];
		$this->data['row'] = $this->data["allPersonalMeeting"] = DB::select(DB::raw("CALL get_data_meeting_by_id($meetingId)"));
		return view($this->viewFolder.'.meeting-pending.new')->with($this->data);
	}

	public function postSave(Request $request){

		return $this->meetingPending->approve($request->all());
	}
	public function postReject(Request $request){
		return $this->meetingPending->reject($request->all());
	}

}
