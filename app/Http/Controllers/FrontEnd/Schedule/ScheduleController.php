<?php

namespace App\Http\Controllers\FrontEnd\Schedule;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Models\FrontEnd\ScheduleModel;
use App\Models\BackEnd\Schedule\MeetingModel;
use Illuminate\Support\Facades\DB;
use Session;
use App\libraries\Tool;

class ScheduleController extends FrontendController
{
	public function __construct()
	{
		parent::__construct();
		$this->tool = new Tool();
		$this->meeting = new ScheduleModel();
		$this->meetingback = new MeetingModel();
		$this->userGuestSession = session('sessionGuestUser');
		if ($this->userGuestSession != null) {
			$this->officer_id = intval($this->userGuestSession->Id);
		}
	}

	public function getIndex()
	{
		$this->data['today'] = date('Y-m-d');
		$khmer_date = $this->tool->khmerDate($this->data['today']);
		$this->data['today_khmer'] = $khmer_date;
		$this->data['current_time'] = date("h:i A");
		return view($this->viewFolder . '.schedule.index')->with($this->data);
	}

	function postDetail(Request $request){
		$today = date('Y-m-d');
		$department_id = $this->userGuestSession->department;
		$this->data["allPersonalMeeting"] = DB::select(DB::raw("CALL get_data_meeting_by_id($request->mission_id)"));

		return view($this->viewFolder.'.schedule.detail')->with($this->data);
	}

	public function postNew(Request $request){
		return $this->new_edit($request);
	}

	public function postEdit(Request $request){
		return $this->new_edit($request);
	}

	function new_edit($request){

		$this->data['row'] = $this->meetingback->getDataByRowId($request->meeting_id);
		$office_id = 0;
		if($this->data['row'] != null){

		}
		$this->data['list_meeting_type'] = json_encode($this->meeting->getListMeetingType());
		$this->data['list_meeting_leader'] = json_encode($this->meetingback->getListMeetingLeader());
		$this->data['mef_meeting_atendee_join'] = $this->meetingback->getMeetingAtendeeJoinString($request->meeting_id);
		$this->data['get_office_officer'] = $this->meetingback->getOfficeIdOfOfficer($request->meeting_id);
		$this->data['mef_guest_meeting'] = $this->meetingback->getMefGuestMeeting($request->meeting_id);
		$this->data['mef_meeting_to_file'] = $this->meetingback->getMefMeetingToFile($request->meeting_id);
		$this->data['list_office'] = $this->meeting->getListOfficeByDepartmentId();
		$this->data['meetingLocation'] = $this->meeting->getMefMeetingLocation();
		$holiday= $this->meetingback->getHoliday();
		$arrHoliday = Array();
		foreach ($holiday as $key=>$val) {
			$arrHoliday[]=$val->date;
		}
		$this->data['holiday'] = $arrHoliday;

		return view($this->viewFolder.'.schedule.new')->with($this->data);
	}

	public function postOfficerForJoin(Request $request){
		$office_id = $request->Id;
		$leader_id = $request->leaderId;
		return $this->meeting->getMefOfficerForJoinByOfficeId($office_id,$leader_id);
	}

	public function postListAttendee(Request $request){
		$meeting_id = intval($request['Id']);
		$this->data['attendee'] = $this->meetingback->getListAttendee($meeting_id);
		$external_string = $this->meetingback->getExternalMeetingById($meeting_id);
		$this->data['external_string'] = $external_string;
		return view($this->viewFolder.'.meeting.list-attendee')->with($this->data);
	}


	public function postGetSituationPublicInfoByUserId(Request $request)
	{
		$office = $this->meeting->getListOfficeByDepartmentId();
		$location = $this->meeting->getListLocation();
		$leader = $this->meeting->getListMeetingLeader();
		$meetingType = $this->meeting->getListMeetingType();
		$getDataHoliday = DB::table('mef_holiday')->select('date')->get();
		$array = array(
			'office' => $office,
			'location' => $location,
			'leader' => $leader,
			'meetingType' => $meetingType,
			'holiday'=>$getDataHoliday
		);
		return json_encode($array);
	}

	public function postGetDataById(Request $request)
	{
		$this->datas['row'] = $this->meetingback->getDataByRowId($request['Id']);
		$this->datas['officer'] = $this->meeting->getAtendeeMeetingById($request['Id']);
		$this->datas['guest'] = $this->meetingback->getMefGuestMeeting($request['Id']);
		$this->data['get_office_officer'] = $this->meetingback->getOfficeIdOfOfficer($request['Id']);
//		dd($this->datas);
		return $this->datas;
	}

	public function postCheckMeetingLocation(Request $request)
	{
		$office_id = $request['officeId'];
		$meetingTime = $request['meetingTime'];
		$meetingDate = $request['meetingDate'];
		$id = $request['Id'];
		return $this->meeting->getCheckMeetingRoom($id,$office_id, $meetingDate, $meetingTime);
	}

	public function postGetAllData(Request $request)
	{
		return $this->meeting->getAllMeeting();
	}

	public function postGetAllPersonalMeeting(Request $request)
	{
		return $this->meeting->getAllPersonalMeeting($this->officer_id);
	}

	public function postGetAllHistoryMeeting(Request $request)
	{
		return $this->meeting->getAllHistoryMeeting($request['date']);
	}

	public function postSave(Request $request)
	{
//		dd($request->all());
		return $this->meeting->postSave($request->all());
	}

	public function getEvents()
	{
		$monthly = array();
		$schedules = $this->meeting->getMySchedule($this->officer_id);
		$missions = $this->meeting->getMyMission($this->officer_id);

		$data = [];
//		dd($schedules);
		if(!Empty($schedules)){
			foreach ($schedules as $schedule) {
				$data['monthly'][] = $schedule;
			}
		}
		if(!Empty($missions)){
			foreach ($missions as $mission) {
				$data['monthly'][] = $mission;
			}
		}

		if(empty($data)){
			$data = [
				"monthly"=>[
					0=>[
						"id"=> "",
						"startdate" => "0000-00-00",
						"starttime" => "00:00",
						"name" => "",
						"color" => "",
						"location" => "",
						"chairby" => ""
					]
				]
			];

		}else{
			$data = $data ;
		}
//		dd($data);
		return json_encode($data);
	}

	public function postGetMeetingById(Request $request)
	{

		$meeting_id = intval($request->meeting_id);
		if ($meeting_id > 0) {
			$json_string = $this->meeting->getMeetingById($meeting_id);
			$external_string = $this->meeting->getExternalMeetingById($meeting_id);
			$this->data['attendee'] = $json_string;
			$this->data['external_string'] = $external_string;
			return view($this->viewFolder . '.schedule.list-attendee')->with($this->data);
		}
	}

	public function postGetMissionById(Request $request)
	{
		$mission_id = intval($request->mission_id);
		if ($mission_id > 0) {
			$json_string = $this->meeting->getMissionById($mission_id);
//			$external_string = array();
			$this->data['attendee'] = $json_string;
//			$this->data['external_string'] = $external_string;
			return view($this->viewFolder . '.schedule.list-attendee')->with($this->data);
		}
	}

	public function postGetMissionLeaderById(Request $request)
	{
		$mission_id = intval($request->mission_id);
//		dd($mission_id);
		if ($mission_id > 0) {
			$json_string = $this->meeting->getMissionLeaderById($mission_id);
//			$external_string = array();
			$this->data['attendee'] = $json_string;
//			$this->data['external_string'] = $external_string;
			return view($this->viewFolder . '.schedule.list-mission-leader')->with($this->data);
		}
	}

	public function postDelete(Request $request){
		$arryId = array();
		$arryId[] = isset($request['Id']) ? $request['Id']:'';
		return $this->meetingback->postDelete($arryId);
	}
}
