<?php 
namespace App\Http\Controllers\BackEnd\Report;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Report\ReportModel;
use Config;
use Excel;
class ReportController extends BackendController {

    public function __construct()
    {
        parent::__construct();
		$this->constant = Config::get('constant');
        $this->report = new ReportModel();
    }

    public function getIndex()
    {
		$listMinistry = $this->report->getAllMinistry();
		$listPosition = $this->report->getPosition();
		$listClassRank = $this->report->getAllClassRank();
		$this->data['listClassRank'] = json_encode($listClassRank);
		$this->data['totalOfficer'] = $this->constant['mefTotalOfficer'];
		
		$this->data['listPosition'] = json_encode($listPosition);
		$this->data['listMinistry'] = json_encode($listMinistry);
		$this->data['listSecretariat'] = json_encode(array(array('value'=>'','text'=>'')));
		$this->data['listDepartment'] = json_encode(array(array('value'=>'','text'=>'')));
		$this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
		
        return view($this->viewFolder.'.report.index')->with($this->data);
    }
	public function postIndex(Request $request){
		return $this->postSearch($request);
    }
	public function postGetDetail(Request $request){
		return $this->postSearch($request);
	}
	public function postDetail(Request $request){//dd($request->all());
		$row = array();
		$array = array();
		$text = '';
		switch($request->type){
			case '1':
				/*Ministry*/
				$text = 'ក្រសួង/ស្ថាប័ន';
				$row = $this->report->getRecordById('mef_ministry',$request->Id);
				$array = $this->report->getOfficerByMinistryId($request->Id);
			break;
			case '2':
				/*Secretariat*/
				$text = 'អគ្គនាយកដ្ឋាន';
				$row = $this->report->getRecordById('mef_secretariat',$request->Id);
				$array = $this->report->getOfficerBySecretariatId($request->mef_department_id,$request->mef_office_id,$request->class_rank_id,$request->Id);
			break;
			case '3':
				/*Department*/
				$text = 'នាយកដ្ឋាន';
				$row = $this->report->getRecordById('mef_department',$request->Id);
				$array = $this->report->getOfficerByDepartmentId($request->mef_secretariat_id,$request->mef_office_id,$request->class_rank_id,$request->Id);
			break;
			case '4':
				/*Office*/
				$text = 'ការិយាល័យ';
				$row = $this->report->getRecordById('mef_office',$request->Id);
				$array = $this->report->getOfficerByOfficeId($request->mef_secretariat_id,$request->mef_department_id,$request->class_rank_id,$request->Id);
			break;
			case '5':
				/*Position*/
				$text = 'មុខតំណែង/តួនាទី';
				$row = $this->report->getPositionById($request->Id);
				$array = $this->report->getOfficerByPositionId($request->mef_secretariat_id,$request->mef_department_id,$request->mef_office_id,$request->class_rank_id,$request->Id);
			break;
			case '6':
				/*Class rank*/
				$text = 'ក្របខ័ណ្ឌឋានន្តរស័ក្តិ និងថ្នាក់';
				$row = $this->report->getRecordById('mef_class_ranks',$request->Id);
				$array = $this->report->getOfficerByClassRankId($request->mef_secretariat_id,$request->mef_department_id,$request->mef_office_id,$request->mef_position_id,$request->Id);
			break;
			case '7':
				/*DoB*/
				$day = substr($request->Id,6);
				$month = substr($request->Id,4,2);
				$year = substr($request->Id,0,4);
				$dob = $year.'-'.$month.'-'.$day;
				$str_dob = date('d/m/Y',strtotime($year.'-'.$month.'-'.$day));
				$text = 'ឆ្នាំកំណើត';
				$name = array('Name'=>$year);
				$row = (object)$name;
				$array = $this->report->getOfficerByDoB($request->mef_secretariat_id,$request->mef_department_id,$request->mef_office_id,$request->mef_position_id,$request->class_rank_id,$year);
			break;
		}
		$this->data['text'] = $text;
		$this->data['row'] = $row;
		$this->data['array'] = $array;
		$this->data['request_post'] = $request->all();
		return view($this->viewFolder.'.report.detail')->with($this->data);
	}
	public function postDetailExport(Request $request){
		$row = array();
		$array = array();
		$text = '';
		switch($request->type){
			case '1':
				/*Ministry*/
				$text = 'ក្រសួង/ស្ថាប័ន';
				$row = $this->report->getRecordById('mef_ministry',$request->Id);
				$array = $this->report->getOfficerByMinistryId($request->Id);
			break;
			case '2':
				/*Secretariat*/
				$text = 'អគ្គនាយកដ្ឋាន';
				$row = $this->report->getRecordById('mef_secretariat',$request->Id);
				$array = $this->report->getOfficerBySecretariatId($request->mef_department_id,$request->mef_office_id,$request->class_rank_id,$request->Id);
			break;
			case '3':
				/*Department*/
				$text = 'នាយកដ្ឋាន';
				$row = $this->report->getRecordById('mef_department',$request->Id);
				$array = $this->report->getOfficerByDepartmentId($request->mef_secretariat_id,$request->mef_office_id,$request->class_rank_id,$request->Id);
			break;
			case '4':
				/*Office*/
				$text = 'ការិយាល័យ';
				$row = $this->report->getRecordById('mef_office',$request->Id);
				$array = $this->report->getOfficerByOfficeId($request->mef_secretariat_id,$request->mef_department_id,$request->class_rank_id,$request->Id);
			break;
			case '5':
				/*Position*/
				$text = 'មុខតំណែង/តួនាទី';
				$row = $this->report->getPositionById($request->Id);
				$array = $this->report->getOfficerByPositionId($request->mef_secretariat_id,$request->mef_department_id,$request->mef_office_id,$request->class_rank_id,$request->Id);
			break;
			case '6':
				/*Class rank*/
				$text = 'ក្របខ័ណ្ឌឋានន្តរស័ក្តិ និងថ្នាក់';
				$row = $this->report->getRecordById('mef_class_ranks',$request->Id);
				$array = $this->report->getOfficerByClassRankId($request->mef_secretariat_id,$request->mef_department_id,$request->mef_office_id,$request->mef_position_id,$request->Id);
			break;
			case '7':
				/*DoB*/
				$day = substr($request->Id,6);
				$month = substr($request->Id,4,2);
				$year = substr($request->Id,0,4);
				$dob = $year.'-'.$month.'-'.$day;
				$str_dob = date('d/m/Y',strtotime($year.'-'.$month.'-'.$day));
				$text = 'ឆ្នាំកំណើត';
				$name = array('Name'=>$year);
				$row = (object)$name;
				$array = $this->report->getOfficerByDoB($request->mef_secretariat_id,$request->mef_department_id,$request->mef_office_id,$request->mef_position_id,$request->class_rank_id,$year);
			break;
		}
		$this->data['text'] = $text;
		$this->data['row'] = $row;		
		$data 	= $array;
		// Export Excel
		Excel::create('report', function($excel) use ($data) {			
			$excel->sheet('excel', function($sheet) use ($data) {
				$data_cell=array();
				foreach ($data as $key => $values) {
					$dob = $values->DATE_OF_BIRTH != NULL ? date('d/m/Y',strtotime($values->DATE_OF_BIRTH)):'';
					$data_cell[$key]["ល.រ"] = $key + 1;
					$data_cell[$key]["គោត្តនាម-នាម"] = $values->FULL_NAME_KH;
					$data_cell[$key]["ជាអក្សរឡាតាំង"] = $values->FULL_NAME_EN;
					$data_cell[$key]["លេខទូរស័ព្ទ"] = $values->PHONE_NUMBER_1;
					$data_cell[$key]["អ៊ីម៉ែល"] = $values->EMAIL;
					$data_cell[$key]["ថ្ងៃខែឆ្នាំកំណើត"] = $dob;
				}
				$sheet->fromArray($data_cell);
				$sheet->setFontFamily('Khmer MEF1');
				$countDataPlush1 = count($data) + 1;
				$sheet->setBorder('A1:F'.$countDataPlush1, 'thin');
				$sheet->row(1, function($row) {
					$row->setBackground('#DFF0D8');
				});
				// Add before first row
				$sheet->prependRow(1, array(
					$this->data['text'] . chr(10) . $this->data['row']->Name
				));
				$sheet->mergeCells('A1:F1','center');
				$sheet->setHeight(1, 60); 
				$sheet->cell('A1:F1', function($cell) {
					$cell->setFontFamily('Khmer MEF2');
					$cell->setValignment('center');
				});
				$sheet->cell('A2:A'.($countDataPlush1 +1 ), function($cell) {
					$cell->setAlignment('center');
				});
			});
			$excel->getActiveSheet()->getStyle('A1:F'.$excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		})->export('xls');
	}
	public function postSearch(Request $request){
		$result = array();
		$arraySecretarait = array();
		$arrayDepartment = array();
		$arrayOffice = array();
		$arrayPosition = array();
		$arrayClassRank = array();
		$arrayDoB = array();
		$mef_ministry_id = $request->mef_ministry_id;
		$mef_secretariat_id = $request->mef_secretariat_id;
		$mef_department_id = $request->mef_department_id;
		$mef_office_id = $request->mef_office_id;
		$mef_position_id = $request->mef_position_id;
		$class_rank_id = $request->class_rank_id;
		$from_dob = '';
		$to_dob = '';
		$remainingOfficer = array();
		
		if($request->from_dob != '' && $request->to_dob != ''){
			$date_1 = explode('/',$request->from_dob);
			$date_2 = explode('/',$request->to_dob);
			$from_dob = $date_1[2].'-'.$date_1[1].'-'.$date_1[0];
			$to_dob = $date_2[2].'-'.$date_2[1].'-'.$date_2[0];
		}
		
        $arrayMinistry = $this->report->postTotalMinistry($mef_ministry_id);
		$arraySecretarait = $this->report->postTotalSecretariat($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id);
		$arrayDepartment = $this->report->postTotalDepartment($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id);
		$arrayOffice = $this->report->postTotalOffice($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id);
		$arrayPosition = $this->report->postTotalPosition($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id);
		$arrayClassRank = $this->report->postTotalClassRank($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id);
		$arrayDoB = $this->report->postTotalDoB($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id,$from_dob,$to_dob);
		
		$result = $arrayMinistry;
		if($mef_ministry_id != ''){
			if($mef_secretariat_id !='' && $mef_department_id !='' && $mef_office_id !='' && $mef_position_id !='' && $class_rank_id !='' && $from_dob != ''){
				$amount = $arrayDoB != NULL ? $arrayDoB[0]['dataField']:0;
				$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
				);
				$result = array_merge($remainingOfficer,$arrayDoB);
			}else if($mef_secretariat_id !='' && $mef_department_id !='' && $mef_office_id !='' && $mef_position_id !='' && $class_rank_id !=''){
				$amount = $arrayClassRank != NULL ? $arrayClassRank[0]['dataField']:0;
				$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
				);
				$result = array_merge($arrayMinistry,$arrayClassRank);
			}else if($mef_secretariat_id !='' && $mef_department_id !='' && $mef_office_id !='' && $mef_position_id !=''){
				$amount = $arrayPosition != NULL ? $arrayPosition[0]['dataField']:0;
				$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
				);
				$result = array_merge($remainingOfficer,$arrayPosition);
			}else if($mef_secretariat_id !='' && $mef_department_id !='' && $mef_office_id !='' && $class_rank_id !=''){
				$amount = $arrayClassRank != NULL ? $arrayClassRank[0]['dataField']:0;
				$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
				);
				$result = array_merge($remainingOfficer,$arrayClassRank);
			}else if($mef_secretariat_id !='' && $mef_department_id !='' && $mef_office_id !=''){
				if($mef_position_id !=''){
					$amount = $arrayClassRank != NULL ? $arrayPosition[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayPosition);
				}else if($class_rank_id !=''){
					$amount = $arrayClassRank != NULL ? $arrayPosition[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayClassRank);
				}else if($request->from_dob != ''){
					$amount = $arrayDoB != NULL ? $arrayDoB[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayDoB);
				}else{
					$amount = $arrayOffice != NULL ? $arrayOffice[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayOffice);
				}
			}else if($mef_secretariat_id !='' && $mef_department_id !=''){
				if($mef_position_id !=''){
					$amount = $arrayPosition != NULL ? $arrayPosition[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayPosition);
				}else if($class_rank_id !=''){
					$amount = $arrayClassRank != NULL ? $arrayClassRank[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayClassRank);
				}else if($request->from_dob != ''){
					$amount = $arrayClassRank != NULL ? $arrayDoB[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayDoB);
				}else{
					$amount = $arrayDepartment != NULL ? $arrayDepartment[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayDepartment);
				}			
			}else if($mef_secretariat_id !=''){
				if($mef_position_id !=''){
					$amount = $arrayPosition != NULL ? $arrayPosition[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayPosition);
				}else if($class_rank_id !=''){
					$amount = $arrayClassRank != NULL ? $arrayClassRank[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayClassRank);
				}else if($request->from_dob != ''){
					$amount = $arrayDoB != NULL ? $arrayDoB[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arrayDoB);
				}else{
					$amount = $arraySecretarait != NULL ? $arraySecretarait[0]['dataField']:0;
					$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
					$result = array_merge($remainingOfficer,$arraySecretarait);
				}
				
			}else if($mef_position_id !=''){
				$amount = $arrayPosition != NULL ? $arrayPosition[0]['dataField']:0;
				$remainingOfficer[] = array(
						"Id"			=>$arrayMinistry[0]['Id'],
						"Type"			=>1,
						"displayText"  	=>$arrayMinistry[0]['displayText'],
						"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
					);
				$result = array_merge($remainingOfficer,$arrayPosition);
			}else if($class_rank_id !=''){
				$amount = $arrayClassRank != NULL ? $arrayClassRank[0]['dataField']:0;
				$remainingOfficer[] = array(
					"Id"			=>$arrayMinistry[0]['Id'],
					"Type"			=>1,
					"displayText"  	=>$arrayMinistry[0]['displayText'],
					"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
				);
				$result = array_merge($remainingOfficer,$arrayClassRank);
			}else if($request->from_dob != ''){
				$amount = $arrayDoB != NULL ? $arrayDoB[0]['dataField']:0;
				$remainingOfficer[] = array(
					"Id"			=>$arrayMinistry[0]['Id'],
					"Type"			=>1,
					"displayText"  	=>$arrayMinistry[0]['displayText'],
					"dataField"  	=>intval($this->constant['mefTotalOfficer'] - $amount),
				);
				$result = array_merge($remainingOfficer,$arrayDoB);
			}
		}
		return json_encode($result);
	}
	public function postGetSecretaryByMinistryId(Request $request){
		$ministryId = intval($request->ministryId);
		$this->data['listSecretariat'] = $this->report->getAllSecretariatByMinistry();
		return $this->data['listSecretariat'];
	}
	public function postGetDepartmentBySecretaryId(Request $request){
		$secretaryId = intval($request->secretaryId);
		$this->data['listSecretariat'] = $this->report->getDepartmentBySecretariatId($secretaryId);
		return $this->data['listSecretariat'];
	}
	public function postGetOfficeByDepartmentId(Request $request){
		$departmentId = intval($request->departmentId);
		$this->data['listOffice'] = $this->report->getOfficeByDepartmentId($departmentId);
		return $this->data['listOffice'];
	}
	
	
    
}
