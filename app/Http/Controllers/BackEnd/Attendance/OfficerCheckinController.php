<?php
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use DB;
use View;
use File;
use Excel;
use Config;
use Input;
use Storage;
use Response;

use App\libraries\Tool;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;
use App\Models\BackEnd\Attendance\AttendanceReportModel;
use App\Models\BackEnd\Attendance\OfficerCheckinModel;
use App\Models\BackEnd\Attendance\AttendanceTypeModel;
use App\Models\BackEnd\Attendance\TakeLeaveTempModel;

class OfficerCheckinController extends BackendController
{
    public function __construct(){
        parent::__construct();
        $this->tool = new Tool();
        $this->officer = new OfficerCheckinModel();
        $this->report = new AttendanceReportModel();
        $this->attendance = new AttendanceTypeModel();
        $this->user = session('sessionUser');
        if(!isset($this->user->mef_general_department_id))
            return array();
        $this->messages = Config::get('constant');
        

        $this->store_to_path = 'files/scan/';
    }
    public function getIndex(Request $request)
    {
        $arr = array("morning"=>array("is_late"=>1),"evening"=> array("is_late"=>1));
        $this->data['total_mef_officer'] = $this->constant['mefTotalOfficer'];
        $listPosition = $this->report->getPosition();
        $listDepartment = $this->report->getAllDepartmentBySecretariatId($this->user->mef_general_department_id,$this->user->mef_department_id);
        $this->data['listPosition'] = json_encode($listPosition);
        $this->data['listDepartment'] = json_encode($listDepartment);
        $listOffice = $this->report->getOfficeByDepartmentId($this->user->mef_department_id);
        $this->data['listOffice'] = json_encode($listOffice);
        $this->data['mef_department_id'] = $this->user->mef_department_id;
        $this->data['start_dt']= date("Y-m-d H:i:s");
        $this->data['end_dt']= date("Y-m-d H:i:s");
        if(sizeof($request)>0){
            if($request->start_dt!=''){
                $start_dt = $request->start_dt;
            }
        }
        // dd($this->user);
        $this->data['officer'] = DB::table('mef_user_activity as ua')
                ->leftJoin('mef_service_status_information as ssi','ssi.MEF_OFFICER_ID','=','ua.mef_user_id')
                ->leftJoin('mef_personal_information as pi','pi.MEF_OFFICER_ID','=','ua.mef_user_id')
                ->leftJoin('mef_position as po','po.ID','=','ssi.MEF_OFFICER_ID')
                ->whereRaw('DATE_FORMAT(ua.date,"%Y-%m-%d")>=DATE_FORMAT("'.$this->data['start_dt'].'","%Y-%m-%d")')
                ->whereRaw('DATE_FORMAT(ua.date,"%Y-%m-%d")<=DATE_FORMAT("'.$this->data['end_dt'].'","%Y-%m-%d")')
                ->select(DB::Raw("DATE_FORMAT(ua.date,'%Y-%m-%d')as date_dt,ssi.MEF_OFFICER_ID as value,pi.FULL_NAME_KH as text,pi.FULL_NAME_EN,po.ORDER_NUMBER"))
                ->orderBy('ua.date','ASC')
                ->orderBy('po.ORDER_NUMBER','ASC')
                ->groupBy('ua.mef_user_id')
                ->paginate(25);
        return view($this->viewFolder.'.attendance.officer-checkin.index')->with($this->data);
    }

    public function getSearch(Request $request)
    {
        /* init start to date*/
        $this->data['start_dt']=date('l \t\h\e jS');
        $this->data['end_dt']=date('l \t\h\e jS');
        if($request->start_dt){
            $this->data['start_dt'] =$request->start_dt;
        }
        if($request->end_dt){
            $this->data['end_dt'] = $request->end_dt;
        }
		if(isset($request->full_rang_day)){
			$date_dt =  explode(' - ',$request->full_rang_day);
			if(sizeof($date_dt)==1){
				$date_dt = array(date("Y-m-d"),date("Y-m-d"));
			}
			$this->data['start_dt'] = $date_dt[0];
			$this->data['end_dt'] = $date_dt[1];
		}

        $this->data['total_mef_officer'] = $this->constant['mefTotalOfficer'];
        $listPosition = $this->report->getPosition();
        $listDepartment = $this->report->getAllDepartmentBySecretariatId($this->user->mef_general_department_id);

        $this->data['mef_department_id'] = $this->user->mef_department_id;;
        $listOffice = $this->report->getOfficeByDepartmentId($this->user->mef_department_id);
        
        $this->data['officer'] = DB::table('mef_user_attendance as ua')
            ->leftJoin('v_mef_officer as v_mef','v_mef.Id','=','ua.mef_user_id')
            ->select(DB::Raw("ua.*,DATE_FORMAT(ua.date,'%Y-%m-%d')as date,v_mef.FULL_NAME_KH as FULL_NAME_KH,v_mef.orderNumber as ORDER_NUMBER"))
            ->whereRaw('DATE_FORMAT(ua.date,"%Y-%m-%d")>=DATE_FORMAT("'.$this->data['start_dt'].'","%Y-%m-%d")')
            ->whereRaw('DATE_FORMAT(ua.date,"%Y-%m-%d")<=DATE_FORMAT("'.$this->data['end_dt'].'","%Y-%m-%d")')
            ->whereNull('approve')
			->where('v_mef.department_id',$request->mef_department_id)
			->where('v_mef.active',1)	
            ->orderBy('v_mef.orderNumber');
            // dd($this->data['officer']);
        if(sizeof($request)>0){
            if($request->mef_office_id!=''){
                $this->data['mef_office_id'] = $request->mef_office_id;
                $this->data['officer'] =$this->data['officer']->where('v_mef.office_id',$request->mef_office_id);
            }if($request->mef_position_id!=''){
                $this->data['mef_position_id'] = $request->mef_position_id;
                $this->data['officer'] =$this->data['officer']->where('v_mef.position_id',$request->mef_position_id);
            }if($request->officer_name!=''){
                $this->data['officer_name'] = $request->officer_name;
                $this->data['officer'] =$this->data['officer']->where('v_mef.FULL_NAME_KH','like','%'.$request->officer_name.'%');
            }if($request->officer_id!=''){
                $this->data['officer_id'] = $request->officer_id;
                $this->data['officer'] =$this->data['officer']->where('mef_user_id',$request->officer_id);
            }
        }
        $this->data['officer'] = $this->data['officer']->orderBy('ua.date','ASC');
        $this->data['listPosition'] = json_encode($listPosition);
        $this->data['listDepartment'] = json_encode($listDepartment);
        $this->data['listOffice'] = json_encode($listOffice);
        $this->data['officer'] =$this->data['officer']->paginate(25);
        // dd($this->data['officer']);
        return view($this->viewFolder.'.attendance.officer-checkin.index')->with($this->data);
        //return $this->officer->getDataGrid($request->all());

    }
    public function getSearchNote(Request $request)
    {
        $this->data['total_mef_officer'] = $this->constant['mefTotalOfficer'];
        $listPosition = $this->report->getPosition();
        $listDepartment = $this->report->getAllDepartmentBySecretariatId($this->user->mef_general_department_id);
        $listOffice = array(array('value'=>'','text'=>''));
        $this->data['start_dt']=date('l \t\h\e jS');
        $this->data['end_dt']=date('l \t\h\e jS');
        if($request->start_dt!=''){
            $this->data['start_dt'] = $request->start_dt;
        }
        if($request->end_dt!=''){
            $this->data['end_dt'] = $request->end_dt;
        }
        $this->data['note'] = DB::table('mef_user_activity_references as ua')
                ->leftJoin('mef_service_status_information as ssi','ssi.MEF_OFFICER_ID','=','ua.mef_user_id')
                ->leftJoin('mef_personal_information as pi','pi.MEF_OFFICER_ID','=','ua.mef_user_id')
                ->leftJoin('mef_position as po','po.ID','=','ssi.MEF_OFFICER_ID')
                ->whereRaw('DATE_FORMAT(ua.date,"%Y-%m-%d")>=DATE_FORMAT("'.$this->data['start_dt'].'","%Y-%m-%d")')
                ->whereRaw('DATE_FORMAT(ua.date,"%Y-%m-%d")<=DATE_FORMAT("'.$this->data['end_dt'].'","%Y-%m-%d")')
                ->select(DB::Raw("DATE_FORMAT(ua.date,'%Y-%m-%d')as date_dt,ssi.MEF_OFFICER_ID as value,pi.FULL_NAME_KH as text,pi.FULL_NAME_EN,po.ORDER_NUMBER,ua.time,ua.section,ua.detail,ua.id"))
                ->orderBy('ua.date','ASC')
                ->orderBy('po.ORDER_NUMBER','ASC')
                ->groupBy('ua.mef_user_id');
        if(sizeof($request)>0){

            if($request->mef_department_id!=''){
                $this->data['mef_department_id'] = $request->mef_department_id;
                $listOffice = $this->report->getOfficeByDepartmentId($request->mef_department_id);
                $this->data['note'] =$this->data['note']->where('CURRENT_DEPARTMENT',$request->mef_department_id);

            }if($request->mef_office_id!=''){
                $this->data['mef_office_id'] = $request->mef_office_id;
                $this->data['note'] =$this->data['note']->where('CURRENT_OFFICE',$request->mef_office_id);
            }if($request->mef_position_id!=''){
                $this->data['mef_position_id'] = $request->mef_position_id;
                $this->data['note'] =$this->data['note']->where('CURRENT_POSITION',$request->mef_position_id);
            }if($request->officer_name!=''){
                $this->data['officer_name'] = $request->officer_name;
                $this->data['note'] =$this->data['note']->where('FULL_NAME_KH','like','%'.$request->officer_name.'%');
            }if($request->officer_id!=''){
                $this->data['officer_id'] = $request->officer_id;
                $this->data['note'] =$this->data['note']->where('mef_user_id',$request->officer_id);
            }
        }
        $this->data['listPosition'] = json_encode($listPosition);
        $this->data['listDepartment'] = json_encode($listDepartment);
        $this->data['listOffice'] = json_encode($listOffice);

        $this->data['note'] =$this->data['note']->paginate(25);

        return view($this->viewFolder.'.attendance.officer-checkin.index')->with($this->data);

    }
    public function postGetOfficeByDepartmentId(Request $request){

        $departmentId = intval($request->departmentId);
        $this->data['listOffice'] = $this->report->getOfficeByDepartmentId($departmentId);
        return $this->data['listOffice'];
    }
    public function postNew(Request $request)
    {
        $this->data['officer_id']=0;
        $this->data['date_dt'] = '';
        $inData = array();
        if($request->Id !='' && $request->Id !=0){
            $inData = explode('|',$request->Id);

            $this->data['date_dt']=$inData[0];
            $this->data['officer_id']=$inData[1];
            $this->data['section']=$inData[2];
            $this->data['time']=$inData[3];
            $this->data['row'] = DB::table('mef_user_activity_references')
            ->whereRaw('DATE_FORMAT(date,"%Y-%m-%d")>=DATE_FORMAT("'.$this->data['date_dt'].'","%Y-%m-%d")')->where('mef_user_id',$this->data['officer_id'])
            ->where('section',$inData[2])
            ->where('time',$inData[3])
            ->first();
        }

        $param = array('CURRENT_GENERAL_DEPARTMENT'=>$this->user->mef_general_department_id);

        $this->data['officer']= json_encode($this->officer->getAllOfficer(null,null,null,'NA',true));
        return view($this->viewFolder.'.attendance.officer-checkin.new')->with($this->data);
    }
    public function postImport()
    {
        if($this->user){
            $is_data = TakeLeaveTempModel::where('created_by',$this->user->id)->count();
            if($is_data){
                return view($this->viewFolder.'.attendance.officer-checkin.check-data')->with($this->data);
            }
        }
        
        return view($this->viewFolder.'.attendance.officer-checkin.import')->with($this->data);
    }
    public function postCheckData(Request $request)
    {
        $mef_ministry = $this->user->mef_ministry_id;
        $mef_general_department = $this->user->mef_general_department_id;
        $mef_department = $this->user->mef_department_id;
        $date_dt="2018-09-03 17:50:40";
        // dd($date_dt.','.$this->user->id.','.$mef_ministry.','.$mef_general_department.','.$mef_department);
        DB::select(DB::raw('Call do_scan_by_section("'.$date_dt.'",'.$this->user->id.','.$mef_ministry.','.$mef_general_department.','.$mef_department.',null,@result)'));
        $boolean = DB::select(DB::raw('Select @result as result'));
        if ($boolean[0]->result == 1){
            TakeLeaveTempModel::where('created_by',$this->user->id)->whereRaw('DATE_FORMAT("'.$date_dt.'","%Y-%m-%d")')->delete();
            return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => $boolean[0]->result));
        }else{
            return json_encode(array("code" => 0, "message" => "Invalid officer id", "data" => $boolean[0]->result));
        }
    }
    public function postAddCommend(Request $request)
    {
        $date = '';
        $arrTime = explode(" ", $request->date_dt);

        if($request->section==1 && $request->time==1){
            $date = $arrTime[0].' 8:30:00';
        }
        if($request->section==1 && $request->time==2){
            $date = $arrTime[0].' 11:10:00';
        }
        if($request->section==2 && $request->time==1){
            $date = $arrTime[0].' 14:00:00';
        }
        if($request->section==2 && $request->time==2){
            $date = $arrTime[0].' 17:10:00';
        }
        $inData = array(
                'date' =>$date,
                'detail' => $request->note,
                'mef_user_id' =>$request->officer_id,
                'time' => $request->time,
                'section' => $request->section,
                'created_by' => $this->user->id,
                'modify_by' => $this->user->id,
                'created_dt' => date('Y-m-d H:i:s'),
            );

        $qdb = DB::table('mef_user_activity_references')->where('date',$request->date_dt)
            ->where('mef_user_id',$request->officer_id)
            ->where('section',$request->section)
            ->where('time',$request->time);

        if($qdb->count()==0){
            $id = DB::table('mef_user_activity_references')->insertGetId($inData);

            if($id){
                return json_encode(array("code" => 2, "message" =>trans('trans.success'), "data" => $id));
            }
        }
        DB::table('mef_user_activity_references')->where('date',$request->date_dt)
            ->where('mef_user_id',$request->officer_id)
            ->where('section',$request->section)
            ->where('time',$request->time)

            ->update(['detail' => $request->note,'modify_by' => $this->user->id]);
        return json_encode(array("code" => 2, "message" =>trans('trans.success'), "data" => $qdb->get()));

    }
    public function postSave(Request $request)
    {
        $files   = Input::file('pholiday');
        $file_tracker = array('invalid'=>array(),'valid'=>array());
        $array_file = array();
        foreach ($files as $key => $file) {
            $dataExcel = Excel::load($file->getRealPath(), function($reader) {
                $reader->formatDates(true, 'Y-m-d H:i:s');
                $rows = $reader->all()->toArray();
                foreach($rows as $row) {
                    $row['created_by'] = $this->user->id;
                    $row['mef_ministry_id'] = $this->user->mef_ministry_id;
                    $row['mef_general_department_id'] = $this->user->mef_general_department_id;
                    $row['mef_department_id'] = $this->user->mef_department_id;
                    DB::table('mef_temp_user_activity')->insert($row);
                    // $copyDB = DB::select('INSERT mef_user_activity(mef_user_id,date,state,door_name)
                    //     SELECT personnel_id,time,inout_state,event_point_number
                    //     FROM mef_temp_user_activity
                    //     WHERE 
                    //         NOT EXISTS(SELECT *
                    //             FROM mef_user_activity
                    //             WHERE (mef_user_activity.mef_user_id=mef_temp_user_activity.personnel_id
                    //                     and mef_user_activity.date=mef_temp_user_activity.time
                    //                     and mef_user_activity.door_name=mef_temp_user_activity.event_point_number
                    //                     and mef_user_activity.state=mef_temp_user_activity.inout_state
                    //                 )
                    //             )
                    //     ');
                    // DB::table('mef_temp_user_activity')->where('created_by',$this->user->id)->delete();
                }
            })->get();
            /* keep file upload*/   
            $original_name =$file->getClientOriginalName();             
            $filename = $this->store_to_path .str_replace(' ','-',date("Y_m_d_h_i_s")).'.'.pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $upload_success = $file->move($this->store_to_path, $filename);
            
        }
        if(!empty($array_file)){
            DB::table('mef_upload_scan_file')->insert($array_file);
        }
        return json_encode(array("code" => 2, "message" => trans('trans.success'), "data" => $file_tracker));
    }
    public function postDeleteNote(Request $request){
        $del = DB::table('mef_user_activity_references')->where('created_by',$this->user->id)
            ->where('id',$request->id)
            ->delete();
        if($del){
            return array("code" => 2,"message" => trans('attendance.delete_note_sucess'));
        }else{
            return array("code" => 1, "message" => trans('attendance.delete_note_err'));
        }
    }
}
