<?php 
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use Excel;
use App\libraries\Tool;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;

use App\Models\BackEnd\Attendance\AttendanceReportModel;
class AttendanceReportController extends BackendController
{
	public function __construct(){
        parent::__construct();
        $this->attendance = new AttendanceReportModel();
        $this->tool = new Tool();
		$this->user = session('sessionUser');
		if(!isset($this->user->mef_general_department_id))
			return array();
		
    }
	
	public function getIndex(){
		$listMinistry = $this->attendance->getAllMinistry();
		$listPosition = $this->attendance->getPosition();
		$listClassRank = $this->attendance->getAllClassRank();
		$this->data['listClassRank'] = json_encode($listClassRank);
		$this->data['totalOfficer'] = $this->constant['mefTotalOfficer'];
		
		$this->data['listPosition'] = json_encode($listPosition);
		$this->data['listMinistry'] = json_encode($listMinistry);
		
		$this->data['listSecretariat'] = json_encode(array(array('value'=>'','text'=>'')));
		$this->data['listDepartment'] = json_encode(array(array('value'=>'','text'=>'')));
		$this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
		$this->data['listOfficer'] = json_encode($this->attendance->getOfficerByOfficeId($this->user->mef_department_id));
		
		return view($this->viewFolder.'.attendance.reports.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
		dd($request->all());
        // return $this->attendance->getDataGrid($request->all());
    }
	public function postNew(Request $request){	
		
		$this->data['mef_general']= $this->postGetSecretaryByMinistryId();
		$this->data['is_group']= '';
		$this->data['text'] = 'សំណើរសុំច្បាប់';
		$this->data['row'] = (object) array('Name'=>'របាយការណ៏ច្បាប់ឈប់សម្រាក');
		if(!isset($request['mef_officer_id'])){
			$this->data['is_group']= 'group';
		}
		$this->data['array'] = $this->attendance->search($request->all());
		$this->data['data'] = $request->all();
		$this->data['total_dt'] = $this->tool->khmerNumber(sizeof($this->data['array']));
		// dd($this->data['array']);
		return view($this->viewFolder.'.attendance.reports.new')->with($this->data);
    }
	
	public function postEdit(Request $request){	
		$this->data['row'] = $this->attendance->getDataByRowId($request['Id']);
		$this->data['attendanceViewer']= $this->attendance->getAttendanceViewer($this->user->mef_general_department_id);
		// dd($this->data['row']);
		return view($this->viewFolder.'.attendance.type.new')->with($this->data);
    }
	
	public function postGetDepartmentBySecretariatId(Request $request){
		$secretariatId = intval($request->secretariatId);
		$records = $this->attendance->getAllDepartmentBySecretariatId($secretariatId);
		return ($records);
		
	}
	public function postSave(Request $request){
		// dd($request->all());
        return $this->attendance->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->attendance->postDelete($listId);
    }
	public function getDelete($id){
        // $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->attendance->postDelete(1);
    }
	
	public function postGetSecretaryByMinistryId($ministryId=''){
		$this->data['listSecretariat'] = $this->attendance->getAllSecretariatByMinistry($ministryId);
		return $this->data['listSecretariat'];
	}
	public function postGetDepartmentBySecretaryId(Request $request){
		$secretaryId = intval($request->secretaryId);
		$this->data['listSecretariat'] = $this->attendance->getDepartmentBySecretariatId($secretaryId);
		return $this->data['listSecretariat'];
	}
	public function postGetOfficeByDepartmentId(Request $request){
		$departmentId = intval($request->departmentId);
		$this->data['listOffice'] = $this->attendance->getOfficeByDepartmentId($departmentId);
		return $this->data['listOffice'];
	}
	public function postGetOfficeByOfficeId(Request $request){
		$departmentId = '';
		$officeId = intval($request->officeId);
		if($officeId ==0){
			$departmentId = $this->user->mef_department_id;
		}
			
		$this->data['listOfficer'] = $this->attendance->getOfficerByOfficeId($officeId,$departmentId);
		return $this->data['listOfficer'];
	}
	
	public function postExport(Request $request){
		// dd($request->all());
		$filename = 'របាយការណ៍ច្បាប់ឈប់សម្រាក'.date("Y-m-d h-i-s");
		$data['is_group']= '';
		$data['text'] = 'សំណើរសុំច្បាប់';
		$data['row'] = (object) array('Name'=>'របាយការណ៍ច្បាប់ឈប់សម្រាក');
		if(!isset($request['mef_officer_id']) || $request['mef_officer_id'] ==''){
			$data['is_group']= 'group';
		}
		$data['array'] = $this->attendance->search($request->all());
		// dd($data['array'] );
		Excel::create($filename, function($excel) use ($data) {

			$excel->sheet('របាយការណ៍ច្បាប់ឈប់សម្រាក', function($sheet) use ($data) {
				$data_cell=array();
				foreach ($data['array'] as $key => $values) {
					// $dob = $values->started_dt != NULL ? date('d/m/Y',strtotime($values->started_dt)):'';
					$title = $data['is_group'] == 'group' ?  'ចំនួនថ្ងៃឈប់': 'ថ្ងៃឈប់';
					$data_cell[$key]["ល.រ"] = $key+1;
					$data_cell[$key]["គោត្តនាម-នាម"] = $values->FULL_NAME_KH;
					$data_cell[$key]["ជាអក្សរឡាតាំង"] = $values->FULL_NAME_EN;
					$data_cell[$key]["លេខទូរស័ព្ទ"] = $values->PHONE_NUMBER_1;
					$data_cell[$key]["ការិយាល័យ"] = $values->mef_office;
					$data_cell[$key]["ចំនួនថ្ងៃឈប់"] = $data['is_group'] == 'group' ? $values->total_dt.'ថ្ងៃ' :'1 ថ្ងៃ';
				}
				$sheet->fromArray($data_cell);
				$sheet->setFontFamily('Khmer MEF1');
				$countDataPlush1 = count($data['array']) + 1;
				$sheet->setBorder('A1:F'.$countDataPlush1, 'thin');
			});

		})->export('xlsx');
		// })->save('xls',storage_path('excel/reports'));
        
	}
	public function getExport(){
		
		$data = array(); 
        $title = 'my report';
		
        // Excel::load('public/files/reports/take_leave.xls'), function($file) use($title, $data){
		$data = Excel::load('public/files/reports/export_schedule.xls', function($reader) {

			// Getting all results
			// $results = $reader->get();

			// ->all() is a wrapper for ->get() and will work the same
			$results = $reader;
			// var_dump($reader->reader);
			// $results->each(function($sheet) {
				// var_dump($sheet);
				// Loop through all rows
				// $sheet->each(function($row) {
					// var_dump($row);
				// });

			// });
			foreach($results as $key => $value){
				
				// var_dump($value);
				
			};
		}, 'UTF-8');
		dd($data->reader->_phpSheet);
		 
		// return $this->attendance->export($request->all());
	}
	
}