<?php

namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
class DoorTrackingModel
{

    public function __construct()
    {
        $this->constant = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
    }
	public function getDataGrid($dataRequest){
		$page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
		$limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
		$sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "dates";
		$order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
		$offset = $page*$limit;
		$filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
		
		$listDb = DB::table('mef_user_activity AS ua')
                ->join('v_mef_officer AS u','ua.mef_user_id','=','u.Id')
				->select(
					'ua.id',
					'ua.detail',
					'ua.time_in',
					'ua.time_out',
					'ua.mef_user_id',
					'ua.type',
                    'f.full_name_kh AS officer_name',
					DB::raw("DATE_FORMAT(ua.dates, '%d/%m/%Y') as dates")
				);
				if($filtersCount==0){
					$today = date('Y-m-d');
					$listDb = $listDb->where('ua.dates',$today);
				}		
		$total = count($listDb->get());
		
		if($filtersCount>0){
			for ($i=0; $i < $filtersCount; $i++) {
				$arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
				$arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
				switch($arrFilterName){
					case 'dates':
						if(!empty($arrFilterValue))
						$listDb = $listDb->where('ua.dates',$arrFilterValue);
						break;
					case 'mef_user_id':
							if(!empty($arrFilterValue))
							$listDb = $listDb->where('ua.mef_user_id',$arrFilterValue);	
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
				"id"           		=>$row->Id,
				"mef_user_id"		=>$row->mef_user_id,
				"officer_name"      =>$row->officer_name,
				"dates"        		=>$row->dates,
				"time_out"  		=>$row->time_out,
				"time_in"           =>$row->time_in,
				"detail"  			=>$row->detail
			);
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }
	
	public function getAllActiveOfficer(){
        $department_id = $this->userSession->mef_department_id != 0 ? $this->userSession->mef_department_id:5;
		$obj = DB::table('v_mef_officer AS f')
			->select('f.Id',
                'f.full_name_kh',
                'f.full_name_en',
                'f.avatar'
            )
			->where('f.is_approve',2)
            ->where('f.department_id',$department_id)
			->orderBy('f.position_order','ASC')
		    ->get();
		$arrList = array(array("text"=>"", "value" => ""));
		foreach($obj as $row){
			$arrList[] = array(
				'value'	=>$row->Id,
				'text'	=>$row->full_name_kh
			);
		}
		return json_encode($arrList);
	}
    
	public function postOfficerIsIn($date,$officer_id,$value_1,$value_2){
    	$listDb = DB::table('mef_user_activity AS ua')
				->select(
					'ua.id',
					'ua.detail',
					'ua.time_in',
					'ua.time_out',
					'ua.mef_user_id',
					'ua.type',
                    'u.FULL_NAME_KH AS mef_user_name',
					DB::raw("DATE_FORMAT(ua.dates, '%d/%m/%Y') as dates")
				)
                ->join('mef_personal_information AS u','ua.mef_user_id','=','u.MEF_OFFICER_ID')
				->where('ua.dates',$date)
				->where(function($query) use ($officer_id){
					if ($officer_id != ''){
						$query->where('ua.mef_user_id', $officer_id);
					}
				})
				->whereBetween('ua.time_in',array($value_1,$value_2))
				->groupBy('ua.mef_user_id')
				->orderBy('ua.dates','ASC')
                ->get();
		return $listDb;
    }

    public function postOfficerIsOut($date,$officer_id,$value_1,$value_2){
    	$listDb = DB::table('mef_user_activity AS ua')
				->select(
					'ua.id',
					'ua.detail',
					'ua.time_in',
					'ua.time_out',
					'ua.mef_user_id',
					'ua.type',
                    'u.FULL_NAME_KH AS mef_user_name',
					DB::raw("DATE_FORMAT(ua.dates, '%d/%m/%Y') as dates")
				)
                ->join('mef_personal_information AS u','ua.mef_user_id','=','u.MEF_OFFICER_ID')
				->where('ua.dates',$date)
				->where(function($query) use ($officer_id){
					if ($officer_id != ''){
						$query->where('ua.mef_user_id', $officer_id);
					}
				})
				->whereBetween('ua.time_out',array($value_1,$value_2))
				->groupBy('ua.mef_user_id')
				->orderBy('ua.dates','ASC')
                ->get();
		return $listDb;
    }
    public function getOfficerDetail($from_date,$to_date,$officer_id,$time_1,$time_2,$type){
        $listDb = DB::table('mef_user_activity AS ua')
            ->select(
                'ua.id',
                'ua.detail',
                'ua.time_in',
                'ua.time_out',
                'ua.mef_user_id',
                'ua.type',
                'u.FULL_NAME_KH AS mef_user_name',
                'u.FULL_NAME_EN',
                DB::raw("DATE_FORMAT(ua.dates, '%d/%m/%Y') as dates")
            )
            ->join('mef_personal_information AS u','ua.mef_user_id','=','u.MEF_OFFICER_ID')
            ->where(function($query) use ($from_date,$to_date,$officer_id,$time_1,$time_2,$type){
                if ($from_date != '' && $to_date != ''){
                    $query->whereBetween('ua.dates',array($from_date,$to_date));
                }else if($from_date != '' && $to_date == ''){
                    $query->where('ua.dates', $from_date);
                }
                if ($officer_id != ''){
                    $query->where('ua.mef_user_id', $officer_id);
                }
                if ($time_1 != '' && $time_2 != ''){
                    if ($type == 'time_in'){
                        $query->whereBetween('ua.time_in', array($time_1,$time_2));
                    }else{
                        $query->whereBetween('ua.time_out', array($time_1,$time_2));
                    }
                }
            })
            ->orderBy('u.FULL_NAME_EN','ASC')
            ->orderBy('ua.dates','DESC')
            ->orderBy('ua.time_in','ASC')
            ->get();
        return $listDb;
    }
    public function countOfficerById($officer_id){
        $listDb = DB::table('mef_user_activity')
                    ->where('mef_user_id',$officer_id)
                    ->select('mef_user_id')
                    ->get()
                    ->count();
        return $listDb;
    }
    public function getMeetingReport($from_date,$to_date,$officer_id){
        $listDb = DB::table('mef_meeting AS m')
                ->join('mef_meeting_atendee_join AS j','j.mef_meeting_id','=','m.Id')
                ->join('mef_personal_information AS personal','j.mef_officer_id','=','personal.MEF_OFFICER_ID')
                ->select(
                    DB::raw("DATE_FORMAT(m.meeting_date, '%d/%m/%Y') as dates"),
                    'm.meeting_time',
                    'personal.FULL_NAME_KH AS mef_user_name',
                    'personal.FULL_NAME_EN',
                    'm.meeting_objective AS detail'
                )
                ->whereBetween('m.meeting_date',array($from_date,$to_date))
                ->where('m.mef_role_id',$this->userSession->moef_role_id)
                ->where(function($query) use ($officer_id){
                    if ($officer_id != ''){
                        $query->where('j.mef_officer_id', $officer_id);
                    }
                })
                ->orderBy('personal.FULL_NAME_EN','ASC')
                ->get();
        return $listDb;
    }

    public function getDepartmentById(){
        $department_id = $this->userSession->mef_department_id != 0 ? $this->userSession->mef_department_id:5;
        $affected_row = DB::table('mef_department AS d')
                ->select('d.Name AS department_name')
                ->where('d.Id',$department_id)
                ->first();
        return $affected_row;
    }
    public function getOfficerById($officer_id){
        $affected_row = DB::table('mef_personal_information')
                ->select('FULL_NAME_KH','FULL_NAME_EN')
                ->where('MEF_OFFICER_ID',$officer_id)
                ->first();
        return $affected_row;
    }
    public function getTotalAttendance($officer_id,$from_date,$end_date,$time_1,$time_2,$type){
        /* Take leave query */
        $leave_sql = DB::table('mef_take_leave AS tl')
					->select(
						'tl.officer_id',
						'p.FULL_NAME_KH AS officer_name',
						DB::raw("SUM(tl.duration) AS total"),
						DB::raw("1 AS `status`")
					)
					->join('mef_personal_information AS p','tl.officer_id','=','p.MEF_OFFICER_ID')
					->groupBy('tl.officer_id')
					->where(function($query) use ($officer_id,$from_date,$end_date){
						if ($officer_id != ''){
							$query->where('tl.officer_id', $officer_id);
						}
						if ($from_date != ''){
							$query->where('tl.started_dt','>=',$from_date);
						}
						if ($end_date != ''){
							$query->where('tl.end_dt','<=',$end_date);
						}
					});
					
		/* Door tracking query */
		$door_sql = DB::table('mef_user_activity AS ua')
					->select(
						'ua.mef_user_id AS officer_id',
						'p.FULL_NAME_KH AS officer_name',
						DB::raw("COUNT(*) AS total"),
						DB::raw("2 AS `status`")
					)
					->join('mef_personal_information AS p','ua.mef_user_id','=','p.MEF_OFFICER_ID')
                    ->groupBy('ua.mef_user_id')
					->where(function($query) use ($from_date,$end_date,$officer_id,$time_1,$time_2,$type){
						if ($officer_id != ''){
							$query->where('ua.mef_user_id', $officer_id);
						}
						if ($from_date != '' && $end_date != ''){
							$query->whereBetween('ua.dates',array($from_date,$end_date));
						}
						if ($time_1 != '' && $time_2 != ''){
                            if ($type == 'time_in'){
                                $query->whereBetween('ua.time_in', array($time_1,$time_2));
                            }else{
                                $query->whereBetween('ua.time_out', array($time_1,$time_2));
                            }
                        }
					});
		/* Finally we combine that query into one */			
		$result = $leave_sql
				->union($door_sql)
				->get();
        return $result;
    }
}
?>