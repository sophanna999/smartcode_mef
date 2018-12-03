<?php

namespace App\Models\BackEnd\Schedule;
use Illuminate\Support\Facades\DB;
use Config;
use Excel;
use Illuminate\Support\Facades\Mail;
use App\libraries\Tool;
class MeetingModel
{

    public function __construct()
    {
		$this->messages = Config::get('constant');
		$this->userSession = session('sessionUser');
	    $this->userGuestSession = session('sessionGuestUser');
        $this->Tool = new Tool();
    }

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "meeting_date";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        
	    $groupId = explode(",",$this->userSession->moef_role_id);
	    $departmentId = $this->userSession->mef_department_id;

		$listDb = DB::table('mef_meeting AS meeting')
					->leftJoin('v_mef_officer', 'meeting.mef_meeting_leader_id', '=', 'v_mef_officer.Id')
					->leftJoin('mef_user', 'meeting.create_by_user_id', '=', 'mef_user.id')
					->leftJoin('mef_service_status_information as ser', 'meeting.create_by_user_id', '=', 'ser.MEF_OFFICER_ID')
					->leftJoin('mef_meeting_room As mr', 'meeting.meeting_location_id', '=', 'mr.id')
					->select(
						'meeting.Id',
						'meeting.create_by_user_id',
						'meeting.mef_meeting_type_id',
						'meeting.mef_meeting_leader_id',
						DB::raw('(CASE WHEN meeting.mef_meeting_leader_id = 0 THEN meeting.mef_leader_outside ELSE v_mef_officer.full_name_kh END) AS meeting_leader_name'),
						DB::raw('get_date_khmer(meeting.meeting_date) as meeting_date'),
						'meeting.meeting_time',
						'meeting.meeting_time_24',
						'meeting.meeting_objective',
						'mr.name AS meeting_location',
						'meeting.all',
						'meeting.public',
						'mef_user.user_name AS create_by_user',
						'ser.CURRENT_DEPARTMENT'
					)
                    ->whereIn('meeting.mef_role_id',$groupId)
					->where('meeting.status',0)
					// ->orWhere('ser.CURRENT_DEPARTMENT',$departmentId)
					->orderBy('meeting.meeting_date','DESC');

		$total = count($listDb->get());

		if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';

                switch($arrFilterName){
					case 'meeting_location':
                        $listDb = $listDb->where('meeting.meeting_location','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'meeting_objective':
                        $listDb = $listDb->where('meeting.meeting_objective','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'guest_description':
                        $listDb = $listDb->where('meeting.guest_description','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'meeting_leader_name' :
						$listDb = $listDb->where('v_mef_officer.full_name_kh','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'meeting_date' :
						$arrFilterValue = \DateTime::createFromFormat('d/m/Y', $arrFilterValue)->format('Y-m-d');
						$listDb = $listDb->where('meeting.meeting_date','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'meeting_time' :	
						$listDb = $listDb->where('meeting.meeting_time','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'create_by_user' :	
						$listDb = $listDb->where('mef_user.user_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'public' :
                        $arrFilterValue = $arrFilterValue == 'Public' ? 1:0;
                        $listDb = $listDb->where('meeting.public',$arrFilterValue);
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }

		$listDb = $listDb
				->orderBy($sort, $order)
				->take($limit)
				->skip($offset);	
        $listDb = $listDb->get();
        return json_encode(array('total'=>$total,'data'=>$listDb));
    }

    
    public function postSave($data){

	    $numOfDays = intval($data['num_of_day']);
	    $mef_meeting_atendee_join = $data['mef_meeting_atendee_join'];
	    $send_email = $data['send_email'];
	    $isSunday ='';
	    for($i= 0 ; $i <$numOfDays ; $i++){

		    $data['mef_meeting_atendee_join'] = $mef_meeting_atendee_join;
		    $data['send_email'] = $send_email;

		    $date = str_replace('/', '-', $data['meeting_date']);
		    $meeting_date = date('Y-m-d', strtotime($date));
//		    var_dump($isSunday);
		    if($isSunday ==''){
			    $data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date']. ' + '.$i.' days'));

		    }else{
			    $data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date']. ' + 1 days'));
		    }
		    //check status
		    $getUserAccess = DB::table('mef_using_room')->where('meeting_room_id',$data['meeting_location_id'])->count();
		    if($getUserAccess >0){
			    $data['status'] = 1;
		    }else{
			    $data['status'] = 0;
		    }

		    $time24 = date('H:i:s', strtotime($data['meeting_time']));
		    $endTime24 = date('H:i:s', strtotime($data['meeting_end_time']));
		    if($data['status'] == 1){
			    $getTime = DB::table('v_meeting_end_time')
				    ->where('meeting_location_id',$data['meeting_location_id'])
				    ->where('meeting_date', $data['meeting_date'])
				    ->Where(function($query) use ($time24,$endTime24){
					    $query->whereBetween('meeting_end_time', array($time24, $endTime24))
						    ->orWhere('meeting_time','>=',$time24)->where('meeting_end_time','<=',$time24);
				    })
				    ->where('Id','<>',$data['Id'])
				    ->get();

			    if(!empty($getTime)){
				    return json_encode(array("code" => 0, "message" => "បន្ទប់ជាប់រវល់", "data" => ""));
			    }
		    }

		    $check_mef_holiday = $this->check_mef_holiday($data);

		    if($check_mef_holiday["code"] == 0){

			    $data_obj = $check_mef_holiday["data"];
			    $data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date']. ' + 1 days'));
			    $meetingDate = $data['meeting_date'];
			    $unixTimestamp = strtotime($data['meeting_date']);
			    //Get the day of the week using PHP's date function.
			    $dayOfWeek = date("l", $unixTimestamp);
			    if($dayOfWeek =='Saturday'){
				    $data['meeting_date'] = date('Y-m-d', strtotime($meetingDate. ' + 2 days'));
				    $meetingDate = $data['meeting_date'];
				    $meetingDate =  $this->checkDateHoliday($data['meeting_date']);
				    if($data['meeting_date'] != $meetingDate ){
					    $data['meeting_date'] = $meetingDate;
					    $meetingDate = $data['meeting_date'];
				    }
			    }
			    $isSunday = 1;
			    $meetingDate = $data['meeting_date'];
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
		    /* End check_mef_mission */
		    $meeting_id = $data['Id'];
		    $send_email = $data['send_email'];
		    $create_by_user_id = $this->userSession->id;
		    unset($data['_token']);
		    unset($data['ajaxRequestJson']);
		    unset($data['send_email']);
		    $date = $data['meeting_date'];
		    $data['create_by_user_id'] = $create_by_user_id;

		    $date = str_replace('/', '-', $date);
		    $meeting_date = date('Y-m-d', strtotime($date));
//		    $data['meeting_date'] = date('Y-m-d', strtotime($meeting_date. ' + '.$i.' days'));
		    $data['meeting_time_24'] = date('H:i',strtotime($data['meeting_time']));
		    $data['meeting_end_time24'] = date('H:i',strtotime($data['meeting_end_time']));
		    $data['color'] = '#4192AC';
		    $data['mef_role_id'] = $this->userSession->moef_role_id;
		    $data['create_date'] = date('Y-m-d H:i:s');
		    $data['is_invite_guest'] = isset($data['is_invite_guest']) ? intval($data['is_invite_guest']) : 0;
		    $data['num_of_day'] = 1;

		    //Convert the date string into a unix timestamp.
		    $unixTimestamp = strtotime($data['meeting_date']);
		    //Get the day of the week using PHP's date function.
		    $dayOfWeek = date("l", $unixTimestamp);

		    if($dayOfWeek =='Saturday'){
			    $addDate = date('Y-m-d', strtotime($data['meeting_date'] . ' + 2 days'));
			    $data['meeting_date'] = $addDate;
			    $meetingDate = $data['meeting_date'];
			    $meetingDate =  $this->checkDateHoliday($data['meeting_date']);
			    if($data['meeting_date'] != $meetingDate ){
				    $data['meeting_date'] = $meetingDate;
				    $meetingDate = $data['meeting_date'];
			    }
			    $isSunday = 1;
		    }
		    if($dayOfWeek =='Sunday'){
			    $data['meeting_date'] = date('Y-m-d', strtotime($data['meeting_date'] . ' + 2 days'));
		    }

		    $list_atendee_join = array_map('intval', explode(",", $data["mef_meeting_atendee_join"]));
		    $arrOfficerId = array();
		    foreach ($list_atendee_join as $key =>$val ) {
			    $checkOffice = DB::table('v_meeting_end_time')
				    ->leftjoin('mef_meeting_atendee_join', 'v_meeting_end_time.Id', '=', 'mef_meeting_atendee_join.mef_meeting_id')
				    ->leftjoin('mef_personal_information', 'v_meeting_end_time.create_by_user_id', '=', 'mef_personal_information.MEF_OFFICER_ID')
				    ->where('mef_meeting_atendee_join.mef_officer_id',$val)
				    ->where('v_meeting_end_time.status',0)
				    ->where('v_meeting_end_time.meeting_date',$data['meeting_date'])
				    ->where('v_meeting_end_time.meeting_time_24','<', $data['meeting_time_24'] )
				    ->where('v_meeting_end_time.meeting_end_time','>',$data['meeting_time_24'])
				    ->where('v_meeting_end_time.Id','<>',$data['Id'])
				    ->select('mef_meeting_atendee_join.mef_officer_id','mef_personal_information.FULL_NAME_KH')
				    ->get();
			    if(count($checkOffice)){
				    $arrOfficerId[] = $val;
				    $dateNotFree = $data['meeting_date'];
			    }
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

		    $mef_meeting_atendee_join = $data['mef_meeting_atendee_join'];
		    unset($data['mef_meeting_atendee_join']);
		    $join_all = isset($data['join_all']) ? intval($data['join_all']) : 0;
		    unset($data['join_all']);
		    $guest_name_arr = isset($data['guest_name']) ? $data['guest_name'] : array();
		    unset($data['guest_name']);
		    $guest_email_arr = isset($data['guest_email']) ? $data['guest_email'] : array();
		    unset($data['guest_email']);

		    $attachment_name_arr = isset($data['attachment_name']) ? $data['attachment_name'] : array();
		    unset($data['attachment_name']);
		    $attachment_link_arr = isset($data['attachment_link']) ? $data['attachment_link'] : array();
		    unset($data['attachment_link']);

		    $data['all'] = 0;

		    if($mef_meeting_atendee_join == ''){
			    $data['all'] = 0;
		    }

		    if($data['Id'] == 0){
//			    unset($data['Id']);
			    unset($data['mef_office_id']);
			    /* Save data */
			    $id = DB::table('mef_meeting')->insertGetId($data);
			    $arrMember = array();
			    $getDataMeeting = DB::table('mef_meeting')->where('Id',$id)->first();
			    $getMeeting = DB::table('mef_meeting_atendee_join')->where('mef_meeting_id',$getDataMeeting->Id)->get();
			    foreach ($getMeeting as $key=>$value){
				    $arrMember[] = $value->mef_officer_id;
			    }
//				dd($arrMember);
//post notification
			    $url = 'http://103.216.50.171:3200/v1/schedule/pushcreated';
			    $fields =(object) [
				    'meeting_id' => $id,
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
			    /* End Save data */
		    }else{
			    $id = $data['Id'];
			    unset($data['Id']);
			    unset($data['create_by_user_id']);
			    unset($data['mef_office_id']);
			    DB::table('mef_meeting')
				    ->where('Id', $id)
				    ->update($data);
		    }
		    // insert_mef_meeting_to_external
		    $this->insert_mef_meeting_to_external($id,$guest_name_arr,$guest_email_arr,$data['is_invite_guest']);
		    // insert_mef_meeting_to_file
		    $this->insert_mef_meeting_to_file($id,$attachment_name_arr,$attachment_link_arr);

		    if($data['all'] == 0){
			    $mef_meeting_atendee_join_arr = explode(",", $mef_meeting_atendee_join);
			    $arr_join = array();
			    foreach($mef_meeting_atendee_join_arr as $key=>$val){
				    $arr_join[] = array(
					    "mef_meeting_id" => $id,
					    "mef_officer_id" => $val
				    );
			    }
			    $this->insertMefMeetingAtendeeJoin($id,$arr_join);
			    if($send_email == "true"){
				    $this->sendEmailMeeting($mef_meeting_atendee_join_arr,$data,$id);
			    }
		    }else{
			    DB::table('mef_meeting_atendee_join')->where('mef_meeting_id',$id)->delete();
		    }
	    }

	    return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));


    }
	private function insert_mef_meeting_to_external($id,$guest_name_arr,$guest_email_arr,$is_invite_guest){

		DB::table('mef_meeting_to_external')->where('mef_meeting_id',$id)->delete();
		$guest_meeting_arr = array();
		foreach($guest_name_arr as $key=>$val){
			if($val != ""){
				$guest_meeting_arr[] = array(
					"mef_meeting_id" => $id,
					"name"	 => $val,
					"email"	 => $guest_email_arr[$key],
				);
			}
		}

		if(!empty($guest_meeting_arr)){
			DB::table('mef_meeting_to_external')->insert($guest_meeting_arr);
			return 1;
		}
		return 0;
	}
	private function insert_mef_meeting_to_file($id,$attachment_name_arr,$attachment_link_arr){
		DB::table('mef_meeting_to_file')->where('mef_meeting_id',$id)->delete();
		$meeting_to_file_arr = array();
		foreach($attachment_name_arr as $key=>$val){
			if($val != "" && $attachment_link_arr[$key] != ""){
				$meeting_to_file_arr[] = array(
					"mef_meeting_id" => $id,
					"name"	 => $val,
					"mef_file_path"	 => $attachment_link_arr[$key],
				);
			}
		}
		if(!empty($meeting_to_file_arr)){
			DB::table('mef_meeting_to_file')->insert($meeting_to_file_arr);
			return 1;
		}
		return 0;
	}
	private function check_mef_meeting_atendee_join($data){
		$meeting_date = $data["meeting_date"];
		$meeting_date = str_replace('/', '-', $meeting_date);
		$meeting_date = date('Y-m-d', strtotime($meeting_date));
		$meeting_atendee_join = $data["mef_meeting_atendee_join"];
		$list_atendee_join = array_map('intval', explode(",", $meeting_atendee_join));
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
		$mef_meeting_atendee_join_arr = array_map('intval',explode(",", $data['mef_meeting_atendee_join']));
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
	
    public function postDelete($listId){
        foreach ($listId as $id){
	        $arrMember = array();
	        $getDataMeeting = DB::table('mef_meeting')->where('Id',$id)->first();
	        $getMeeting = DB::table('mef_meeting_atendee_join')->where('mef_meeting_id',$getDataMeeting->Id)->get();
	        foreach ($getMeeting as $key=>$value){
		        $arrMember[] = $value->mef_officer_id;
	        }
//				dd($arrMember);
	        $url = 'http://103.216.50.171:3200/v1/schedule/pushdeleted';
//	        dd(curl_errno($url));
	        $fields =(object) [
		        'meeting_id' => $id,
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

			DB::table('mef_meeting_atendee_join')->where('mef_meeting_id',$id)->delete();
			DB::table('mef_meeting_to_external')->where('mef_meeting_id',$id)->delete();
			DB::table('mef_meeting_to_file')->where('mef_meeting_id',$id)->delete();
            DB::table('mef_meeting')->where('Id',$id)->delete();

	        $array = array(
		        "meeting_id" 	=> $id,
		        "meeting_date"  => date('Y-m-d H:i:s'),
	        );

	        $meeting_event_deleted = DB::table('mef_meeting_event_deleted')->insert($array);
        }

        return array("code" => 3,"message" => trans('trans.success'));
    }

	public function getListMeetingType(){
		$arrRoleId = explode(',',$this->userSession->moef_role_id);
        $arrList = DB::table('mef_meeting_type')
                    ->whereIn('mef_role_id',$arrRoleId)
                    ->orderBy('order_number', 'ASC')
                    ->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->Name,
                "value" => $row->Id
            );
        }
        return $arr;
    }
	public function getListMeetingLeader(){

		$arrList = DB::table('v_mef_officer')
			->whereIn('is_approve',[2,3])
			->where('approve',null)
			->where('active',1)
			->orderBy('position_order', 'DESC')->get();
        $arr = array(array("text"=>'', "value" => ""),array("text"=>trans('trans.none'), "value" => 0));
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
	public function getMefOfficerForJoin($office_id){
		$department_id = $this->userSession->mef_department_id;
        $arrList = DB::table('v_mef_officer')->where('department_id',$department_id);
		if($office_id != 0 && $office_id != null){
			$arrList = $arrList->where('office_id',$office_id);
		}
		$arrList = $arrList->orderBy('position_order', 'ASC')->get();
        $arr = array();
        foreach($arrList as $row){
            $arr[] = array(
                'displayMember' =>$row->full_name_kh,
                'valueMember' =>$row->Id
            );
        }
        return $arr;
    }
	function insertMefMeetingAtendeeJoin($mef_meeting_id,$data){
		DB::table('mef_meeting_atendee_join')->where('mef_meeting_id',$mef_meeting_id)->delete();
		DB::table('mef_meeting_atendee_join')->insert($data);
	}
    public function getDataByRowId($id){
        return DB::table('mef_meeting')->where('Id', $id)->first();
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

	public function getOfficeIdOfOfficer($mef_meeting_id){
		$string = '';
		$obj = DB::table('mef_meeting_atendee_join as mat')
			->join('mef_service_status_information as ser', 'mat.mef_officer_id', '=', 'ser.MEF_OFFICER_ID')
			->where('mef_meeting_id', $mef_meeting_id)
			->select('ser.CURRENT_OFFICE AS officeId')
			->get();

		return $obj;
	}
	public function getMefGuestMeeting($mef_meeting_id){
		$obj = DB::table('mef_meeting_to_external')
                ->where('mef_meeting_id', $mef_meeting_id)
                ->orderBy('Id', 'ASC')
                ->get();
		return $obj;
	}
	public function getMefMeetingToFile($mef_meeting_id){
		$obj = DB::table('mef_meeting_to_file')
                ->where('mef_meeting_id', $mef_meeting_id)
                ->orderBy('Id', 'ASC')
                ->get();
		return $obj;
	}
	
	public function getListOfficeByDepartmentId(){
		$department_id = $this->userSession->mef_department_id;
		$arrList = DB::table('mef_office')
                    ->where('mef_department_id',$department_id)
                    ->orderBy('Name', 'ASC')
                    ->get();
        $arr = array(array("text"=>"", "value" => "0"));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
	}

	public function getMefMeetingLocation(){
		$role_id = explode(',',$this->userSession->moef_role_id);
		$getOfficerId = DB::table('mef_user')->where('id',$this->userSession->id)->first();
		$getRoomId = DB::table('mef_using_room')->where('mef_officer_id',$getOfficerId->mef_officer_id)->get();
		foreach ($getRoomId as $key=>$val){
			$role_id[] =$val->meeting_room_id;
		}

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
	public function getHoliday(){
		$arrList = DB::table('mef_holiday');
		$arrList = $arrList->select('date')->get();
		return $arrList;
	}
	
	public function getMefOfficerForJoinByOfficeId($office_id,$leaderId){
//		dd($this->userSession);
		$department_id = $this->userSession->mef_department_id;
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
//		dd($arrList);
        return json_encode($arr,JSON_UNESCAPED_UNICODE);
	}

	public function getListAttendee($meeting_id){
		$meeting_first = DB::table('mef_meeting')->where('Id',$meeting_id)->first();
		if($meeting_first == null){
			echo "Data have problem";
			exit();
		}
		if($meeting_first->all == 1){
			/*
			$department_id = $this->userSession->mef_department_id;
			$arrList = DB::table('v_mef_officer')->where('department_id',$department_id);
			$arrList = $arrList->OrderBy('Id', 'DESC')->get();
			*/
			$arrList = 'all';
		}else{
			$arrList = DB::table('mef_meeting_atendee_join')
						->join('v_mef_officer', 'mef_meeting_atendee_join.mef_officer_id', '=', 'v_mef_officer.Id')
						->select('mef_meeting_atendee_join.*', 'v_mef_officer.*')
						->where('mef_meeting_atendee_join.mef_meeting_id',$meeting_id);
			$arrList = $arrList->OrderBy('v_mef_officer.position_order', 'ASC')->get();
		}
		return $arrList;
	}
    public function getExternalMeetingById($meeting_id){
        $query = DB::table('mef_meeting_to_external')
            ->where('mef_meeting_id',$meeting_id)
            ->get();
        return $query;
    }
	
	public function getListAttendeeNameOnly($meeting_id){
		$arrList = DB::table('mef_meeting_atendee_join')
						->join('v_mef_officer', 'mef_meeting_atendee_join.mef_officer_id', '=', 'v_mef_officer.Id')
						->select('mef_meeting_atendee_join.*', 'v_mef_officer.*')
						->where('mef_meeting_atendee_join.mef_meeting_id',$meeting_id);
		$arrList = $arrList->OrderBy('mef_meeting_atendee_join.Id', 'DESC')->get();
		$listName = "";
		foreach($arrList as $key=>$val){
			if(count($arrList) > ($key + 1) ){
				$listName = $listName.$val->full_name_kh.", ";
			}else{
				$listName = $listName.$val->full_name_kh;
			}
		}
		return $listName;
	}
	
	public function checkDataExport($request_all){
		$request_all["start_date"] = str_replace('/', '-', $request_all["start_date"]);
		$request_all["start_date"] = date('Y-m-d', strtotime($request_all["start_date"]));
		$request_all["end_date"] = str_replace('/', '-', $request_all["end_date"]);
		$request_all["end_date"] = date('Y-m-d', strtotime($request_all["end_date"]));
		$data 	= $this->exportMeetingData($request_all);
		$countData = count($data);
		if($countData > 0){
			return array("code"=>1,"message"=>trans('schedule.please_wait'));
		}else{
			return array("code"=>0,"message"=>trans('schedule.no_data'));
		}
	}
	
	public function export($request_all){
		$request_all["start_date"] = str_replace('/', '-', $request_all["start_date"]);
		$request_all["start_date"] = date('Y-m-d', strtotime($request_all["start_date"]));
		$request_all["end_date"] = str_replace('/', '-', $request_all["end_date"]);
		$request_all["end_date"] = date('Y-m-d', strtotime($request_all["end_date"]));
		$data 	= $this->exportMeetingData($request_all);
		$title_report = 'របាយការណ៏កិច្ចប្រជុំប្រចាំ ថ្ងៃទី  '.$this->Tool->khmerDate($request_all['start_date']).' ដល់ ថ្ងៃទី '.$this->Tool->khmerDate($request_all['end_date']);
		$title_department = 'អង្គភាព ៖ '.$this->getDepartmentById()->department_name;
		$officer_name = $request_all["officer_name"];
		if($officer_name != ''){
			$officer_name = "ឈ្មោះ ៖ ".$officer_name;
		}
		Excel::create('export_schedule', function($excel) use ($data,$title_report,$title_department,$officer_name) {	
			$excel->sheet('excel', function($sheet) use ($data,$title_report,$title_department,$officer_name) {
				$data_cell=array();
				foreach ($data as $key => $values) {
					$data_cell[$key]["កាលបរិច្ឆេទជួបប្រជុំ"] = $values->meeting_date;
					$data_cell[$key]["ម៉ោងជួបប្រជុំ"] = $values->meeting_time;
					$data_cell[$key]["អ្នកដឹងនាំប្រជុំ"] = $values->meeting_leader_name;
					$data_cell[$key]["គោលបំណងជួបប្រជុំ"] = $values->meeting_objective;
					$data_cell[$key]["ទីតាំងជួបប្រជុំ"] = $values->meeting_location;
					$data_cell[$key]["អ្នកចូលរួម"] = $values->all == 1 ? "អ្នកចូលរួមទាំងអស់" : $this->getListAttendeeNameOnly($values->Id);
				}
				$sheet->fromArray($data_cell);
				$sheet->setFontFamily('Khmer MEF1');
				$countDataPlush1 = count($data) + 1;
				$sheet->row(1, function($row) {
					$row->setBackground('#DFF0D8');
				});
				$sheet->setBorder('A1:F'.$countDataPlush1, 'thin');
				
				// Add officer_name
				/*
				if($officer_name != ''){
					$sheet->prependRow(1, array(
						$officer_name
					));
				}
				*/
				// Add title_department
				$sheet->prependRow(1, array(
					$title_department
				));
				// add title_report
				$sheet->prependRow(1, array(
					$title_report
				));
				$sheet->mergeCells('A1:F1','center');
				$sheet->setHeight(1, 30); 
				$sheet->mergeCells('A2:F2','center');
				$sheet->setHeight(2, 30);
				/*
				if($officer_name != ''){
					$sheet->mergeCells('A3:F3','center');
					$sheet->setHeight(3, 30);
				}
				*/
				$sheet->cell('A1:F1', function($cell) {
					$cell->setFontFamily('Khmer MEF2');
					$cell->setValignment('center');
				});
				$sheet->cell('A2:F2', function($cell) {
					$cell->setFontFamily('Khmer MEF2');
					$cell->setValignment('center');
				});
				/*
				if($officer_name != ''){
					$sheet->cell('A3:F3', function($cell) {
						$cell->setFontFamily('Khmer MEF2');
						$cell->setValignment('center');
					});
				}
				*/
				$sheet->setBorder('A1:F'.(2), 'thin');
			});
			$excel->getActiveSheet()->getStyle('A1:F'.$excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		})->export('xls');
	}
	
	function exportMeetingData($request_all){
		$start_date = $request_all["start_date"];
		$end_date 	= $request_all["end_date"];
		$officer_id = $request_all["officer_id"];
		$listDb 	= DB::table('mef_meeting AS meeting');
		$listDb 	= $listDb->join('mef_meeting_leader', 'meeting.mef_meeting_leader_id', '=', 'mef_meeting_leader.Id');
		if($officer_id != 0){
			$listDb = $listDb->join('mef_meeting_atendee_join', 'meeting.Id', '=', 'mef_meeting_atendee_join.mef_meeting_id');
			$listDb = $listDb->join('mef_officer', 'mef_officer.Id', '=', 'mef_meeting_atendee_join.mef_officer_id');
			$listDb = $listDb->where('mef_officer.Id', $officer_id);
		}
		$listDb 	= $listDb->select('meeting.*', 'mef_meeting_leader.Name as meeting_leader_name');
		if($this->userSession->moef_role_id != 1){
			$listDb = $listDb->where('meeting.mef_role_id',$this->userSession->moef_role_id);
		}
		$listDb = $listDb->where('meeting.meeting_date','>=', date('Y-m-d', strtotime($start_date)));
		$listDb = $listDb->where('meeting.meeting_date','<=', date('Y-m-d', strtotime($end_date)));
		$listDb = $listDb->get();
		$data 	= $listDb;
		return $data;
	}
	
	private function sendEmailMeeting($mef_meeting_atendee_join_arr,$data,$mef_meeting_id){

		$meeting_leader_id = $data["mef_meeting_leader_id"];
		$meeting_leader = DB::table('mef_meeting_leader')
							->where('Id',$meeting_leader_id)->get();
		$officer = DB::table('mef_officer')
            ->join('mef_personal_information', 'mef_officer.id', '=', 'mef_personal_information.MEF_OFFICER_ID')
            ->select('mef_personal_information.EMAIL')
			->whereIn('mef_officer.Id',$mef_meeting_atendee_join_arr)
            ->get();
		$mef_meeting_to_external = DB::table('mef_meeting_to_external')
						->where('mef_meeting_id',$mef_meeting_id)->get();
		$mail_arr = array();
		foreach($meeting_leader as $key=>$val){
			$mail_arr[] = $val->email;
		}
		foreach($officer as $key=>$val){
			$mail_arr[] = $val->EMAIL;
		}
		foreach($mef_meeting_to_external as $key=>$val){
			$mail_arr[] = $val->email;
		}
		$mef_meeting_leader_id = $data["mef_meeting_leader_id"];
		$mef_meeting_leader = DB::table('mef_meeting_leader')
            ->select('mef_meeting_leader.Name')
			->where('mef_meeting_leader.Id',$mef_meeting_leader_id)
            ->first();
		$data["mef_meeting_leader_name"] =  $mef_meeting_leader->Name;	
		$data_send = array(
			"list_email" => $mail_arr,
			"data"		 => $data
		);
		if(!empty($mail_arr)){
			Mail::send('email.email_meeting', $data_send, function ($m) use ($data_send) {
				$m->from('smartoffice@mef.gov.kh', 'Smart Office Team');
				$m->to($data_send["list_email"])->subject('សូមអញ្ជើញចូលរួមកិច្ចប្រជុំ');
			});
		}
	}
	
	public function getDepartmentById(){
        $department_id = $this->userSession->mef_department_id != 0 ? $this->userSession->mef_department_id:5;
        $affected_row = DB::table('mef_department AS d')
                ->select('d.Name AS department_name')
                ->where('d.Id',$department_id)
                ->first();
        return $affected_row;
    }

}
?>