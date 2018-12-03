<?php
namespace App\Http\Controllers\FrontEnd\Attendance;
use App\libraries\Tool;
use DB;
use Input;
use Mail;
use Excel;
use PDF;
use Config;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\BackEnd\Attendance\AttendanceModel;
class AttendanceController extends FrontendController
{
	public $user;
	public $email_id;

	public function __construct(){
        parent::__construct();
        $this->attendance = new AttendanceModel();
        $this->user = session('sessionGuestUser');
		$this->constant = Config::get('constant');
		$this->Tool = new Tool();
		if(!isset($this->user->mef_dep))
			return array();
    }
	public function getListScanHistory()
	{
		return view($this->viewFolder.'.Attendance.scan-history');
	}
	public function postListScanHistory(Request $request)
	{
		if(isset($request->start_dt)){
			$start_dt = date("Y-m-d", strtotime($request->start_dt));
		}
		if(isset($request->start_dt)){
			$end_dt = date("Y-m-d", strtotime($request->end_dt));
		}
		$param = array(
			'mef_user_id' =>$this->user->Id
			,'date' =>[$start_dt,$end_dt]
		);
		$data = $this->attendance->listScanHistory($param);
		
		return json_encode(array('code'=>1,'message'=>'ការផ្ទេរសិទ្ធជោគជ័យ', "data" => $data));
	}
	public function getIndex(){
		$this->data['start_dt']= date("Y-m-d");
        $this->data['end_dt']= date("Y-m-d");
		$this->data['holi'] = DB::table('mef_holiday')
				->where('status',1)->get();
		$this->data['holiday_date'] = '';
		foreach($this->data['holi'] as $key =>$value){
			if($value->date !='') {
				// array_push($this->data['holiday_date'],strtotime($value->date));
				if($this->data['holiday_date'] ==''){
					$this->data['holiday_date'] .= strtotime($value->date)* 1000;
				}else{
					$this->data['holiday_date'] .= ','.strtotime($value->date) * 1000;
				}
			}
		}

		$meeting = DB::table('mef_meeting_atendee_join as mef_mtj')
			->leftJoin('mef_meeting as mef_meet', 'mef_mtj.mef_meeting_id', '=', 'mef_meet.Id')
			->select('mef_mtj.is_join','mef_meet.meeting_date as date','mef_meet.meeting_objective','mef_meet.Id')
			->where('mef_mtj.mef_officer_id',39)
			->get();
		foreach ($meeting as $key => $value) {
			# code...
			if($this->data['holiday_date'] ==''){
				$this->data['holiday_date'] .= strtotime($value->date)* 1000;
			}else{
				$this->data['holiday_date'] .= ','.strtotime($value->date) * 1000;
			}
		}

		$array_data = DB::select('SELECT `mef_tls`.`take_date` as `date`
							FROM `v_mef_take_leave` AS `mef_tls`
							WHERE `mef_tls`.`officer_id_sender`="'.$this->user->Id.'"
							Order by `mef_tls`.`take_date` DESC
							');
		foreach($array_data as $key =>$value){
			if($this->data['holiday_date'] ==''){
				$this->data['holiday_date'] .= strtotime($value->date)* 1000;
			}else{
				$this->data['holiday_date'] .= ','.strtotime($value->date) * 1000;
			}
		}
		return view($this->viewFolder.'.Attendance.attendance-checkin')->with($this->data);
    }
	public function getApprovement(){
		return view($this->viewFolder.'.Attendance.attendance-approve');

	}
	public function postApprovement(Request $request){
		
		$check=false;
		
		$db = DB::table('mef_take_leave_status_approval as tsa')
			->select('tsa.*','v_mef.full_name_kh')
			->leftJoin('v_get_all_mef_officer AS v_mef','v_mef.Id','=','tsa.approval_id')
			
			->where('tsa.take_leave_id',$request->Id)
			->orderBy('tsa.approver_order','DESC')
			->get();
		$app_pro = DB::table('mef_take_leave_status_approval as tsa')
			->where('tsa.take_leave_id',$request->Id)
			->orderBy('tsa.approver_order','DESC')
			->where('tsa.approval_id',$this->user->Id);
		$approver_order = 	isset($app_pro->first()->approver_order)?$app_pro->first()->approver_order:0;
		
		foreach($db as $key =>$db_val){
			if($approver_order > $db_val->approver_order && $db_val->approval_id!=$this->user->Id ){
				return json_encode(array('code'=>0,'message'=>'រង់ចាំ '.$db_val->full_name_kh.'ត្រួតពិនិត្យជាមុន', "description" => ""));
			}
		}
		
		if($db){
			
			$rs_dbs =DB::table('mef_take_leave_status_approval as tsa')
				->where('tsa.approval_id',$this->user->Id)
				->where('tsa.take_leave_id',$request->Id)
				->update(['tsa.status'=>$request->approve,'tsa.approval_date' =>date("Y-m-d H:i:s")]);
			if($request->approve==2){
				$rs_take_succ =DB::table('mef_take_leave as tsa')
						->where('tsa.Id',$request->Id)
						->update(array('tsa.status'=>$request->approve));
			}
			if($rs_dbs){
				$rs_app = DB::table('mef_take_leave_status_approval as tsa')
					->where('tsa.status',0)
					->where('tsa.take_leave_id',$request->Id)
					->count();
				/*ករណីអ្នកអនុញ្ញាតិទាំងអស់យល់ព្រម ច្បាប់ត្រូវអនុម័តជាស្ថាពរ*/
				if($rs_app == 0){
					$rs_take_succ =DB::table('mef_take_leave as tsa')
						->where('tsa.Id',$request->Id)
						->update(array('tsa.status'=>$request->approve));
						if($rs_take_succ){
							DB::table('mef_take_leave_status as tsa')
								->where('tsa.takeleave_id',$request->Id)
								->update(['tsa.status'=>$request->approve,'tsa.updated_dt' =>date("Y-m-d H:i:s")]);
						}
				}
				return json_encode(array('code'=>1,'message'=>'សំនើរសុំអនុញ្ញាតច្បាប់ឈប់សម្រាក ត្រូវបានដំនើរការដោយជោគជ័យ', "description" => ""));
			}
		}
		return json_encode(array('code'=>0,'message'=>'សូមព្យាមម្ងទៀង', "description" => ""));

	}
	public function postTakeLeavViewer(){
		$data= $this->getTakeLeavViewer();
		return json_encode($data);
	}

	public function getTakeLeavViewer(){

		$mef_role_type = $this->getTakeLeavRoleType();
		$param = array();
		$to_officer_id = DB::table('mef_officer_take_leave_role')
				->select('to_officer_id')
				->where('officer_Id',$this->user->Id)
				->first();
		if($to_officer_id){
			$param = explode(',',$to_officer_id->to_officer_id);

		}
		$section = array(
				array('Id'=>3,'title'=>'ថ្ងៃ'),
				array('Id'=>1,'title'=>'ព្រឹក'),
				array('Id'=>2,'title'=>'រសៀល')
		);
		array_push($param,$this->user->Id);
		
		$data = array(
		'mef_role_type'=>$mef_role_type
		,'section'=>$section
		,'mes'=>json_encode($this->user->mef_dep)
		
		);
		return $data;
	}
	public function getTakeLeaveApprovalView()
	{
		return view($this->viewFolder.'.Attendance.attendance-approver');
	}
	public function postTakeLeaveApproval(Request $request){
		// $off = $this->getApprovePersonalInfo($this->user->Id);
		return $db = DB::table('mef_take_leave_status_approval as tla')
			->where('tla.take_leave_id',$request->id)
			->select(
				'tla.take_leave_id',
				'tla.approval_id',
				DB::raw('get_date_khmer(tla.approval_date) as kh_date'),
				'pi.MEF_OFFICER_ID',
				'pi.FULL_NAME_KH',
				'tla.status'
			)
			->leftJoin('mef_personal_information AS pi','pi.MEF_OFFICER_ID','=','tla.approval_id')
			->leftJoin('mef_take_leave AS tls','tls.Id','=','tla.take_leave_id')
			
			->get();
	}
	public function postTakeLeavRole(Request $request){

		$rol = DB::table('mef_take_leave_user_role as urole')->where('urole.officer_id',$request->officer_Id)->first();
		if($rol){
			$db= DB::table('mef_take_leave_type as ttype')
				->select('ttype.Id as Id','ttype.attendance_title as title')
				->whereIn('ttype.Id',explode(',',$rol->take_leave_type_id))->get();
				return array_merge(array((object) array("Id"=>"", "title" => "","position"=>"")),$db);
		}
		
		return array((object) array("text"=>"", "value" => "","position"=>""));
	}
	public function postSave(Request $request)
	{
		$pinfo = $this->getApprovePersonalInfo($this->user->Id);		
		
		if($request->take_leave_role_id =='' || !$request->take_leave_role_id){
            return json_encode(array("code" => 2, "message" => trans('attendance.please_select').trans('attendance.attendance_type'), "data" => $request->all()));
        }
        if($request->take_date==''){
            return json_encode(array("code" => 2, "message" => trans('attendance.please_select').trans('attendance.attendance_date'), "data" => ''));
        }else{
			$ck_date = DB::table('mef_take_leave')->whereDate('start_dt','>=',$request->take_date)->whereDate('end_dt','<=',$request->take_date)
				->where('officer_Id',$this->user->Id)
				->get();
				
			if($ck_date){
				return json_encode(array("code" => 0, "message" => trans('attendance.please_check_date').trans('attendance.attendance_date'), "data" => ''));
			}
		}		
        
		$periodInterval = new \DateInterval( "P1D" ); // 1-day, though can be more sophisticated rule
		
		$start_date =date("Y/m/d", strtotime($request->take_date));		
		$startDate = \DateTime::createFromFormat("Y/m/d",$start_date,new \DateTimeZone("Asia/Phnom_Penh"));
		
		$start_time =date("H:i", strtotime('08:00:00 AM'));
		$end_time =date("H:i", strtotime('05:30:00 PM'));
		$day = $request->num_day;
		if($request->section == 1){
			$end_time =date("H:i", strtotime('12:00:00 PM'));
			$day = 0.5;
		} else if($request->section == 2) {
			$start_time =date("H:i", strtotime('02:00:00 PM'));
			$day = 0.5;
		}
		
		/* validate holiday*/
		$off = $this->getApprovePersonalInfo($this->user->Id);
		$inDataReq = $request->all();
		$inDataReq['officer_id']=$this->user->Id;
		if($off){
			
			$valid_date = $this->attendance->getCheckDate($inDataReq,$off);
		}else{
			$valid_date = $this->attendance->getCheckDate($inDataReq);
		}
		if(sizeOf($valid_date)>0){
			$startDate = $valid_date[0];
			$end_date = $valid_date[sizeOf($valid_date)-2];
			$comeback_dt = $valid_date[sizeOf($valid_date)-1];
		}
		
		$inData = array(
			'take_leave_role_type_id'	=>$request->take_leave_role_id,
			'officer_Id'				=>$this->user->Id,
			'reason'					=>$request->reason,
			'day'						=>$request->num_day,
			'request_by'				=>$this->user->Id,
			'start_dt'					=>$startDate,
			'end_dt'					=>$end_date,
			'comeback_dt'				=>$comeback_dt,
			'section'					=>$request->section,
			'created_dt'				=>date("Y-m-d H:i:s"),
			'updated_dt'				=>date("Y-m-d H:i:s"),
		);
		
		$date_arr_date  = array();
		$inserted_id = DB::table('mef_take_leave')->insertGetId($inData);
		$approval_id = array();
		if($inserted_id){
			$approval_db = DB::table('mef_take_leave_approver')->where('take_leave_id',$request->take_leave_role_id)->get();
			foreach($approval_db as $approval){
				$data_take_status = array(
					'take_leave_id' => $inserted_id,
					'approval_id' => $approval->approver_id,
					'approver_order' => $approval->order_id,
					'created_dt'=>date("Y-m-d H:i:s")
				);
				array_push($approval_id,$approval->approver_id);
				DB::table('mef_take_leave_status_approval')->insert($data_take_status);
			}
			$approval_office = DB::table('v_mef_officer')
					->where('ministry_id', $pinfo->ministry_id)
					->where('general_department_id', $pinfo->general_department_id)
					->where('department_id', $pinfo->department_id)
					->where('office_id', $pinfo->office_id)
					->where('position_id',6)
					->whereNull('approve')
					->orderBy('position_order', 'asc')
					->get();
			foreach($approval_office as $approval){
				$data_take = array(
					'take_leave_id' => $inserted_id,
					'approval_id' => $approval->Id,
					'approver_order' => 0,
					'created_dt'=>date("Y-m-d H:i:s")
				);
				
				array_push($approval_id,$approval->Id);
				DB::table('mef_take_leave_status_approval')->insert($data_take);
				/*ត្រួតពិនិត្យពេលប្រធាន មិននៅត្រូវផ្ញើរច្បាប់ទៅអ្នកទទួលបន្ទុកដែលប្រធានបានផ្ទេរឲ្យ*/
				//ត្រួតពិនិត្យករណីប្រធានការិយាល័យសុំច្បាប់
				$lead_office = DB::table('mef_take_leave')->whereDate('start_dt','>=',$request->take_date)
					->whereDate('end_dt','<=',$request->take_date)
					->where('officer_Id',$approval->Id)
					->get();
				if($lead_office){
					$tran_right = DB::table('mef_officer_right_transfer')->where('from_officer_id',$approval->Id)->get();
					foreach($tran_right as $tran){
						$data_tran = array(
							'take_leave_id' => $inserted_id,
							'approval_id' => $tran->to_officer_id,
							'approver_order' => 0,
							'created_dt'=>date("Y-m-d H:i:s")
						);
						array_push($approval_id,$tran->to_officer_id);
						DB::table('mef_take_leave_status_approval')->insert($data_tran);
					}
				}
				
			}
			
		}
		/* mef_take_leave_status */
		foreach($valid_date as $date){
			$saveData = array(
				'officer_id'=>$this->user->Id,
				'takeleave_id'=>$inserted_id,
				'take_date'=>$date,
				'day'=>$day,
				'start_time'=>$start_time,
				'end_time'=>$end_time,
				'reason'=>$request->reason,
				'status'=>0,
				'section'=>$request->section,
				'created_by'=>$this->user->Id,
				'created_dt'=>date("Y-m-d H:i:s"),
				'updated_dt'=>date("Y-m-d H:i:s")
			);
			$take_leave_status = DB::table('mef_take_leave_status')->insertGetId($saveData);
			array_push($date_arr_date, $this->Tool->dateformate($date,' '));
		}
		
		$send_m = DB::table('v_mef_officer')
					// ->where('is_approve',2)
					->whereNull('approve')
					->whereIn('Id',$approval_id)
					->orderBy('position_order', 'asc')
					->get();
		// dd($send_m);
		GOTO GOTONOTSEND;
		$this->userInfo = $this->getUserInfo($this->user->Id);
		$dur = sizeof($date_arr_date)>0? sizeof($date_arr_date):0;
		$inData['duration']= $this->data['constant'][$dur];
		$inData['reason']=$request->reason;
		$inData['date']= $date_arr_date;
		$inData['name']=$this->userInfo->full_name_kh;
		$inData['gender']=$this->userInfo->gender;
		$inData['position'] = $this->userInfo->position;
		$inData['department_name'] = $this->userInfo->department_name;
		$inData['general_department_name'] = $this->userInfo->general_department_name;
		$inData['url_res']=url('/') . '/attendance-mail/'.Crypt::encrypt($inserted_id.'~'.$request->mef_viewer);
		foreach ($send_m as $key => $value) {
			# code...
			$this->email_id = $value->email;
			$this->end_email = 0;

			$inData['to_name']=$value->full_name_kh;
			$inData['to_gender']=$value->gender;
			$this->end_email =$key;
			Mail::send($this->viewFolder.'.Attendance.take-leave-form', $inData, function ($message) {
				$message->from($this->userInfo->email, 'សំនើរសុំច្បាប់');
				$message->subject('សំនើរសុំច្បាប់');
				$message->to($this->email_id);
				
			});
		}
		GOTONOTSEND:
		if($inserted_id){
			return json_encode(array('code'=>1,'message'=>'សំនើរសុំអនុញ្ញាតច្បាប់ឈប់សម្រាក ត្រូវបានផ្ញើដោយជោគជ័យ', "data" => ""));
		}else{
			return json_encode(array('code'=>0,'message'=>'សូមព្យាមម្ងទៀង', "description" => ""));
		}

	}
	
	public function getListAllTakeLeave(Request $request)
	{
		$list_takeleave = array();
		
		$list_takeleave = DB::table('mef_take_leave AS tls')
			->select(
				DB::raw('get_date_khmer(`tls`.`start_dt`) as start_dt'),
				DB::raw('get_date_khmer(`tls`.`end_dt`) as end_dt'),
				'v_mef.*',
				'tls.Id as tId',
				'tls.section',
				'tls.status',
				DB::raw('CEILING(`day`) as day')
			)
			->leftJoin('v_mef_officer AS v_mef','v_mef.Id','=','tls.officer_id')
			->where('tls.officer_id',$this->user->Id)
			->get();
		
		$ch_approve= $this->attendance->checkTransferByPosition($this->user->Id,true);
		
		$array_data = $ch_approve;
		$array_data['officer'] = DB::table('mef_officer_right_transfer')->where('from_officer_id',$this->user->Id)->first();
		$array_data['list'] = $list_takeleave;
		$array_data['user'] = $this->user;
		$array_data['all_date'] = DB::table('mef_take_leave_status')->where('officer_id',$this->user->Id)->where('status',1)->count();
       return json_encode($array_data);
	}
	public function getListAllTakeLeaveByUser(Request $request)
	{
	   $list_takeleave = array();
	   $list_takeleave = DB::table('mef_take_leave AS tls')
			->select(
				DB::raw('datediff(`tls`.`end_dt`,`tls`.`start_dt`) as dt'),
				DB::raw('get_date_khmer(`tls`.`start_dt`) as start_dt'),
				DB::raw('get_date_khmer(`tls`.`end_dt`) as end_dt'),
				
				'pinfo.*',
				'tls.Id as tId',
				'tls.reason',
				'tls.section',
				'tls.status',
				'tls.day',
				DB::raw('(SELECT `status` FROM mef_take_leave_status_approval WHERE approval_id='.$this->user->Id.' AND take_leave_id = `tls`.Id) as own_app')
			)
			->leftJoin('mef_personal_information AS pinfo','pinfo.MEF_OFFICER_ID','=','tls.officer_id')
			->whereRaw('tls.Id In (select take_leave_id FROM mef_take_leave_status_approval where approval_id="'.$this->user->Id.'"
				AND approver_order <= (select approver_order FROM mef_take_leave_status_approval where approval_id ="'.$this->user->Id.'" AND take_leave_id=tls.id))')
			->where('tls.status','<>',2)
			->get();
		
	   $ch_approve= $this->attendance->checkTransferByPosition($this->user->Id,true);	   
	   $array_data = $ch_approve;
	   $array_data['list'] = $list_takeleave;
	   $array_data['all_date'] = DB::table('mef_take_leave_status')->where('officer_id',$this->user->Id)->where('status',1)->count();
	  return json_encode($array_data);
	}
	public function postTakeLeaveById(Request $request){
		
		$list_takeleave = DB::table('mef_take_leave AS tls')
			->select(
				DB::raw('datediff(`tls`.`end_dt`,`tls`.`start_dt`) as dt'),
				DB::raw('get_date_khmer(`tls`.`start_dt`) as start_dt'),
				DB::raw('get_date_khmer(`tls`.`end_dt`) as end_dt'),
				'pinfo.*',
				'tls.Id as tId',
				'tls.reason',
				'tls.section',
				'tls.status'
			)
			->leftJoin('mef_personal_information AS pinfo','pinfo.MEF_OFFICER_ID','=','tls.officer_id')
			->where('tls.Id',$request->takeleave_id)
			->first();
		return json_encode($list_takeleave);
	}
	public function getTakeLeavById(Request $request){
		return json_encode($request->all());
	}
	public function checkMeeting($id=''){
		$result = DB::table('mef_meeting_atendee_join')
					->whereExists(function ($query) {
						$query->select(DB::raw(1))
							->from('mef_meeting')
							->whereRaw('mef_meeting.Id=mef_meeting_atendee_join.mef_meeting_id');
					})
					->whereExists(function ($query) {
						$query->select(DB::raw(1))
							->from('mef_meeting')
							->whereRaw('mef_meeting.Id=mef_meeting_atendee_join.mef_meeting_id');
					})
					->where('mef_meeting_atendee_join.mef_officer_id',$this->user->Id)
					->get();
		return $result;
	}
	public function getUserInfo($id=''){
		$userInfo = DB::table('v_mef_officer')
					->select('*')
					->whereNull('approve')
					->where('Id',$id)
					->first();
		return $userInfo;
	}

	public function getViewFormLeave($id=''){
		// echo $id;
		$this->data['data'] = DB::table('mef_take_leave')
				->join('mef_personal_information', 'mef_take_leave.officer_Id', '=', 'mef_personal_information.MEF_OFFICER_ID')
				->select('mef_take_leave.*','mef_personal_information.FULL_NAME_KH AS name','mef_personal_information.GENDER AS gender')
				->where('mef_take_leave.Id',$id)
				->first();

		$this->data['data']->duration= $this->getKhmerNumber($this->data['data']->duration);
		$this->data['data']->started_dt= $this->Tool->dateformate($this->data['data']->started_dt,' ');
		$this->data['data']->end_dt= $this->Tool->dateformate($this->data['data']->end_dt,' ');
		// dd($this->data['data']);
		return view($this->viewFolder.'.Attendance.take-leave-form')->with($this->data);
	}
	public function getUserReq($key=''){

		$decrypted = Crypt::decrypt($key);
		$para = explode('~',$decrypted);
		// dd($para);
		if(isset($decrypted)){

			if(sizeof($para)==2){
				$user_app = explode(',',$para[1]);
				if(in_array($this->user->Id,$user_app)){
					$affected = DB::table('mef_take_leave_status')
					->where('officer_id',$para[1])
					->where('takeleave_id',$para[0])->count();
					if($affected > 0){
						return redirect('/#/attendance-info/approve/'.$para[0]);
					}

				}else{
					return redirect('/#/attendance-info');
				}
			}else{
				return redirect('/#/attendance-info');
			}

		}else{
			return redirect('/#/attendance-info');
		}
	}

	public function getKhmerNumber($value='')
	{
		# code...
		$arr1 = str_split($value);
		$str='';
		foreach ($arr1 as $key => $value) {
			# code...
			$str .= $this->data['constant'][$value];
		}
		return $str;
	}
	public function getTakeLeavRoleType($id=''){
		$att_type = array((object) array("text"=>"", "value" => ""));
        return $list_type = DB::table('mef_take_leave_role_type')
                ->select('attendance_type as title','Id')->get();
    }
	
	public function postCheckDate(Request $request){
		
		$inData = $request->all();
		$inData['officer_id']=$this->user->Id;
		$off = $this->getApprovePersonalInfo($this->user->Id);
		if($off){
			return $this->attendance->getCheckDate($inData,$off);
		}else{
			return $this->attendance->getCheckDate($inData);
		}         
	}
	public function getTransfer(){
		
		return view($this->viewFolder.'.Attendance.transfer')->with($this->data);
	}
	public function postTransfer(Request $request)
	{
		
		$to_officer_id = isset($request->officer_id)?$request->officer_id:null;
		$ck_re = DB::table('mef_officer_right_transfer')->where('from_officer_id',$this->user->Id)->first();
		if($ck_re){
			DB::table('mef_officer_right_transfer')->where('from_officer_id',$this->user->Id)
				->update(array('to_officer_id'=>$to_officer_id));
		}else{
			if($to_officer_id !=null){
				DB::table('mef_officer_right_transfer')
					->insert(array('from_officer_id'=>$this->user->Id,'to_officer_id'=>$to_officer_id));
			}
			
		}
		$officer = DB::table('mef_officer_right_transfer')->where('from_officer_id',$this->user->Id)->first();
		return json_encode(array('code'=>1,'message'=>'ការផ្ទេរសិទ្ធជោគជ័យ', "data" => $officer));
	}
}
