<?php

namespace App\Models\BackEnd\Mission;
use Illuminate\Support\Facades\DB;
use Config;
use Excel;
use File;
use Storage;
use Input;
use Illuminate\Support\Facades\Mail;
use App\libraries\Tool;
use App\Models\BackEnd\BackEndModel;

class MissionModel extends BackEndModel

{
	protected $table = 'mef_mission';
	public $timestamps = false;

	protected $fillable = [
		"mef_mission_type_id"
		,"mef_role_id"
		,"create_by_user_id"
		,"mef_general_department_id"
		,"mef_department_id"
		,"mission_from_date"
		,"mission_to_date"
		,"mission_location_id"
		,"mission_transportation_id"
		,"reference_no"
		,"reference_date"
		,"approve_by"
		,"signature_by"
		,"signature_position"
	];

    public function __construct()
    {
		$this->messages = Config::get('constant');
		$this->userSession = session('sessionUser');
        $this->Tool = new Tool();
        $this->member = explode(',',$this->userSession->mef_member_id);
        array_push($this->member,$this->userSession->id);

    }

    /* Laravel eloquent */

	public function missionProvince()
	{
		return $this->hasMany('App\Models\BackEnd\Mission\MissionProvince', 'mission_id');
	}
	public function missionOrganization()
	{
		return $this->hasMany('App\Models\BackEnd\Mission\MissionOrganization', 'mission_id');
	}
	public function missionTags()
	{
		return $this->hasMany('App\Models\BackEnd\Mission\MissionTags', 'mission_id');
	}
	public function missionProvinceId()
	{
		return $this->hasMany('App\Models\BackEnd\Province\Province','id','mission_location_id');
	}
	/* Laravel eloquent */

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "mission_from_date";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
		$listDb = DB::table('mef_mission AS mission')
					->leftJoin('mef_mission_type', 'mission.mef_mission_type_id', '=', 'mef_mission_type.id')
					->leftJoin('mef_user', 'mission.create_by_user_id', '=', 'mef_user.id')
					->leftJoin('mef_province', 'mission.mission_location_id', '=', 'mef_province.id')
					->leftJoin('mef_transportation', 'mission.mission_transportation_id', '=', 'mef_transportation.id')
					->select('mission.*','mef_user.user_name as create_by_user', 'mef_mission_type.name as mission_type_name'
						,'mef_province.name_kh as mission_location'
						,'mef_transportation.name_kh as mission_transportation'
					)
					->whereIn('mission.create_by_user_id',$this->member);
		
		$total = count($listDb->get());

		if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
					case 'mission_type_name':
                        $listDb = $listDb->where('mef_mission_type.name','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'mission_from_date' :
						$arrFilterValue = \DateTime::createFromFormat('d/m/Y', $arrFilterValue)->format('Y-m-d');
						$listDb = $listDb->where('mission.mission_from_date','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'mission_to_date' :
						$arrFilterValue = \DateTime::createFromFormat('d/m/Y', $arrFilterValue)->format('Y-m-d');
						$listDb = $listDb->where('mission.mission_to_date','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'create_by_user' :
						$listDb = $listDb->where('mef_user.user_name','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'mission_objective' :
						$listDb = $listDb->where('mission.mission_objective','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'mission_location' :
						$listDb = $listDb->where('mef_province.name_kh','LIKE','%'.$arrFilterValue.'%');
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
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "id"           					=> $row->id,
                "create_by_user_id"   			=> $row->create_by_user_id,
                "mission_type_name"  			=> $row->mission_type_name,
				"mission_from_date"				=> $this->Tool->dateformate($row->mission_from_date,'/'),
				"mission_to_date"				=> $this->Tool->dateformate($row->mission_to_date,'/'),
				"mission_objective"				=> $row->mission_objective,
				"mission_location"				=> $row->mission_location,
				"mission_transportation"		=> $row->mission_transportation,
				"create_by_user"				=> ucfirst($row->create_by_user)
            );
        }
        return json_encode(array('total'=>$total,'data'=>$list));
    }


    public function postSave($data){
      	unset($data['file']);
		$data["mission_from_date"] 	= str_replace('/', '-', $data["mission_from_date"]);
		$data["mission_from_date"] 	= date('Y-m-d', strtotime($data["mission_from_date"]));
		$data["mission_to_date"] 	= str_replace('/', '-', $data["mission_to_date"]);
		$data["mission_to_date"] 	= date('Y-m-d', strtotime($data["mission_to_date"]));
		$data["mef_mission_to_officer"] = array_map('intval', explode(",", $data["mef_mission_to_officer"]));
		// dd($data["mef_mission_to_officer"]);
		$data["mef_meeting_leader_id"] = array_map('intval', explode(",", $data["mef_meeting_leader_id"]));
		/* check_mef_holiday */
		$check_mef_holiday = $this->check_mef_holiday($data);
		if($check_mef_holiday["code"] == 0){
			$data_obj = $check_mef_holiday["data"];
			//$data_error = "មានមន្រ្តីសុំច្បាប់ ៖ ";
			$data_error = "";
			foreach($data_obj as $key=>$val){
				$data_error = $data_error.$val->title;
				$data_error = $data_error."<br>";
			}
			return json_encode(array("code" => 0, "message" => $data_error, "data" => ""));
		}
		/* End check_mef_holiday */
		/* check_mef_mission_join */

		$check_mef_mission_join = $this->check_mef_mission_join($data);
		if($check_mef_mission_join["code"] == 0){
			$data_obj = $check_mef_mission_join["data"];
			$data_error = "";
			foreach($data_obj as $key=>$val){
				$data_error = $data_error.$val->FULL_NAME_KH." បានសុំច្បាប់";
				$data_error = $data_error."<br>";
			}
			return json_encode(array("code" => 0, "message" => $data_error, "data" => ""));
		}
		/* End check_mef_mission_join */
		/* check_mef_meeting */
		$check_mef_meeting = $this->check_mef_meeting($data);
		if($check_mef_meeting["code"] == 0){
			$data_obj = $check_mef_meeting["data"];
			$data_error = "";
			foreach($data_obj as $key=>$val){
				$data_error = $data_error.$val->FULL_NAME_KH." ជាប់កិច្ចប្រជុំ";
				$data_error = $data_error."<br>";
			}
			return json_encode(array("code" => 0, "message" => $data_error, "data" => ""));
		}
		/* End check_mef_meeting */
		$send_email = false;
		$create_by_user_id = $this->userSession->id;
		unset($data['_token']);
		unset($data['ajaxRequestJson']);
		$data['create_by_user_id'] = $create_by_user_id;
		$data['mef_general_department_id'] = $this->userSession->mef_general_department_id;
		$data['mef_department_id'] = $this->userSession->mef_department_id;
		$data['mef_role_id'] = $this->userSession->moef_role_id;
		$mef_mission_to_officer_arr = $data["mef_mission_to_officer"];
		$mef_meeting_leader_id_arr = $data["mef_meeting_leader_id"];

		$mef_province = isset($data["province"])?$data["province"]:null;
		$mef_organization = isset($data["organization"])?$data["organization"]:null;
		$mef_tags = isset($data["tags"])?$data["tags"]:null;

		unset($data['tags']);
		unset($data['province']);
		unset($data['organization']);
		unset($data['mef_mission_to_officer']);
		unset($data['mef_meeting_leader_id']);
        if($data['id'] == 0){
			unset($data['id']);
            /* Save data */
			         $id = DB::table('mef_mission')->insertGetId($data);
            /* End Save data */
        }else{
			$id = $data['id'];
			unset($data['id']);
            DB::table('mef_mission')
				->where('id', $id)
				->update($data);
        }
  		$arr_mission_to_officer = array();
  		$arr_mef_meeting_leader_id = array();
  		foreach($mef_mission_to_officer_arr as $key=>$val){
  			$arr_mission_to_officer[] = array(
  				"mef_mission_id" => $id,
  				"mef_officer_id" => $val
  			);
		  }
		if(sizeof($arr_mission_to_officer)>0){		
			DB::table('mef_mission_to_officer')->where('mef_mission_id',$id)->delete();
			DB::table('mef_mission_to_officer')->insert($arr_mission_to_officer);
		}
		/* init mission leader*/
		foreach($mef_meeting_leader_id_arr as $lkey=>$lval){
			$arr_mef_meeting_leader_id[] = array(
				"mef_mission_id" => $id
				,"officer_id" => $lval
			);
		}
		if(sizeof($arr_mef_meeting_leader_id)>0){				
			DB::table('mef_mission_leader')->where('mef_mission_id',$id)->delete();
			DB::table('mef_mission_leader')->insert($arr_mef_meeting_leader_id);
		}

		/* mission to province*/
		if($mef_province){
			DB::table('mef_mission_province')->where('mission_id',$id)->delete();
			foreach ($mef_province as $p => $province) {
				DB::table('mef_mission_province')->insert(
					[
						'mission_id' 	=>$id
						,'province_id'	=>$province
						,'order'		=>$p
					]
				);
			}
		}

		/* mission to organization*/
		if($mef_organization && sizeof($mef_organization)== sizeof($mef_province)){
			$ind_p = 0;
			DB::table('mef_mission_organization')->where('mission_id',$id)->delete();
			foreach ($mef_organization as $kr => $organizations) {
				foreach ($organizations as $o => $organization) {
					DB::table('mef_mission_organization')->insert(
						[
							'mission_id' 		=>$id
							,'province_id'		=>$mef_province[$ind_p]
							,'organization_id'	=>$organization
							,'order'			=>$p
						]
					);
				}
				$ind_p++;
			}
		}
		/* create mission tags */
		if($mef_tags && is_array($mef_tags)){
			DB::table('mef_mission_tags')->where('mission_id',$id)->delete();
			foreach ($mef_tags as $key => $tag) {
				DB::table('mef_mission_tags')->insert(
					[
						'mission_id' 	=>$id
						,'tags'			=>$tag
					]
				);
			}
		}
		/* send mail by defaul= true*/
  		if($send_email == "true"){
  			$data["mef_mission_to_officer_arr"] = $mef_mission_to_officer_arr;
  			$this->sendEmailMission($id,$data);
  		}

      	$files   = Input::file('file');
      	if($files){
	      	foreach ($files as $key => $file) {
		        $fileName = date('Y-m-d-H-i-s').$key.'.'.$file->getClientOriginalExtension();
		        $getSize = $file->getSize();
		        $getClientOriginalName = $file->getClientOriginalName();
		        $file_extension= $file->getClientOriginalExtension();
		        $file_path  = storage_path('/app/public/uploads/mission/');
		        $file->move($file_path, $fileName);
		        $file_data = array(
					'mef_mission_id' => $id,
					'file_name' => $fileName,
					'file_rename' => $getClientOriginalName,
					'file_extension' => $file_extension,
					'file_path' => '/app/public/uploads/mission/',
					'file_size' => $getSize,
					'file_order' => 0,
					'created_by' => $create_by_user_id,
					'created_dt' => date('Y-m-d H:i:s')
		        );
		        DB::table('mef_mission_attachment')->insert($file_data);
	      	}
      	}
      return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
	private function check_mef_mission_join($data){
		$mission_from_date 	= date('Y-m-d', strtotime($data["mission_from_date"]));
		$mission_to_date 	= date('Y-m-d', strtotime($data["mission_to_date"]));
		$list_mission_to_officer = $data["mef_mission_to_officer"];
		$mef_take_leave_obj = DB::table('mef_take_leave as mef_t')
							->leftJoin('v_mef_officer as v_mef', 'v_mef.Id', '=', 'mef_t.officer_id')
							->select('mef_t.*', 'v_mef.full_name_kh')
							->whereIn('mef_t.officer_id' , $list_mission_to_officer)
							->whereBetween('mef_t.start_dt', [$mission_from_date, $mission_to_date])
							// ->OrWhereBetween('mef_t.end_dt', [$mission_from_date, $mission_to_date])
							->where('mef_t.status',1)
							->where('v_mef.active',1)
							->whereNull('v_mef.approve')
							->groupBy('officer_id')
							->get();

		if(count($mef_take_leave_obj) > 0){
			return array("code" => 0, "message" => "error", "data" => $mef_take_leave_obj);
		}
		return array("code" => 1, "message" => "success", "data" => "");
	}
	private function check_mef_holiday($data){
		$mission_from_date 	= date('Y-m-d', strtotime($data["mission_from_date"]));
		$mission_to_date 	= date('Y-m-d', strtotime($data["mission_to_date"]));
		$mef_holiday_obj = DB::table('mef_holiday')
							->select('mef_holiday.date' , 'mef_holiday.title' , 'mef_holiday.status')
							->whereBetween('mef_holiday.date', [$mission_from_date, $mission_to_date])
							->where('mef_holiday.status', 1)
							->get();
		if(count($mef_holiday_obj) > 0){
			return array("code" => 0, "message" => "error", "data" => $mef_holiday_obj);
		}
		return array("code" => 1, "message" => "success", "data" => "");
	}
	private function check_mef_meeting($data){
		$mission_from_date 	= date('Y-m-d', strtotime($data["mission_from_date"]));
		$mission_to_date 	= date('Y-m-d', strtotime($data["mission_to_date"]));
		$list_mission_to_officer = $data["mef_mission_to_officer"];
		$mef_meeting_obj = DB::table('mef_meeting')
							->join('mef_meeting_atendee_join', 'mef_meeting.Id', '=', 'mef_meeting_atendee_join.mef_meeting_id')
							->join('mef_personal_information', 'mef_meeting_atendee_join.mef_officer_id', '=', 'mef_personal_information.MEF_OFFICER_ID')
							->select('mef_meeting.meeting_date',
									'mef_personal_information.FULL_NAME_KH')
							->whereIn('mef_meeting_atendee_join.mef_officer_id' , $list_mission_to_officer)
							->whereBetween('meeting_date', [$mission_from_date, $mission_to_date])
							->groupBy('mef_meeting_atendee_join.mef_officer_id')
							->get();
		if(count($mef_meeting_obj) > 0){
			return array("code" => 0, "message" => "error", "data" => $mef_meeting_obj);
		}
		return array("code" => 1, "message" => "success", "data" => "");
	}
    public function postDelete($listId){
        foreach ($listId as $id){        	
			DB::table('mef_mission_to_officer')->where('mef_mission_id',$id)->delete();           
            DB::table('mef_mission_leader')->where('mef_mission_id',$id)->delete();
            DB::table('mef_mission_attachment')->where('mef_mission_id',$id)->delete();
         	DB::table('mef_mission_organization')->where('mission_id',$id)->delete();
            DB::table('mef_mission_province')->where('mission_id',$id)->delete();
            DB::table('mef_mission_tags')->where('mission_id',$id)->delete();
            DB::table('mef_mission')->where('id',$id)->delete();
        }
        return array("code" => 1,"message" => trans('trans.success'));
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
                'displayMember' => $row->full_name_kh,
                'valueMember' => $row->Id
            );
        }
        return $arr;
    }
    public function getDataByRowId($id){
        return DB::table('mef_mission as mis')
        	->select('mis.*','mtype.name as title'
        		,'mef_province.name_kh as mission_location'
				,'mef_transportation.name_kh as mission_transportation'
        	)
        	->leftJoin('mef_mission_type as mtype','mis.mef_mission_type_id','=','mtype.id')
        	->leftJoin('mef_province', 'mis.mission_location_id', '=', 'mef_province.id')
			->leftJoin('mef_transportation', 'mis.mission_transportation_id', '=', 'mef_transportation.id')
        	->where('mis.id', $id)->first();
    }
	public function getMissionJoinString($mef_mission_id){
		$string = '';
		$obj = DB::table('mef_mission_to_officer')
                ->where('mef_mission_id', $mef_mission_id)
                ->orderBy('id', 'ASC')
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

	public function getMefOfficerForJoinByOfficeId($office_id){
		$department_id = $this->userSession->mef_department_id;
		$arrList = DB::table('v_mef_officer')
					->select('full_name_kh as displayMember','Id as valueMember')
					->where('department_id',$department_id)
					->whereNull('approve')
					->where('active',1);
					// ->where('is_approve',2);
		if($office_id != 0 && $office_id != null){
			$arrList = $arrList->where('office_id',$office_id);
		}
		$arrList = $arrList->orderBy('position_order','orderNumber', 'DESC')->get();
        $array = array(array("displayMember"=>"", "valueMember" => ""));
		$result = array_merge($array, $arrList);
        return json_encode($result,JSON_UNESCAPED_UNICODE);
	}
	public function getListMissionLeader($mission_id)
	{
		$mission_first = DB::table('mef_mission')->where('id',$mission_id)->first();
		// if($mission_first == null){
		// 	echo "Data have problem";
		// 	exit();
		// }
		$arrList = DB::table('mef_mission_leader as mis_l')
					->join('v_mef_officer as v_mef', 'mis_l.officer_id', '=', 'v_mef.Id')
					->whereNull('approve')
					// ->where('is_approve',2)
					->where('active',1)
					->select('v_mef.full_name_kh','v_mef.position', 'v_mef.Id')
					->where('mis_l.mef_mission_id',$mission_id);
		$arrList = $arrList->OrderBy('v_mef.position_order', 'DESC')->get();
		return $arrList;
	}
	public function getListMissionToOfficer($mission_id){
		$mission_first = DB::table('mef_mission')->where('id',$mission_id)->first();
		if($mission_first == null){
			echo "Data have problem";
			exit();
		}
		$arrList = DB::table('mef_mission_to_officer')
					->leftJoin('v_mef_officer', 'mef_mission_to_officer.mef_officer_id', '=', 'v_mef_officer.Id')
					->select('mef_mission_to_officer.*', 'v_mef_officer.*')
					->where('mef_mission_to_officer.mef_mission_id',$mission_id);
		$arrList = $arrList->OrderBy('v_mef_officer.position_order','v_mef_officer.orderNumber', 'DESC')->get();
		return $arrList;
	}

	public function getListMissionToOfficerExportExcel($mission_id){
		$obj_list = $this->getListMissionToOfficer($mission_id);
		$str = "";
		foreach($obj_list as $key=>$val){
			if(count($obj_list) > ($key + 1) ){
				$str = $str.$val->full_name_kh.', ';
			}else{
				$str = $str.$val->full_name_kh;
			}
		}
		return $str;
	}

	public function checkDataExport($request_all){
		$request_all["start_date"] = str_replace('/', '-', $request_all["start_date"]);
		$request_all["start_date"] = date('Y-m-d', strtotime($request_all["start_date"]));
		$request_all["end_date"] = str_replace('/', '-', $request_all["end_date"]);
		$request_all["end_date"] = date('Y-m-d', strtotime($request_all["end_date"]));
		$data 	= $this->exportMissionData($request_all);
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
		$data 	= $this->exportMissionData($request_all);
		$title_report = 'របាយការណ៏បេសកកម្មប្រចាំ ថ្ងៃទី  '.$this->Tool->khmerDate($request_all['start_date']).' ដល់ ថ្ងៃទី '.$this->Tool->khmerDate($request_all['end_date']);
		$title_department = 'អង្គភាព ៖ '.$this->getDepartmentById()->department_name;
		$officer_name = $request_all["officer_name"];
		if($officer_name != ''){
			$officer_name = "ឈ្មោះ ៖ ".$officer_name;
		}
		Excel::create('export_mission', function($excel) use ($data,$title_report,$title_department,$officer_name) {
			$excel->sheet('excel', function($sheet) use ($data,$title_report,$title_department,$officer_name) {
				$data_cell=array();
				foreach ($data as $key => $values) {
					$data_cell[$key]["ប្រភេទបេសកកម្ម"] = $values->mission_type_name;
					$data_cell[$key]["កាលបរិច្ឆេទចាប់ផ្ដើម"] = $values->mission_from_date;
					$data_cell[$key]["កាលបរិច្ឆេទបញ្ចប់"] = $values->mission_to_date;
					$data_cell[$key]["ទីតាំង"] = $values->mission_location;
					$data_cell[$key]["មធ្យោបាយធ្វើដំណើរ"] = $values->mission_transportation;
					$data_cell[$key]["គោលបំណង"] = $values->mission_objective;
					$data_cell[$key]["មន្រ្តីចុះបេសកកម្ម"] = $this->getListMissionToOfficerExportExcel($values->id);
				}
				$sheet->fromArray($data_cell);
				$sheet->setFontFamily('Khmer MEF1');
				$countDataPlush1 = count($data) + 1;
				$sheet->row(1, function($row) {
					$row->setBackground('#DFF0D8');
				});
				$sheet->cell('A1:A'.($countDataPlush1 ), function($cell) {
					$cell->setAlignment('center');
					$cell->setValignment('center');
				});
				$sheet->setBorder('A1:G'.($countDataPlush1), 'thin');

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
				$sheet->mergeCells('A1:G1','center');
				$sheet->setHeight(1, 30);
				$sheet->mergeCells('A2:G2','center');
				$sheet->setHeight(2, 30);
				/*
				if($officer_name != ''){
					$sheet->mergeCells('A3:G3','center');
					$sheet->setHeight(3, 30);
				}
				*/
				$sheet->cell('A1:G1', function($cell) {
					$cell->setFontFamily('Khmer MEF2');
					$cell->setValignment('center');
				});
				$sheet->cell('A2:G2', function($cell) {
					$cell->setFontFamily('Khmer MEF2');
					$cell->setValignment('center');
				});
				/*
				if($officer_name != ''){
					$sheet->cell('A3:G3', function($cell) {
						$cell->setFontFamily('Khmer MEF2');
						$cell->setValignment('center');
					});
				}
				*/
				$sheet->setBorder('A1:G'.(2), 'thin');
			});
			$excel->getActiveSheet()->getStyle('A1:G'.$excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		})->export('xls');
	}

	function exportMissionData($request_all){
		$start_date = $request_all["start_date"];
		$end_date = $request_all["end_date"];
		$mef_mission_to_officer = $request_all["mef_mission_to_officer"];
		$listDb = DB::table('mef_mission AS mission');
		$listDb = $listDb->join('mef_mission_type', 'mission.mef_mission_type_id', '=', 'mef_mission_type.id');
		if($mef_mission_to_officer != 0){
			$listDb = $listDb->join('mef_mission_to_officer', 'mission.id', '=', 'mef_mission_to_officer.mef_mission_id');
			$listDb = $listDb->join('mef_officer', 'mef_officer.Id', '=', 'mef_mission_to_officer.mef_officer_id');
			$listDb = $listDb->where('mef_officer.Id',$mef_mission_to_officer);
		}
		$listDb = $listDb->select('mission.*', 'mef_mission_type.name as mission_type_name');
		if($this->userSession->moef_role_id != 1){
			$listDb = $listDb->where('mission.mef_role_id',$this->userSession->moef_role_id);
		}
		$listDb = $listDb->where('mission.mission_from_date','>=',$start_date);
		$listDb = $listDb->where('mission.mission_from_date','<=',$end_date);
		$listDb = $listDb->get();
		$data 	= $listDb;
		return $data;
	}

	private function sendEmailMission($mef_mission_id,$data){
		$officer = DB::table('mef_officer')
            ->join('mef_personal_information', 'mef_officer.id', '=', 'mef_personal_information.MEF_OFFICER_ID')
            ->select('mef_personal_information.EMAIL')
			->whereIn('mef_officer.Id',$data["mef_mission_to_officer_arr"])
            ->get();
		$mail_arr = array();
		foreach($officer as $key=>$val){
			$mail_arr[] = $val->EMAIL;
		}
		$data_send = array(
			"list_email" => $mail_arr,
			"data"		 => $data
		);
		if(!empty($mail_arr)){
			Mail::send('email.email_mission', $data_send, function ($m) use ($data_send) {
				$m->from('smartoffice@mef.gov.kh', 'Smart Office Team');
				$m->to($data_send["list_email"])->subject('សូមអញ្ជើញចុះបេសកកម្ម');
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
  public function getAttachmentFile($file_id)
  {
    return DB::table('mef_mission_attachment')->where('mef_mission_id',$file_id)->where('is_active',1)->get();
  }
  public function doDeleteFile($data)
  {
    DB::table('mef_mission_attachment')->where('id', $data['Id'])
    ->update(array('is_active'=>0));
    return array("code"=>1,"message"=>trans('schedule.please_wait'));
  }
  public function getListLocation()
    {
    	$arrList = DB::table('mef_province')
			->select('name_kh as text'
				,'id as value'
			)->orderBy('id', 'DESC')->get();
		if($arrList){
			return $arrList;
		}
		return array(array("text"=>"", "value" => ""));
    }
    public function getListOrganization($id='')
    {
    	$arrList = DB::table('mef_organization')
			->select('name_kh as text'
				,'id as value'
			)->orderBy('id', 'ASC')->get();
		if($arrList){
			return $arrList;
		}
		return array(array("text"=>"", "value" => ""));
    }
    public function getListTransportation($id='')
    {
    	$arrList = DB::table('mef_transportation')
			->select('name_kh as text'
				,'id as value'
			)->orderBy('id', 'ASC')->get();
		if($arrList){
			return $arrList;
		}
		return array(array("text"=>"", "value" => ""));
    }
    public function getListTags($id='')
    {
    	$arrList = DB::table('mef_transportation')
			->select('name_kh as text'
				,'id as value'
			)->orderBy('id', 'ASC')->get();

		if($arrList){
			return $arrList;
		}
		return array(array("text"=>"", "value" => ""));
    }
    
}
?>
