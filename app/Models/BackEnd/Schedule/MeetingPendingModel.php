<?php

namespace App\Models\BackEnd\Schedule;
use Illuminate\Support\Facades\DB;
use Config;
use Excel;
use Illuminate\Support\Facades\Mail;
use App\libraries\Tool;
class MeetingPendingModel
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
			->where('meeting.status',1)
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

	public function approve($meeingId){
		DB::table('mef_meeting')
			->where('Id', $meeingId['Id'])
			->update([
				'status' =>0
			]);
		$meeting_approval = DB::table('mef_meeting_approval')
			->insert([
				'approval_id' =>$this->userSession->id,
				'meeting_id' =>$meeingId['Id'],
				'approval' =>0,
				'create_date' =>date('Y-m-d H:i:s')
			]);
		return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
	}

	public function reject($meeingId){
		DB::table('mef_meeting')
			->where('Id', $meeingId['Id'])
			->update([
				'status' =>2
			]);
		return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
	}

}
?>