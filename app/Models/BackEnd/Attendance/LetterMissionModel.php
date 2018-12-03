<?php

namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Facades\Validator;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\BackEnd\BackEndModel;

class LetterMissionModel extends BackEndModel

{
	protected $table = 'mef_take_mission_letter';
    public function __construct()
    {
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
		$this->member = explode(',',$this->userSession->mef_member_id);
		array_push($this->member,$this->userSession->id);
    }

	public function postSave($data){
		$files = isset($data['file'])?$data['file']:array();
		$meetingDate = $data['meeting_date'];
		$date = str_replace('/', '-', $meetingDate);
		$meeting_date = date('Y-m-d', strtotime($date));
		
		$time24 = date('H:i:s', strtotime($data['meeting_time']));
		$indata= array(
				'officer_id' => $data['mef_meeting_atendee_join']
				,'date_time' =>$meeting_date
				,'start_time' =>$data['meeting_time']
				,'start_time_24' =>$time24
				,'end_time' =>$data['meeting_end_time']
				,'end_time_24' =>date('H:i:s', strtotime($data['meeting_end_time']))
				,'status' =>isset($data['public'])?1:1
				,'created_dt' =>date("Y-m-d H:i:s")
				,'created_by' =>$this->userSession->id
				,'reason' =>$data['meeting_objective']
				,'location' =>$data['meeting_location']
			);
		/* validate file */
		if(isset($data['Id']) && $data['Id'] >0){			
			$file_image = DB::table('mef_take_mission_letter_file')->where('mission_letter_id',$data['Id'])->count();
			if($file_image==0){
				return json_encode(array("code" => 0, "message" => trans('attendance.please_select_file'), "data" => ''));
			}
		}else{
			if(sizeof($files)<=0){
				return json_encode(array("code" => 0, "message" => trans('attendance.please_select_file'), "data" => ''));
			}
		}	
		if(isset($data['Id']) && $data['Id'] >0){
			$insert_id​ = $data['Id'];
			DB::table('mef_take_mission_letter')
				->where('Id', $data['Id'])
				->update($indata);
				
		}else{
			
			$insert_id = DB::table('mef_take_mission_letter')->insertGetId($indata);
			
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
					$destinationPath = 'files/mission_letter/';                    
					$filename = $destinationPath .str_replace(' ','-',date("Y_m_d_h_i_s")).'.'.pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
					$upload_success = $file->move($destinationPath, $filename);
					$original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					if(!empty($insert_id)){
						DB::table('mef_take_mission_letter_file')->insert(
							array(
								'mission_letter_id' =>$insert_id
								,'file_name'		=>$file->getClientOriginalName()
								,'ftp_file_name' =>$filename
								,'file_path' =>$destinationPath
								,'status' =>1
								,'created_dt' =>date("Y-m-d H:i:s")
								,'updated_dt' =>date("Y-m-d H:i:s")
								,'created_by' =>$this->userSession->id
							)
						);
					}
					// Flash a message and return the user back to a page...
				} else {
					// return array("code" => 5,"message" => trans('attendance.succe_insert'),"data"=>'error file');
				}
				
			}
		}
		return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
	}
	public function getMissionFile($miss_id)
	{
		return $list_db = DB::table('mef_take_mission_letter_file')->where('status',1)->where('mission_letter_id',$miss_id)->get();
	}
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "date_time";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;

		$listDb = $this->getDataByRowId();                   
		$listDb =$listDb->whereIn('meeting.created_by',$this->member)
					->orderBy('meeting.date_time','DESC');
		$total = count($listDb->get());
        
		if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
					case 'location':
                        $listDb = $listDb->where('meeting.meeting_location','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'reason':
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
	public function getDataByRowId($id=null){
		$listData = DB::table('mef_take_mission_letter AS meeting')
					
					->leftJoin('mef_user', 'meeting.created_by', '=', 'mef_user.id')
					->select(
						'meeting.Id',
						'meeting.officer_id',
						'meeting.created_by',
						'meeting.date_time',
						DB::raw('get_date_khmer(meeting.date_time) as meeting_date'),
						'meeting.start_time',
						'meeting.start_time_24',
						'meeting.end_time',
						'meeting.end_time_24',
						'meeting.reason',
						'meeting.location',
						
						'meeting.status',						
						'mef_user.user_name AS create_by_user'
					); 
		if($id!=null){
			return $listData = $listData->where('meeting.Id',$id);
		}
		return $listData;
	}
	public function postDelete($Id){
        $is_delete = DB::table('mef_take_mission_letter')->whereIn('Id', $Id)->delete();
		return array("code" => 1,"message" => trans('trans.success'));
	}
	public function doDeleteFile($data)
	{
	  DB::table('mef_take_mission_letter_file')->where('id', $data['Id'])
	  	->update(array('status'=>0));
	  return array("code"=>1,"message"=>trans('schedule.please_wait'));
	}
}