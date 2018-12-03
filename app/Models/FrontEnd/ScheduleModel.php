<?php

namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\DB;
use App\libraries\Tool;
use Carbon\Carbon;

class ScheduleModel{

	public function __construct()
    {
	    $this->userGuestSession = session('sessionGuestUser');
	    $this->Tool = new Tool();
    }

	public function getAllPersonalMeeting($mef_officer_id){

		$today = date('Y-m-d');
		$department_id = $this->userGuestSession->department;
		$this->data["allHistoryMeeting"] = DB::select(DB::raw("CALL get_personal_meeting('".$today."',$department_id,$mef_officer_id)"));
		return  $this->data["allHistoryMeeting"];
//
	}

	public function getAllHistoryMeeting($date){

		$today = date('Y-m-d');
		$create_by_user_id = $this->userGuestSession->Id;
		$get_role_id = DB::table('mef_user')->where('mef_officer_id',$create_by_user_id)->first();
		$role_id = $get_role_id->moef_role_id;
		$this->data["allHistoryMeeting"] = DB::select(DB::raw("CALL get_all_history_meeting('".date('Y-m-d', strtotime($date))."',$role_id)"));

		return  $this->data["allHistoryMeeting"];
//
	}

	public function getMySchedule($mef_officer_id){
		$date= date_create(date('Y-m-d'));
		date_sub($date,date_interval_create_from_date_string("2 month"));

        $listDb = DB::table('mef_meeting AS m')
            ->leftjoin('mef_meeting_atendee_join AS mj','m.Id','=','mj.mef_meeting_id')
            ->leftjoin('mef_officer AS Leader','m.mef_meeting_leader_id','=','Leader.Id')
            ->leftjoin('mef_meeting_type AS mt','m.mef_meeting_type_id','=','mt.Id')
	        ->leftjoin('mef_meeting_room', 'm.meeting_location_id', '=', 'mef_meeting_room.id')
	        ->leftjoin('mef_personal_information AS per', 'Leader.Id', '=', 'per.MEF_OFFICER_ID')
            ->where('mj.mef_officer_id', $mef_officer_id)
	        ->where('m.meeting_date','>=',date_format($date,"Y-m-d"))
	        ->orWhere('m.mef_meeting_leader_id',$mef_officer_id)
            ->select(
                'm.Id AS id',
                'm.meeting_date AS startdate',
                'm.meeting_time_24 AS starttime',
                'm.meeting_objective AS name',
                'm.color',
                'mef_meeting_room.name AS location',
                'per.FULL_NAME_KH AS chairby'
            )
	        ->groupBy('m.Id')
            ->orderBy('m.meeting_date','DESC')->get();

        return $listDb;
    }

	public function getMyMission($mef_officer_id){
		$date= date_create(date('Y-m-d'));
		date_sub($date,date_interval_create_from_date_string("2 month"));

		$listMission = DB::table('mef_mission AS mi')
			->join('mef_mission_to_officer AS mtf','mtf.mef_mission_id','=','mi.id')
			->where('mtf.mef_officer_id', $mef_officer_id)
			->where('mi.mission_from_date','>=',date_format($date,"Y-m-d"))
			->select(
				'mi.id AS id',
				'mi.mission_from_date AS startdate',
				'mi.mission_to_date AS enddate',
				DB::raw("CONCAT(' ') AS starttime"),
				'mi.mission_objective AS name',
				DB::raw("CONCAT('#d43b29') AS color"),
				'mi.mission_location AS location',
				DB::raw("CONCAT('មិនមាន') AS chairby")
			)
			->groupBy('mi.id')
			->orderBy('mi.mission_from_date','DESC')
			->get();
//		dd($listMission);
		return $listMission;
	}

	public function getMeetingById($meeting_id){
	    $array = array();

        $query = DB::table('mef_meeting_atendee_join')
                    ->join('v_mef_officer', 'mef_meeting_atendee_join.mef_officer_id', '=', 'v_mef_officer.Id')
                    ->select(
                            'mef_meeting_atendee_join.is_join',
                            'v_mef_officer.full_name_kh',
                            'v_mef_officer.full_name_en',
                            'v_mef_officer.avatar',
                            'v_mef_officer.email',
                            'v_mef_officer.phone_number_1'
                    )
                    ->where('mef_meeting_atendee_join.mef_meeting_id',$meeting_id)
                    ->orderBy('v_mef_officer.position_order', 'ASC')
                    ->get();
        if(count($query) > 0){
            $array = $query;
        }
        return (object)$array;
    }

	public function getMefMeetingLocation(){
		$create_by_user_id = $this->userGuestSession->Id;

		$get_role_id = DB::table('mef_user')->where('mef_officer_id',$create_by_user_id)->first();
		$role_id = explode(',',$get_role_id->moef_role_id);
		$getRoomId = DB::table('mef_using_room')->where('mef_officer_id',$this->userGuestSession->Id)->get();
		foreach ($getRoomId as $key=>$val){
			$role_id[] = $val->meeting_room_id;
		}
//		dd($role_id);
		$arrList = DB::table('mef_meeting_room')->whereIn('mef_role_id',$role_id);
		$arrList = $arrList->orderBy('id', 'ASC')->get();
		$arr = array(array("text"=>"", "value" => ""));

		foreach($arrList as $row){
			$arr[] = array(
				'text' =>$row->name,
				'value' =>$row->id
			);
		}
		return json_encode($arr,JSON_UNESCAPED_UNICODE);
	}

	public function getMissionById($mission_id){
		$array = array();
		$query = DB::table('mef_mission_to_officer')
			->leftjoin('mef_mission', 'mef_mission_to_officer.mef_officer_id', '=', 'mef_mission.id')
			->leftjoin('v_mef_officer', 'mef_mission_to_officer.mef_officer_id', '=', 'v_mef_officer.Id')
			->select(
				'v_mef_officer.full_name_kh',
				'v_mef_officer.full_name_en',
				'v_mef_officer.avatar',
				'v_mef_officer.email',
				'v_mef_officer.phone_number_1'
			)
			->where('mef_mission_to_officer.mef_mission_id',$mission_id)
			->orderBy('v_mef_officer.position_order', 'ASC')
			->get();
		if(count($query) > 0){
			$array = $query;
		}
		return (object)$array;
	}

	public function getMissionLeaderById($mission_id){
		$array = array();
		$query = DB::table('mef_mission_leader')
			->leftjoin('mef_mission_to_officer', 'mef_mission_to_officer.id', '=', 'mef_mission_leader.mef_mission_id')
			->leftjoin('v_mef_officer', 'mef_mission_leader.officer_id', '=', 'v_mef_officer.Id')
			->select(
				'v_mef_officer.full_name_kh',
				'v_mef_officer.full_name_en',
				'v_mef_officer.avatar',
				'v_mef_officer.email',
				'v_mef_officer.phone_number_1'
			)
			->where('mef_mission_leader.mef_mission_id',$mission_id)
			->orderBy('v_mef_officer.position_order', 'ASC')
			->get();
//		dd($query);
		if(count($query) > 0){
			$array = $query;
		}
		return (object)$array;
	}

    public function getExternalMeetingById($meeting_id){
        $query = DB::table('mef_meeting')
                ->where('Id',$meeting_id)
                ->first();
	    $arrOfficer = explode(' ', $query->mef_member_outside);
        return $arrOfficer;
    }

	public function getAtendeeMeetingById($meeting_id){
		$query = DB::table('mef_meeting_atendee_join')
			->where('mef_meeting_id',$meeting_id)
			->get();
		return $query;
	}

	public function getListOfficeByDepartmentId(){
		$department_id = $this->userGuestSession->department;
//		dd($this->userGuestSession->department);
		$arrList = DB::table('mef_office')
			->where('mef_department_id',$department_id)
			->orderBy('Name', 'ASC')
			->get();
		$arr = array(array("text"=>"", "value" => ""));
		if(!empty($arrList)){
            foreach($arrList as $row){
                $arr[] = array(
                    'text' 	=>$row->Name,
                    "value" =>$row->Id
                );
            }
        }
		return $arr;
	}

	public function getListMeetingLeader(){
//		dd($this->userGuestSession);
		$department_id = $this->userGuestSession->department;
		$arrList = DB::table('v_mef_officer')
			->where('department_id',$department_id)
			->whereIn('is_approve',[2,3])
			->where('approve',null)
			->where('active',1)
			->orderBy('position_order', 'DESC')
			->get();
		$arr = array(array("text"=>"", "value" => ""));
		if(!empty($arrList)){
            foreach($arrList as $row){
                $arr[] = array(
                    'text' 	=>$row->full_name_kh,
                    "value" =>$row->Id
                );
            }
        }
		return $arr;
	}

	public function getListMeetingType(){
		$get_role_id = DB::table('mef_user')->where('mef_officer_id',$this->userGuestSession->Id)->first();
		$roleId = $get_role_id->moef_role_id;
		$arrList = DB::table('mef_meeting_type')
			->where('mef_role_id',$roleId)
			->orderBy('order_number', 'ASC')
			->get();
		$arr = array(array("text"=>"", "value" => ""));
		if(!empty($arrList)){
            foreach($arrList as $row){
                $arr[] = array(
                    'text' 	=> $row->Name,
                    "value" => $row->Id
                );
            }
        }
		return $arr;
	}

	public function getCheckMeetingRoom($data){
//		dd($data);
		$meetingDatelast =date('Y-m-d', strtotime($data['meeting_date']));
		$time24 = date('H:i:s', strtotime($data['meeting_time']));
		$endTime24 = date('H:i:s', strtotime($data['meeting_end_time24']));
		$getTime = DB::table('v_meeting_end_time')
				->where('meeting_location_id',$data['meeting_location_id'])
				->where('meeting_date',$meetingDatelast)
				->Where(function($query) use ($time24,$endTime24){
					$query->whereBetween('meeting_end_time', array($time24, $endTime24))
					->orWhere('meeting_time_24','>=',$time24)->where('meeting_end_time','<=',$time24);
				})
				->where('Id','<>',$data['Id'])
				->count();
		if($getTime){
			return array("code" => 1, "message" => "បន្ទប់ជាប់រវល់", "data" => "");
		}else{
			return array("code" => 2, "message" => "ok", "data" => "");
		}
	}

	public function getAllMeeting(){
//		$arrRoleId = array();
		$today = date('Y-m-d');
		$create_by_user_id = $this->userGuestSession->Id;
		$get_role_id = DB::table('mef_user')->where('mef_officer_id',$create_by_user_id)->first();
		$role_id = explode(',',$get_role_id->moef_role_id);

		$this->data["nearlyMeeting"] = DB::select(DB::raw("CALL get_all_meeting_by_department('".$today."', '".$get_role_id->moef_role_id."',$get_role_id->mef_department_id)"));
		return  $this->data["nearlyMeeting"];
	}

	public function postSave($data)
	{
		$startTime = date('H:i:s', strtotime($data['meeting_time']));
		$endTime = date('H:i:s', strtotime($data['meeting_end_time']));
		$maxStartTime= date("7:00:00");
		$maxEndTime= date("18:00:00");
		if(strtotime($startTime) <  strtotime($maxStartTime) || strtotime($startTime) > strtotime($maxEndTime) ||  strtotime($maxEndTime) < strtotime($endTime) || strtotime($endTime) < strtotime($maxStartTime) || strtotime($startTime) > strtotime($endTime)){

			return json_encode(array("code" => 0, "message" => "សូមបង្កើតកិច្ចប្រជុំនៅចន្លោះម៉ោង 7:00 am ទៅ 6:00 pm។", "data" => ""));
		}else{

			$create_by_user_id = $this->userGuestSession->Id;
			$getUserAccess = DB::table('mef_using_room')->where('meeting_room_id',$data['meeting_location_id'])->count();
			if($getUserAccess >0){
				$data['status'] = 1;
			}else{
				$data['status'] = 0;
			}

			$get_role_id = DB::table('mef_user')->where('mef_officer_id',$create_by_user_id)->first();
			$data['mef_role_id'] = $get_role_id->moef_role_id;
			$date = $data['meeting_date'];
			$data['create_by_user_id'] = $create_by_user_id;
			$meeting_date = date('Y-m-d', strtotime($data['meeting_date']));
			$data['meeting_date'] = $meeting_date;
			$data['meeting_time_24'] = date('H:i', strtotime($data['meeting_time']));

			$data['meeting_end_time24'] = date('H:i', strtotime($data['meeting_end_time']));
			$data['color'] = '#4192AC';
			$data['create_date'] = date('Y-m-d H:i:s');
			$numOfDays = intval($data['num_of_day']);
			$isSunday ='';
			for($i=0 ; $i< $numOfDays; $i++){
				if($isSunday == ''){
					$data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date']. ' + '.$i.' days'));
				}else{
					$data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date']. ' + 1 days'));
				}

				$data['num_of_day'] = 1;
				$unixTimestamp = strtotime($data['meeting_date']);
				//Get the day of the week using PHP's date function.
				$dayOfWeek = date("l", $unixTimestamp);
				if($dayOfWeek =='Saturday'){
					$data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date']. ' + 2 days'));
					$meetingDate =  $this->checkDateHoliday($data['meeting_date']);
					if($data['meeting_date'] != $meetingDate ){
						$data['meeting_date'] = $meetingDate;
					}
					$isSunday = 1;
				}else{
//				$isSunday = '';
				}
				if($dayOfWeek =='Sunday'){

					$data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date']. ' + 1 days'));
					$meetingDateSun =  $this->checkDateHoliday($data['meeting_date']);
					if($data['meeting_date'] != $meetingDateSun ){
						$data['meeting_date'] = $meetingDateSun;
					}
				}
				//checking room free
				$check_room = $this->getCheckMeetingRoom($data);
				if($check_room['code'] == 1){
					return json_encode(array("code" => 0, "message" => "បន្ទប់ជាប់រវល់", "data" => ""));
				}

				//cheking leader available
				$check_leader = $this->checkLeader($data);
//				dd($check_leader['code']);
				if($check_leader['code'] == 1){
					return json_encode(array("code" => 0, "message" => trans('schedule.leader_not_available'), "data" => ""));
				}
				//checking officer avalible
				$arrOfficerId = array();
				$time24 = date('H:i:s', strtotime($data['meeting_time']));
				$endTime24 = date('H:i:s', strtotime($data['meeting_end_time24']));

				$list_atendee_join = array_map('intval', explode(",", $data["mef_meeting_atendee_join"]));
				$meetingDateLast =date('Y-m-d', strtotime($data['meeting_date']));
				foreach ($list_atendee_join as $key =>$val ) {

					$checkOfficer = DB::table('v_meeting_end_time')
						->leftjoin('mef_meeting_atendee_join', 'v_meeting_end_time.Id', '=', 'mef_meeting_atendee_join.mef_meeting_id')
						->leftjoin('mef_personal_information', 'v_meeting_end_time.create_by_user_id', '=', 'mef_personal_information.MEF_OFFICER_ID')
						->where('mef_meeting_atendee_join.mef_officer_id',$val)
						->where('v_meeting_end_time.status',0)
						->where('v_meeting_end_time.meeting_date',$meetingDateLast)
						->Where(function($query) use ($time24,$endTime24){
							$query->whereBetween('v_meeting_end_time.meeting_end_time', array($time24, $endTime24))
								->orWhere('v_meeting_end_time.meeting_time_24','>=',$time24)->where('v_meeting_end_time.meeting_end_time','<=',$time24);
						})
						->where('v_meeting_end_time.Id','<>',$data['Id'])
//						->select('mef_meeting_atendee_join.mef_officer_id','mef_personal_information.FULL_NAME_KH')
						->get();
					if(count($checkOfficer)){
						$arrOfficerId[] = $val;
						$dateNotFree = $data['meeting_date'];
					}

					$getOfficerId = DB::table('mef_personal_information')
						->whereIn('MEF_OFFICER_ID',$arrOfficerId)
						->select('FULL_NAME_KH')
						->get();

					if(count($getOfficerId)){
						$OfficerName = '';
						foreach ($getOfficerId as $item => $value) {

							$OfficerName = $value->FULL_NAME_KH.','.$OfficerName;
						}
						return json_encode(array("code" => 0, "message" => "ឈ្មោះមន្រ្តី $OfficerName ជាប់រវល់មិនអាចប្រជុំបានទេនៅថ្ងៃ $dateNotFree!", "data" => ""));
					}
				}
				//end of checking officer

				$check_mef_holiday = $this->check_mef_holiday($data);
				if($check_mef_holiday["code"] == 0){
					$data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date']. ' + 1 days'));
					$unixTimestamp = strtotime($data['meeting_date']);
					//Get the day of the week using PHP's date function.
					$dayOfWeek = date("l", $unixTimestamp);
					if($dayOfWeek =='Saturday'){
						$data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date']. ' + 2 days'));
						$meetingDate =  $this->checkDateHoliday($data['meeting_date']);
						if($data['meeting_date'] != $meetingDate ){
							$data['meeting_date'] = $meetingDate;
						}
					}
					$isSunday = 1;
				}else{
//				$isSunday = '';
				}
				/* check_meeting_atendee_join */
				$check_meeting_atendee_join = $this->check_mef_meeting_atendee_join($data);
				if($check_meeting_atendee_join["code"] == 0){
					$data_obj = $check_meeting_atendee_join["data"];
					//$data_error = "មានមន្រ្តីសុំច្បាប់ ៖ ";
					$data_error = "";
					foreach($data_obj as $key=>$val){
						$data_error = $data_error.$val->FULL_NAME_KH." បានសុំច្បាប់";
						$data_error = $data_error."<br>";
					}
					return json_encode(array("code" => 0, "message" => $data_error, "data" => ""));
				}
				/* End check_meeting_atendee_join */
				/* check_mef_mission */

				$check_mef_mission = $this->check_mef_mission($data);
				if($check_mef_mission["code"] == 0){
					$data_obj = $check_mef_mission["data"];
					$data_error = "";
					foreach($data_obj as $key=>$val){
						$data_error = $data_error.$val->FULL_NAME_KH." បានចុះបេសកកម្ម";
						$data_error = $data_error."<br>";
					}
					return json_encode(array("code" => 0, "message" => $data_error, "data" => ""));
				}

				if($data['Id'] == 0){
					$data['public'] = 1;
					$meeting = $data;
					unset($meeting['_token']);
					unset($meeting['ajaxRequestJson']);
					unset($meeting['mef_meeting_atendee_join']);
					unset($meeting['mef_office_id']);
					unset($meeting['send_email']);
					unset($meeting['guest_name']);
					unset($meeting['guest_email']);

					$getlastid = DB::table('mef_meeting')->insertGetId($meeting);

					$arr_join = array();
					$list_atendee_join = array_map('intval', explode(",", $data["mef_meeting_atendee_join"]));
					foreach ($list_atendee_join as $key => $val) {
						$arr_join[] = array(
							"mef_meeting_id" => $getlastid,
							"mef_officer_id" => $val
						);
					}

					DB::table('mef_meeting_atendee_join')->insert($arr_join);

					$guest_meeting_arr = array();
					$guest = isset($data['guest_name']) ? $data['guest_name']:'';
					if($guest !=''){
						foreach($data['guest_name'] as $key=>$val){
							if($val != ""){
								$guest_meeting_arr[] = array(
									"mef_meeting_id" => $getlastid,
									"name"	 => $val,
									"email"	 => $data['guest_email'][$key],
								);
							}
						}
					}

					if(!empty($guest_meeting_arr)){
						DB::table('mef_meeting_to_external')->insert($guest_meeting_arr);
					}

//				$num = 27;
					$arrMember = array();
					$getDataMeeting = DB::table('mef_meeting')->where('Id',$getlastid)->first();
					$getMeeting = DB::table('mef_meeting_atendee_join')->where('mef_meeting_id',$getDataMeeting->Id)->get();
					foreach ($getMeeting as $key=>$value){
						$arrMember[] = $value->mef_officer_id;
					}
//				dd($arrMember);
					//connect to web service
					$url = 'http://103.216.50.171:3200/v1/schedule/pushcreated';
					$fields =(object) [
						'meeting_id' => $getlastid,
						'create_by_user_id' => $getDataMeeting->create_by_user_id,
						'mef_meeting_leader_id' => $getDataMeeting->mef_meeting_leader_id,
						'meeting_date' => $getDataMeeting->meeting_date,
						"meeting_time"  => $getDataMeeting->meeting_time,
						'meeting_objective' => $getDataMeeting->meeting_objective,
						'meeting_location_id' => $getDataMeeting->meeting_location_id,
						'member' => $arrMember
					];
					$data_string = json_encode($fields);
//					dd($data_string);
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_VERBOSE, 0);
					curl_setopt($curl, CURLOPT_HEADER, 0);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_BINARYTRANSFER, TRUE);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array(
							'Content-Type: application/json')
//							'Content-Length: ' . strlen($data_string))
					);

					curl_setopt($curl, CURLOPT_URL, $url);

					curl_setopt($curl, CURLOPT_POST, 1);
					curl_setopt($curl, CURLOPT_POSTFIELDS,$data_string);

					$response = curl_exec($curl);

					if (curl_errno($curl)) {
						$e = new \Exception(curl_error($curl), curl_errno($curl));
						curl_close($curl);
						throw $e;
					}
					//end of connection web service

				}else{
					//update
					$meeting = $data;
					unset($meeting['_token']);
					unset($meeting['ajaxRequestJson']);
					unset($meeting['mef_meeting_atendee_join']);
					unset($meeting['mef_office_id']);
					unset($meeting['send_email']);
					unset($meeting['guest_name']);
					unset($meeting['guest_email']);

					$getlastid = DB::table('mef_meeting')->where('Id', $data['Id'])->update($meeting);
					$arr_join = array();

					DB::table('mef_meeting_atendee_join')->where('mef_meeting_id',$data['Id'])->delete();
					$list_atendee_join = array_map('intval', explode(",", $data["mef_meeting_atendee_join"]));
					foreach ($list_atendee_join as $key => $val) {
						$arr_join[] = array(
							"mef_meeting_id" => $data['Id'],
							"mef_officer_id" => $val
						);
					}

					DB::table('mef_meeting_atendee_join')->insert($arr_join);

					DB::table('mef_meeting_to_external')->where('mef_meeting_id',$data['Id'])->delete();
					$guest_meeting_arr = array();
					$guest = isset($data['guest_name']) ? $data['guest_name']:'';
					if($guest !=''){
						foreach($data['guest_name'] as $key=>$val){
							if($val != ""){
								$guest_meeting_arr[] = array(
									"mef_meeting_id" => $getlastid,
									"name"	 => $val,
									"email"	 => $data['guest_email'][$key],
								);
							}
						}
					}

					if(!empty($guest_meeting_arr)){
						DB::table('mef_meeting_to_external')->insert($guest_meeting_arr);
					}
				}

			}
			return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
		}
	}

	private function checkDateHoliday($date){
		$mef_holiday_obj = DB::table('mef_holiday')
			->select('mef_holiday.date' , 'mef_holiday.title' , 'mef_holiday.status')
			->where('mef_holiday.date', '=', $date)
			->where('mef_holiday.status', 1)
			->get();
		if(count($mef_holiday_obj) > 0){
			$lastDate = date('Y-m-d', strtotime($date. ' + 1 days'));
			return $this->checkDateHoliday($lastDate);
		}else{
			return $date;
		}
	}

	private function checkLeader($data){
		$meetingDatelast =date('Y-m-d', strtotime($data['meeting_date']));
		$time24 = date('H:i:s', strtotime($data['meeting_time']));
		$endTime24 = date('H:i:s', strtotime($data['meeting_end_time24']));
		$checkLeaderFree = DB::table('v_meeting_end_time')
			->where('mef_meeting_leader_id',$data['mef_meeting_leader_id'])
			->where('meeting_date',$meetingDatelast)
			->Where(function($query) use ($time24,$endTime24){
				$query->whereBetween('meeting_end_time', array($time24, $endTime24))
					->orWhere('meeting_time','>=',$time24)->where('meeting_end_time','<=',$time24);
			})
			->where('Id','<>',$data['Id'])
			->count();

		$checkLeaderFromMember = DB::table('mef_meeting_atendee_join')
			->leftjoin('v_meeting_end_time', 'mef_meeting_atendee_join.mef_meeting_id', '=', 'v_meeting_end_time.Id')
			->where('mef_meeting_atendee_join.mef_officer_id',$data['mef_meeting_leader_id'])
			->where('v_meeting_end_time.status',0)
			->where('v_meeting_end_time.meeting_date',$data['meeting_date'])
			->Where(function($query) use ($time24,$endTime24){
				$query->whereBetween('v_meeting_end_time.meeting_end_time', array($time24, $endTime24))
					->orWhere('v_meeting_end_time.meeting_time','>=',$time24)->where('v_meeting_end_time.meeting_end_time','<=',$time24);
			})
			->where('v_meeting_end_time.Id','<>',$data['Id'])
			->select('mef_meeting_atendee_join.mef_meeting_id','mef_meeting_atendee_join.mef_officer_id')
			->get();
//		dd($checkLeaderFromMember);
		if($checkLeaderFree || count($checkLeaderFromMember)){
			return array("code" => 1, "message" => trans('schedule.leader_not_available'), "data" => "");
		}else{
			return array("code" => 2, "message" => "ok", "data" => "");
		}
	}

	private function check_mef_holiday($data){
		$meeting_date = $data["meeting_date"];
		$meeting_date = str_replace('/', '-', $meeting_date);
		$meeting_date = date('Y-m-d', strtotime($meeting_date));
		$mef_holiday_obj = DB::table('mef_holiday')
			->select('mef_holiday.date' , 'mef_holiday.title' , 'mef_holiday.status')
			->where('mef_holiday.date', '=', $meeting_date)
			->where('mef_holiday.status', 1)
			->get();
		if(count($mef_holiday_obj) > 0){
			return array("code" => 0, "message" => "error", "data" => $mef_holiday_obj);
		}
		return array("code" => 1, "message" => "success", "data" => "");
	}

	private function check_mef_mission($data){
		$meeting_date = $data["meeting_date"];
		$meeting_date = str_replace('/', '-', $meeting_date);
		$meeting_date = date('Y-m-d', strtotime($meeting_date));
		$list_atendee_join = array_map('intval', explode(",", $data["mef_meeting_atendee_join"]));
		$mef_meeting_atendee_join_arr = $list_atendee_join;
		$mef_mission_obj = DB::table('mef_mission')
			->join('mef_mission_to_officer', 'mef_mission.id', '=', 'mef_mission_to_officer.mef_mission_id')
			->join('mef_personal_information', 'mef_mission_to_officer.mef_officer_id', '=', 'mef_personal_information.MEF_OFFICER_ID')
			->select('mef_mission.mission_from_date',
				'mef_mission.mission_to_date',
				'mef_personal_information.FULL_NAME_KH')
			->whereIn('mef_mission_to_officer.mef_officer_id' , $mef_meeting_atendee_join_arr)
			->where('mission_from_date', '<=', $meeting_date)
			->where('mission_to_date', '>=', $meeting_date)
			->groupBy('mef_mission_to_officer.mef_officer_id')
			->get();
		if(count($mef_mission_obj) > 0){
			return array("code" => 0, "message" => "error", "data" => $mef_mission_obj);
		}
		return array("code" => 1, "message" => "success", "data" => "");
	}

	private function check_mef_meeting_atendee_join($data){
		$meeting_date = $data["meeting_date"];
		$meeting_date = str_replace('/', '-', $meeting_date);
		$meeting_date = date('Y-m-d', strtotime($meeting_date));
		$list_atendee_join = array_map('intval', explode(",", $data["mef_meeting_atendee_join"]));
		$list_atendee_join = $list_atendee_join;
		$mef_take_leave_obj = DB::table('mef_take_leave_status')
			->join('mef_personal_information', 'mef_personal_information.MEF_OFFICER_ID', '=', 'mef_take_leave_status.officer_id')
			->select('mef_take_leave_status.*', 'mef_personal_information.FULL_NAME_KH')
			->whereIn('mef_take_leave_status.officer_id',$list_atendee_join)
			->where('mef_take_leave_status.take_date','=',$meeting_date)
			->where('mef_take_leave_status.status',1)
			->groupBy('officer_id')
			->get();
		if(count($mef_take_leave_obj) > 0){
			return array("code" => 0, "message" => "error", "data" => $mef_take_leave_obj);
		}
		return array("code" => 1, "message" => "success", "data" => "");
	}

	public function getListLocation(){
		$arrList = DB::table('mef_meeting_room')
			->orderBy('Name', 'ASC')
			->get();
		$arr = array(array("text"=>"", "value" => ""));
		foreach($arrList as $row){
			$arr[] = array(
				'text' 	=>$row->name,
				"value" =>$row->id
			);
		}
		return $arr;
	}

	public function getMefOfficerForJoinByOfficeId($office_id,$leaderId){
		$department_id = $this->userGuestSession->department;
		$arrList = DB::table('v_mef_officer')
			->where('department_id',$department_id)
			->whereIn('is_approve',[2,3])
			->Where('Id','<>',$leaderId)
			->where('approve',null)
			->where('active',1);
		if($office_id != 0 && $office_id != null){
			$arrList = $arrList->WhereIn('office_id',$office_id);
		}
		$arrList = $arrList->orderBy('position_order', 'DESC')->get();
		$arr = array();
		foreach($arrList as $row){
			$arr[] = array(
				'displayMember' =>$row->full_name_kh,
				'valueMember' =>$row->Id
			);
		}
		return json_encode($arr,JSON_UNESCAPED_UNICODE);
	}

	public function getMeetingAtendeeJoinString($mef_meeting_id){
		$string = '';
		$obj = DB::table('mef_meeting_atendee_join')
			->where('mef_meeting_id', $mef_meeting_id)
			->orderBy('Id', 'ASC')
			->get();
		foreach($obj as $key=>$val){
			if(count($obj) >  $key + 1){
				$string = $string . $val->mef_officer_id . ',';
			}else{
				$string = $string . $val->mef_officer_id;
			}
		}
		return $string;
	}

	public function getSecretariatListByMinistryId($ministryId){
		$rows = DB::table('mef_secretariat')->where('mef_ministry_id', $ministryId)->get();
		$array = array();
		$array[] = array("text" => "","value" => 0);
		foreach($rows as $row){
			if($row->Abbr != ''){
				$str = ' -'.$row->Abbr;
			}else{
				$str = '';
			}
			$array[] = array(
				"text" => $row->Name.$str,
				"value" => $row->Id
			);
		}
		return $array;
	}
}
?>