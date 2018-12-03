<?php 
namespace App\Http\Controllers\BackEnd\SpecialDays;
use App\Http\Controllers\BackendController;
use Excel;
use Config;
use Input;
use Illuminate\Http\Request;
use App\libraries\Tool;
use Illuminate\Support\Facades\DB;
use App\Models\BackEnd\SpecialDays\SpecialDaysModel;


class SpecialDaysController extends BackendController
{
	public function __construct(){
        parent::__construct();
		$this->viewFolder;
		$this->messages = Config::get('constant');
        $this->specialDays = new SpecialDaysModel();
		$this->user = session('sessionUser');
		if(!isset($this->user->mef_general_department_id))
			return array();
		
    }
	
	public function getIndex(){
		return view($this->viewFolder.'.special-days.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
		
        return $this->specialDays->getDataGrid($request->all());
    }
	public function postNew(Request $request){	
		$this->data['department'] = json_encode($this->specialDays->getDepartment());
		$this->data['office'] = json_encode($this->specialDays->getMultiSelectOffice(0));
		$this->data["getOffice"] = json_encode(array());
		$this->data["list_officer"] = json_encode($this->specialDays->getMultiSelectOfficer(0));
		// dd($this->data['office']);
		$this->data["getOfficer"] = json_encode(array());
		return view($this->viewFolder.'.special-days.new')->with($this->data);
    }
	
	public function postEdit(Request $request){	
		$this->data['row'] = DB::table('v_specialDays')->where('Id', $request->Id)->first();
		// dd($this->data['row']);
		$this->data['office'] = json_encode($this->specialDays->getMultiSelectOffice($this->data['row']->departmentId));
		$this->data["getOffice"] = json_encode($this->specialDays->getOfficeById($this->data['row']->specialDayId));
		
		if($this->data['row']->status == 1){
			$this->data["list_officer"] = json_encode($this->specialDays->getMultiSelectOfficer(0));
			$this->data["getOfficer"] = json_encode(array());
		}else{
			$this->data["list_officer"] = json_encode($this->specialDays->getMultiSelectOfficer($this->data['row']->officeId));
			$this->data["getOfficer"] = json_encode($this->specialDays->getOfficerById($this->data['row']->specialDayId));
		}
		// dd($this->data["getOfficer"]);
		$this->data['department'] = json_encode($this->specialDays->getDepartment());
		// $this->data["getOfficer"] = json_encode($this->specialDays->getSubjectTeacher($this->data['id']));
		
		return view($this->viewFolder.'.special-days.new')->with($this->data);
    }

    public function postGetOffice(Request $request){

        $departmentId = intval($request->departmentId);
        $this->data['office'] = $this->specialDays->getMultiSelectOffice($departmentId);
        return $this->data['office'];
    }

    public function postGetOfficer(Request $request){

        $officeId = intval($request->officeId);
        $this->data['officer'] = $this->specialDays->getMultiSelectOfficer($officeId);
        return $this->data['officer'];
    }
	
	public function postSave(Request $request){
		$data = $request->all();	
		// dd($data['specialday']['date']);
		$date = str_replace('/', '-', $data['specialday']['date']);		
		$data['specialday']['date'] = date('Y-m-d', strtotime($date));

		$officer = isset($data['sub']['officerId']) ? $data['sub']['officerId']:'';
    	$list_officer = array_map('intval',explode(',',$officer));

    	$office = isset($data['sub']['officeId']) ? $data['sub']['officeId']:'';
    	$list_office = array_map('intval',explode(',',$office));
	// dd($data['Id']);
		if($request->Id==0){
			/* Save data */
			// $result = DB::table('mef_specialday')->where('date', $data['specialday']['date'])->count();
			
			// if($result >0){
			// 	return json_encode(array("code" => 0, "message" => "មិនអនុញ្ញាតឲ្យបញ្ចូលទិន្នន័យស្ទួន សូមធ្វើការបន្ថែមឬកែប្រែទៅតាមកាលបរិច្ឆេទ", "data" => ""));
			// }
			
			$data['specialday']['createDate']=date("Y-m-d");
			$data['specialday']['createBy']=$this->user->id;
			$specailData = DB::table('mef_specialday')->insertGetId($data['specialday']);
			if($data['specialday']['status'] == 1){
				foreach ($list_office as $key => $value) {
					$data['sub']['specialDayId'] = $specailData;
					$data['sub']['officeId'] = $value;
					DB::table('mef_sub_specialday')->insert($data['sub']);
				}
			}elseif($data['specialday']['status'] == 2){
				foreach ($list_officer as $key => $value) {
					$data['sub']['specialDayId'] = $specailData;
					$data['sub']['officerId'] = $value;
					DB::table('mef_sub_specialday')->insert($data['sub']);
				}
			}else{
				$data['sub']['specialDayId'] = $specailData;
				DB::table('mef_sub_specialday')->insert($data['sub']);
			}
			
            /* End Save data */
		}else{
			$result = DB::table('mef_specialday')->where('date', $data['specialday']['date'])->where('Id',$request->Id)->count();
			$shift = DB::table('mef_specialday')->where('shift', $data['specialday']['shift'])->where('Id',$request->Id)->count();
			// dd($data['specialday']['shift']);
			if($result >0 && $shift > 0){
					$specailData = DB::table('mef_specialday')->where('Id', $data['Id'])->update($data['specialday']);
					DB::table('mef_sub_specialday')->where('specialDayId',$data['Id'])->delete();
					if($data['specialday']['status'] == 1){
						foreach ($list_office as $key => $value) {
							$data['sub']['specialDayId'] = $data['Id'];
							$data['sub']['officeId'] = $value;
							DB::table('mef_sub_specialday')->insert($data['sub']);
						}
					}elseif($data['specialday']['status'] == 2){
						foreach ($list_officer as $key => $value) {
							$data['sub']['specialDayId'] = $data['Id'];
							$data['sub']['officerId'] = $value;
							DB::table('mef_sub_specialday')->insert($data['sub']);
						}
					}else{
						$data['sub']['specialDayId'] = $data['Id'];
						DB::table('mef_sub_specialday')->insert($data['sub']);
					}
				}else{
					$result = DB::table('mef_specialday')->where('date', $data['specialday']['date'])->count();
					$shift = DB::table('mef_specialday')->where('shift', $data['specialday']['shift'])->count();
					if($result >0 && $shift > 0){
						return json_encode(array("code" => 0, "message" => "កាលបរិច្ឆទ និង វេន​ មានរួចហើយ!", "data" => ""));
					}else{
						// dd(1);
						$specailData = DB::table('mef_specialday')->update($data['specialday']);
						DB::table('mef_sub_specialday')->where('specialDayId',$data['Id'])->delete();
						if($data['specialday']['status'] == 1){
							foreach ($list_office as $key => $value) {
								$data['sub']['specialDayId'] = $data['Id'];
								$data['sub']['officeId'] = $value;
								DB::table('mef_sub_specialday')->insert($data['sub']);
							}
						}elseif($data['specialday']['status'] == 2){
							foreach ($list_officer as $key => $value) {
								$data['sub']['specialDayId'] = $data['Id'];
								$data['sub']['officerId'] = $value;
								DB::table('mef_sub_specialday')->insert($data['sub']);
							}
						}else{
							$data['sub']['specialDayId'] = $data['Id'];
							DB::table('mef_sub_specialday')->insert($data['sub']);
						}
					}
				}
				
		}

		return json_encode(array("code" => 1, "message" => $this->messages['success'], "data" => ""));
        
    }
	public function postDelete(Request $request){
        $Id = isset($request['Id']) ? $request['Id']:'';
		$sub= DB::table('mef_sub_specialday')->whereIn('specialDayId',$Id)->delete();
        $result = DB::table('mef_specialday')->whereIn('Id',$Id)->delete();
		if($result){
			return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
		}else{
			return json_encode(array("code" => 0, "message" => "not success", "data" => ""));
		}
		
    }
	public function getDelete($id){
        // $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->holiday->postDelete(1);
    }

}