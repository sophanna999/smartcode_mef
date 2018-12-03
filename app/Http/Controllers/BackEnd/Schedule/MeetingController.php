<?php 
namespace App\Http\Controllers\BackEnd\Schedule;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BackEnd\Schedule\MeetingModel;

class MeetingController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->meetingModel = new MeetingModel();
		$this->viewFolder = $this->viewFolder.'.schedule';
    }

    public function getIndex(){
        return view($this->viewFolder.'.meeting.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->meetingModel->getDataGrid($request->all());
    }
	
	public function postNew(Request $request){
		return $this->new_edit($request);
    }
	
	public function postEdit(Request $request){
		return $this->new_edit($request);
    }
	
	function new_edit($request){
		$this->data['row'] = $this->meetingModel->getDataByRowId($request['Id']);
//		dd($this->data['row']);
		$office_id = 0;
		if($this->data['row'] != null){

//			$office_id = $this->data['row']->mef_office_id;
		}
		$this->data['list_meeting_type'] = json_encode($this->meetingModel->getListMeetingType());
		$this->data['list_meeting_leader'] = json_encode($this->meetingModel->getListMeetingLeader());
		$this->data['mef_meeting_atendee_join'] = $this->meetingModel->getMeetingAtendeeJoinString($request['Id']);
		$this->data['get_office_officer'] = $this->meetingModel->getOfficeIdOfOfficer($request['Id']);
		$this->data['mef_guest_meeting'] = $this->meetingModel->getMefGuestMeeting($request['Id']);
		$this->data['mef_meeting_to_file'] = $this->meetingModel->getMefMeetingToFile($request['Id']);
		$this->data['list_office'] = $this->meetingModel->getListOfficeByDepartmentId();
		$this->data['meetingLocation'] = $this->meetingModel->getMefMeetingLocation();
		$holiday= $this->meetingModel->getHoliday();
		$arrHoliday = Array();
		foreach ($holiday as $key=>$val) {
			$arrHoliday[]=$val->date;
		}
		$this->data['holiday'] = $arrHoliday;
//		dd($this->data['holiday']);
        return view($this->viewFolder.'.meeting.new')->with($this->data);
	}
	
	public function postSave(Request $request){

        return $this->meetingModel->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->meetingModel->postDelete($listId);
    }
	
	public function postOfficerForJoin(Request $request){
		$office_id = $request['Id'];
		$leaderId = '';
		if($request['leaderId'] !=null){
			$leaderId = $request['leaderId'];
		}
		return $this->meetingModel->getMefOfficerForJoinByOfficeId($office_id,$leaderId);
	}
	
	public function postListAttendee(Request $request){
        $meeting_id = intval($request['Id']);
		$this->data['attendee'] = $this->meetingModel->getListAttendee($meeting_id);
        $external_string = $this->meetingModel->getExternalMeetingById($meeting_id);
        $this->data['external_string'] = $external_string;
        return view($this->viewFolder.'.meeting.list-attendee')->with($this->data);
	}
	
	public function postModalExport(Request $request){
		$this->data['mef_officer_department'] = $this->meetingModel->getMefOfficerForJoinByOfficeId(0);
		return view($this->viewFolder.'.meeting.modal-export')->with($this->data);
	}
	
	public function postExport(Request $request){
		return $this->meetingModel->export($request->all());
	}
	
	public function postCheckExport(Request $request){
		return $this->meetingModel->checkDataExport($request->all());
	}

}
