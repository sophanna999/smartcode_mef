<?php
namespace App\Models\BackEnd\Attendance;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Config;

class OfficerCheckinReportModel
{

	public function __construct()
	{
		$this->constant = Config::get('constant');
		$this->table = Config::get('table');
		$this->userSession = session('sessionUser');
	}

	public function getDataGrid($dataRequest)
	{
		$page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
		$limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
		$sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "FULL_NAME_KH";
		$order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
		$offset = $page * $limit;
		$filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;

		$year = date('Y');
		$sql = DB::table('mef_officer as a')
			->leftJoin('mef_personal_information as b','b.MEF_OFFICER_ID','=','a.Id');
		if($filtersCount>0){
			for ($i=0; $i < $filtersCount; $i++) {
				$arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
				$arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
				switch($arrFilterName){
					case 'FULL_NAME_KH':
						$sql->where('FULL_NAME_KH','LIKE','%'.$arrFilterValue.'%');
						break;
					case 'date':
						$year = ($arrFilterValue=="")?$year:$arrFilterValue;

						break;
					default:
						#Code...
						break;
				}
			}
			$total = count($sql->get());
		}
		$total = count($sql->get());

		$mef_user = $sql
			->limit($limit)
			->offset($offset)
			->get();

		$data = [];
		$months = [1,2,3,4,5,6,7,8,9,10,11,12];

		if (!empty($mef_user)){
			foreach ($mef_user as $user){
				$row = array(
					'Id' => $user->Id,
					'FULL_NAME_KH' => $user->FULL_NAME_KH,
				);
				
				$total_absence = 0;
				$permission = 0;
				$no_permission = 0;
				$late = 0;
				foreach ($months as $v){
					$total_absence_of_month = 0;
					$absences = $this->countAbsence($user->Id, $year, $v);
					if (!empty($absences)){
						foreach ($absences as $absence)
						$total_absence += $absence->day;
						$permission += $absence->permission;
						$no_permission += $absence->absence;
						$late += $absence->late;
						$total_absence_of_month +=$absence->day;
					}
					$row[$v] = $total_absence_of_month;
				}
				$row['permission'] = $permission;
				$row['no_permission'] = $no_permission;
				$row['total_absence'] = $total_absence;
				$row['late'] = $late;
				$data[] = $row;
			}
		}
		return json_encode(array('total' => $total, 'items' => $data));
	}

	public function countAbsence($user_id, $year, $month){
		$return = null;
		$row = DB::table('mef_officer_attendance')
			->where('officer_id',$user_id)
			->whereMonth('date', '=', $month)
			->whereYear('date', '=',$year)
			->get();
		if ($row) {
			$return = $row;
		}
		return $return;
	}

	public function getUsernameById($id)
	{
		$return = '';
		$sql = DB::table('mef_officer as a')
			->where('a.Id', $id)
			->leftJoin('mef_personal_information as b','b.MEF_OFFICER_ID','=','a.Id');
		$data = $sql->first();
		if ($data!=null){
			$return = $data->FULL_NAME_KH;
		}
		return $return;
	}


	public function getDayOfMonth($year, $month, $user_id){
		$sql = DB::table('mef_user_activity')
			->select(DB::raw('YEAR(date) year, MONTH(date) month, DAY(date) day, date' ))
			->where('mef_user_id',$user_id)
			->whereMonth('date', '=', $month)
			->whereYear('date', '=',$year)
			->groupBy('day')
			->get();
		return $sql;
	}
	public function getDataDetailGrid($input){
		$year = date('Y');
		$months = [1,2,3,4,5,6,7,8,9,10,11,12];
		$return = [];
		foreach ($months as $month){
			$days = $this->getDayOfMonth($year, $month,$input['id']);
			if (!empty($days)){
				$row = [];
				foreach ($days as $day){
					$morning = DB::select('call get_min_max_date(?,?,?)', array($input['id'],$day->date,1));
					$evening = DB::select('call get_min_max_date(?,?,?)', array($input['id'],$day->date,2));
					$row = [
						'month'=>$month,
						'day'=>$day->day,
						'morning_in'=>isset($morning[0])?date('H:i:s',strtotime($morning[0]->date)):'',
						'morning_out'=>isset($morning[1])?date('H:i:s',strtotime($morning[1]->date)):'',
						'evening_in'=>isset($evening[0])?date('H:i:s',strtotime($evening[0]->date)):'',
						'evening_out'=>isset($evening[1])?date('H:i:s',strtotime($evening[1]->date)):''
					];
					$return[] = $row;
				}
			}
		}
		return $return;
	}
}