<?php 
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use Input;
use DB;
use File;
use Config;
use Illuminate\Support\Facades\Storage;
use App\libraries\Tool;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;
use Illuminate\Support\Facades\Response;
use App\Models\BackEnd\Attendance\AttendanceOfficerModel;
use App\Models\BackEnd\Attendance\AttendanceTypeModel;
use App\Models\BackEnd\Attendance\AttendanceModel;
use Illuminate\Support\Facades\Validator;
use DateTime;
class AttendanceOfficerController extends BackendController
{
	public function __construct(){
        parent::__construct();
        $this->tool = new Tool();
        $this->officer = new AttendanceOfficerModel();
        $this->attendance = new AttendanceTypeModel();
		$this->AttendanceModel = new AttendanceModel();
		$this->user = session('sessionUser');
		if(!isset($this->user->mef_general_department_id))
			return array();
		
		$this->member = explode(',',$this->user->mef_member_id);
		array_push($this->member,strval($this->user->id));//dd($this->member);
		$this->section = array(
				array('value'=>3,'text'=>'ថ្ងៃ'),
				array('value'=>1,'text'=>'ព្រឹក'),
				array('value'=>2,'text'=>'រសៀល')
		);
		$this->data['section'] = json_encode($this->section);
		$this->data['start_dt']= date("Y-m-d");
		$this->data['end_dt']= date("Y-m-d");
		$this->data['downUrl'] = asset(Config::get('constant')['secretRoute'].'/attendance-officer/download-file');
    }
    public function getIndex(Request $request)
    {
        $this->data['total_mef_officer'] = $this->constant['mefTotalOfficer'];
        $this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
        $this->data['start_dt']= date("Y-m-d");
        $this->data['end_dt']= date("Y-m-d");
        $this->data['section']= json_encode(
			array(trans('attendance.full_day')
			,trans('attendance.morning')
			,trans('attendance.evening'))
		);
        if(sizeof($request)>0){
            if($request->start_dt!=''){
                $start_dt = $request->start_dt;
            }
        }
        return view($this->viewFolder.'.attendance.attendance-officer.index')->with($this->data);
    }
    public function postIndex(Request $request)
    {
        return $this->officer->getDataGrid($request->all());
    }
    
    public function postGetOfficeByDepartmentId(Request $request){
        $departmentId = intval($request->departmentId);
        $this->data['listOffice'] = $this->attendance->getOfficeByDepartmentId($departmentId);
        return $this->data['listOffice'];
    }
    public function postNew(Request $request)
    {
        $this->data['current_dt']= date("Y-m-d");
        $this->data['list_officer']= json_encode($this->officer->getAttendanceViewer($this->user->mef_general_department_id));
        $att_type = array((object) array("text"=>"", "value" => ""));
        $this->data['att_role_type']= json_encode($att_type);
		$this->data['att_type'] = json_encode(array((object) array("text"=>"", "value" => "","position"=>"")));
		return view($this->viewFolder.'.attendance.attendance-officer.new')->with($this->data);
    }

    public function postSave(Request $request)
    {
		$files = Input::file('file');
		$periodInterval = new \DateInterval( "P1D" ); // 1-day, though can be more sophisticated rule
		
		$start_date =date("Y/m/d", strtotime($request->take_date));		
		$startDate = \DateTime::createFromFormat("Y/m/d",$start_date,new \DateTimeZone("Asia/Phnom_Penh"));	
		
		if($request->attendance_role_type==''){
            return json_encode(array("code" => 0, "message" => trans('attendance.please_select').trans('attendance.attendance_type'), "data" => $request->all()));
        }
        if($request->take_date==''){
            return json_encode(array("code" => 0, "message" => trans('attendance.please_select').trans('attendance.attendance_date'), "data" => ''));
        }else{
			$ck_date = DB::table('mef_take_leave')->whereDate('start_dt','>=',$request->take_date)
					->whereDate('end_dt','<=',$request->take_date)
					->where('officer_Id',$request->officer_id);
				
			if($request->section <> 3){
				$ck_date = $ck_date->where('section',$request->section);
			}
			$ck_date = $ck_date->first();
			if($ck_date){
				if(isset($request->Id) && $request->Id <> $ck_date->Id){
					return json_encode(array("code" => 0, "message" => trans('attendance.please_check_date').trans('attendance.attendance_date').'test', "data" => $ck_date));
				}				
			}
		}
		/* validate file */
		if($request->Id > 0){
			
			$file_image = DB::table('mef_take_leave_file')->where('take_leave_id',$request->Id)->count();
			if($file_image==0 && sizeof($files)==0){
				return json_encode(array("code" => 0, "message" => trans('attendance.please_select_file'), "data" => ''));
			}
		}else{
			if(sizeof($files)<=0){
				return json_encode(array("code" => 0, "message" => trans('attendance.please_select_file'), "data" => ''));
			}
		}
		$week_day = new DateTime($request->take_date);
		
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
		/*declaration of date */
		$role_type= $this->attendance->getTakeRoleType($request->attendance_role_type);
		/*declaration of date */
		$where = array('status'=>1,'take_leave_role_type_id'=>$request->attendance_role_type);
		$check_take_dt = $this->attendance->checkTakeLeave($request->officer_id);
		
		/* validation when take leave request is over */
		if($role_type){
			if($role_type->day_of_year <= floatval($check_take_dt)+$day){
				$data_return = array(
					'allow_day' => $role_type->day_of_year
					,'request_day' =>$day
					,'take_day' =>$check_take_dt
				);
				if($request->adm==0){
					return json_encode(array("code" => 5, "message" => "តើអ្នកយល់ព្រមអនុញ្ញាតច្បាប់បន្ថែមើលច្បាប់ដែលបានធ្លាប់ស្នើរសុំឈប់ ".$check_take_dt." ថ្ងៃនៃថ្ងៃឈប់សរុប់ ".$role_type->day_of_year, "data" => $data_return));
				}
			}
		}
		
		/* validate holiday*/
		if($request->Id > 0){
			DB::table('mef_take_leave_status')->where('takeleave_id',$request->Id)->delete();			
		}
		$pinfo = $this->getApprovePersonalInfo($request->officer_id);
		if($pinfo){
			$valid_date = $this->officer->getCheckDate($request->all(),$pinfo);
		}else{
			$valid_date = $this->officer->getCheckDate($request->all());
		}
		if(sizeOf($valid_date)>0){
			$startDate = $valid_date[0];
			$end_date = $valid_date[sizeOf($valid_date)-2];
			$comeback_dt = $valid_date[sizeOf($valid_date)-1];
		}
		
		/*       សិក្សាពីលក្ខណ្ឌក្នុងកាសុំច្បាប់ស្ទួនថ្ងៃ     */
		
		$inData = array(			
			'take_leave_role_type_id'	=>$request->attendance_role_type,
			'officer_Id'				=>$request->officer_id,
			'reason'					=>$request->description,
			'request_by'				=>$this->user->id,
			'start_dt'					=>$startDate,
			'end_dt'					=>$end_date,
			'comeback_dt'				=>$comeback_dt,
			'day'						=>$day,
			'status'					=>isset($request->status),
			'message_adm'				=>isset($request->message_adm)?$request->message_adm:null,
			'section'					=>$request->section,
			'created_dt'				=>date("Y-m-d H:i:s"),
			'updated_dt'				=>date("Y-m-d H:i:s"),
		);
		
		if($request->Id > 0){
			$inserted_id = $request->Id;
			$dt = DB::table('mef_take_leave')->where('Id',$request->Id)->first();//dd($dt);			
			if($dt){
				unset($inData['created_dt']);
				unset($inData['created_by']);
				DB::table('mef_take_leave_status')->where('takeleave_id',$request->Id)->delete();
				DB::table('mef_take_leave')->where('Id',$inserted_id)->update($inData);
			}
			
		}else{
			$inserted_id = DB::table('mef_take_leave')->insertGetId($inData);			
		}
		/* insert to approval id */
		if($inserted_id){
			$approval_db = DB::table('mef_take_leave_approver')
				->where('take_leave_id',$request->attendance_role_type)->get();
			foreach($approval_db as $approval){
				$data_take_status = array(
					'take_leave_id'  => $inserted_id,
					'approval_id' => $approval->approver_id,
					'approver_order' => $approval->order_id,
					'status'		 =>isset($request->status),
					'created_dt'=>date("Y-m-d H:i:s"),
					'approval_date'=>isset($request->status)?date("Y-m-d H:i:s"):null,
					'created_by'=>$this->user->id
				);
				
				DB::table('mef_take_leave_status_approval')->insert($data_take_status);

			}
			/* ស្នើរសុំទៅប្រធានការិយាលល័យ*/
			if($pinfo){
				$approval_office = DB::table('v_mef_officer')
					->where('ministry_id', $pinfo->ministry_id)
					->where('general_department_id', $pinfo->general_department_id)
					->where('department_id', $pinfo->department_id)
					->where('office_id', $pinfo->office_id)
					->where('position_id',6)
					->whereNull('approve')
					->orderBy('position_order', 'asc')
					->get();
				foreach($approval_office as $office){
					$data_take = array(
						'take_leave_id' => $inserted_id,
						'approval_id' => $office->Id,
						'approver_order' => 0,
						'status'		 =>isset($request->status),
						'created_dt'=>date("Y-m-d H:i:s"),
						'approval_date'=>isset($request->status)?date("Y-m-d H:i:s"):null,
						'created_by'=>$this->user->id
					);
					DB::table('mef_take_leave_status_approval')->insert($data_take);
					/*ត្រួតពិនិត្យពេលប្រធាន មិននៅត្រូវផ្ញើរច្បាប់ទៅអ្នកទទួលបន្ទុកដែលប្រធានបានផ្ទេរឲ្យ*/
					//ត្រួតពិនិត្យករណីប្រធានការិយាល័យសុំច្បាប់
					$lead_office = DB::table('mef_take_leave')
						->whereDate('start_dt','>=',$request->take_date)
						->whereDate('end_dt','<=',$request->take_date)
						->where('officer_Id',$office->Id)
						->get();
					if($lead_office){
						$tran_right = DB::table('mef_officer_right_transfer')->where('from_officer_id',$office->Id)->get();
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
			
		}
		
		if($request->section == 3){
			$day = 1;
		}
		
		foreach($valid_date as $k => $val){
			$saveData = array(
				'officer_id'	=>$request->officer_id,
				'takeleave_id'	=>$inserted_id,
				'take_date'		=>$val,                
				'day'			=>$day,
				'start_time'	=>$start_time,
				'end_time'		=>$end_time,
				'reason'		=>$request->description,                
				'status'		=>isset($request->status),
				'section'		=>$request->section,
				'created_by'	=>$this->user->id,
				'created_dt'=>date("Y-m-d H:i:s"),
				'updated_dt'=>date("Y-m-d H:i:s")
			);
			if($k < sizeOf($valid_date)-1){				
				$insertGetId=DB::table('mef_take_leave_status')->insertGetId($saveData);
			}
		}	
		
		if($files){
			foreach ($files as $file) {
				// Validate each file
				$rules = array('file' => 'required'); // 'required|mimes:png,gif,jpeg,txt,pdf,doc'
				$validator = Validator::make(array('file'=> $file), $rules);
				if($validator->passes()) {
					
					if(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION)!='pdf'){
						return array("code" => 0,"message" => trans('attendance.file_error'),"data"=>'error file');
					}
					$destinationPath = 'files/take_leave/';                    
					$filename = $destinationPath .str_replace(' ','-',date("Y-m-d h-i-s")).'.'.pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
					$upload_success = $file->move($destinationPath, $filename);
					$original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					if(!empty($inserted_id)){
						DB::table('mef_take_leave_file')->insert(
							array(
								'take_leave_id' =>$inserted_id,
								'url'			=>$filename,
								'original_name' =>$file->getClientOriginalName()
							)
						);
					}
					// Flash a message and return the user back to a page...
				} else {
					return array("code" => 5,"message" => trans('attendance.succe_insert'),"data"=>'error file');
				}
				if($request->Id){
					return json_encode(array("code" => 1, "message" => trans('attendance.succe_update'), "data" => ''));
				}
				return json_encode(array("code" => 1,"message" => trans('attendance.succe_insert'),"data"=>''));
			}
		}
		
		return json_encode(array("code" => 1,"message" => trans('attendance.succe_insert'),"data"=>''));
    }
	public function postCheckDate(Request $request){
		
		$inData = $request->all();
		$inData['officer_id']=$this->user->id;
		$off = $this->AttendanceModel->getApprovePersonalInfo($this->user->id);
		if($off){
			return $this->AttendanceModel->getCheckDate($inData,$off);
		}else{
			return $this->AttendanceModel->getCheckDate($inData);
		}         
	}
	private	function getDatesBetween2Dates($startTime, $endTime, $id) {
		$day = 86400;
		$format = 'Y-m-d';
		$startTime = strtotime($startTime);
		$endTime = strtotime($endTime);
		$numDays = round(($endTime - $startTime) / $day);
		$days = array();
		if($id > 0){
			$i = 0;
		} else {
			$i = 1;
		}
		for ($i; $i <= $numDays; $i++) {
			$date = $startTime + ($i * $day);
			$days[] = date($format, $date);
		}	
		return $days;
	}
	
    public function postEdit(Request $request){
		$row = $this->officer->getDataByRowId($request['Id']);//dd($row);
		$this->data['row'] = $row;		
		$type = array((object) array("text"=>"", "value" => ""));
		
        $this->data['list_officer']= json_encode($this->officer->getAttendanceViewer($this->user->mef_general_department_id));
		$this->data['mef_officer_join'] = $row->officer_id;		
		$pinfo = $this->AttendanceModel->getApprovePersonalInfo($row->officer_id);		
		$att_role_type = $this->officer->getTakeLeavRoleByPosition($pinfo->position_id);        
        $this->data['att_role_type']= json_encode($att_role_type);
		
		$this->data['file']= $this->officer->getFile($request['Id']);
		$this->data['current_dt']= isset($this->data['row']->date)?$this->data['row']->date:date("Y-m-d");
		$this->data['start_dt']= isset($row->start_dt) ? $row->start_dt:date("Y-m-d");
		$this->data['end_dt']= isset($row->end_dt) ? $row->end_dt:date("Y-m-d");
		$this->data['current_dt'] = date("Y-m-d");
        return view($this->viewFolder.'.attendance.attendance-officer.new')->with($this->data);
    }
	
	private function getEditRange($array){
		return $this->officer->getEditRange($array);
	}
	
    public function postHoliday(Request $request)
    {
        $this->data['holi'] = DB::table('mef_holiday')
                ->where('status',1)->get();
        $this->data['holiday_date'] = '';
        foreach($this->data['holi'] as $key =>$value){
            if($value->date !='') {
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
            if($this->data['holiday_date'] ==''){
                $this->data['holiday_date'] .= strtotime($value->date)* 1000;
            }else{
                $this->data['holiday_date'] .= ','.strtotime($value->date) * 1000;
            }
        }

        $array_data = DB::select('SELECT `mef_tls`.`take_date` as `date`
                            FROM `v_mef_take_leave` AS `mef_tls`                            
                            WHERE `mef_tls`.`officer_id_sender`="'.$request->userId.'"
                            Order by `mef_tls`.`take_date` DESC
                            ');
        foreach($array_data as $key =>$value){
            if($this->data['holiday_date'] ==''){
                $this->data['holiday_date'] .= strtotime($value->date)* 1000;
            }else{
                $this->data['holiday_date'] .= ','.strtotime($value->date) * 1000;
            }
        }
        
        return json_encode($this->data['holiday_date']);
    }
	
	public function postValidationAttendance(Request $request){
		return $this->officer->validationAttendance($request->all());
	}
	
    public function postDelete(Request $request)
    {
        if(is_array($request->Id)){
            $arr_take_id=$request->Id;
        }else{
            $arr_take_id=array($request->Id);
        }
		$del_mef_take_leave = DB::table('mef_take_leave')->whereIn('id',$arr_take_id)->delete();
        $del_img = DB::table('mef_take_leave_file')->whereIn('take_leave_id',$request->Id);
        
        foreach ($del_img->get() as $kim => $vim) {
			$deleted_imag = DB::table('mef_take_leave_file')->where('url',$vim->url)->get();
			if(count($deleted_imag) == 1){
				 Storage::disk('public')->delete($vim->url);
			}
        }
        $del = DB::table('mef_take_leave_status')->whereIn('created_by',$this->member)
            ->whereIn('id',$arr_take_id);
        $del_img->delete();
        $del->delete();
        if($del){
			
            if(!empty($ids)){
				foreach($ids as $key => $value){
					$dels = json_decode($value->ref_ids);
					DB::table('mef_take_leave_status')->whereIn('id',$dels)->where('created_by',$this->user->id)->delete();
				}
			}
			
			return array("code" => 2,"message" => trans('attendance.delete_sucess'));
        }else{
            return array("code" => 1, "message" => trans('attendance.delete_note_err'));
        }
    }
	public function getDownloadFile($id)
    {
		$file = DB::table('mef_take_leave_file')->where('id',$id)->first();
		if($file){
			return Response::download(public_path($file->url));
			if(Storage::disk('public')->exists($file->url)){dd($file);
				return Response::download(public_path($file->url));
			}
		}
		return abort(404);
	}
    public function postDeleteFiles(Request $request)
    {
		$del_img = DB::table('mef_take_leave_file')->where('id',$request->Id)->first();

        if(!empty($del_img)){
			Storage::disk('public')->delete($del_img->url);
			
			DB::table('mef_take_leave_file')->where('id',$request->Id)->delete();
			return array("code" => 1,"message" => trans('attendance.delete_sucess'));
		} else {
			return array("code" => 0, "message" => trans('attendance.delete_note_err'));
		}
	}
	public function postTakeLeavRole(Request $request){
		return $this->officer->getTakeLeavRole($request->all());
	}
	public function postTakeLeavRoleByOfficer(Request $request){
		if($request->userId=='' || $request->userId<=0){
			return $arrList = (array(array("text"=>"", "value" => "")));
		}
		$pinfo = $this->AttendanceModel->getApprovePersonalInfo($request->userId);
		// dd($pinfo);
		if($pinfo){
			return $this->officer->getTakeLeavRoleByPosition($pinfo->position_id);
		}
		return $arrList = (array(array("text"=>"", "value" => "")));
	}
}
