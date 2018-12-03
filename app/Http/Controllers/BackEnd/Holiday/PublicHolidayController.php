<?php 
namespace App\Http\Controllers\BackEnd\Holiday;
use App\Http\Controllers\BackendController;
use Excel;
use Config;
use Input;
use Illuminate\Http\Request;
use App\libraries\Tool;
use Illuminate\Support\Facades\DB;
use App\Models\BackEnd\Holiday\HolidayModel;
class PublicHolidayController extends BackendController
{
	public function __construct(){
        parent::__construct();
		$this->viewFolder;
		$this->messages = Config::get('constant');
        $this->holiday = new HolidayModel();
		$this->user = session('sessionUser');
		if(!isset($this->user->mef_general_department_id))
			return array();
		
    }
	
	public function getIndex(){
		return view($this->viewFolder.'.holiday.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
		
        return $this->holiday->getDataGrid($request->all());
    }
	public function postNew(Request $request){	
		// $d = [
			// {
				// "n":1
				// ,"date":{
					// "date":"2017-01-01 00:00:00.000000"
					// ,"timezone_type":3
					// ,"timezone":"Asia\/Phnom_Penh"}
					// ,"title":"International New Year Day"}
				// ,{
					// "n":2
					// ,"date":{
						// "date":"2017-01-07 00:00:00.000000"
						// ,"timezone_type":3
						// ,"timezone":"Asia\/Phnom_Penh"}
						// ,"title":"Victory over Genocide Day"
					// }
				// ,{"n":3
				// ,"date":{
					// "date":"2017-02-11 00:00:00.000000"
					// ,"timezone_type":3
					// ,"timezone":"Asia\/Phnom_Penh"}
				// ,"title":"Meak Bochea Day"
			// }
			// ];
		// dd($d);
		return view($this->viewFolder.'.holiday.new')->with($this->data);
    }
	
	public function postImportFile(Request $request){
		// dd($request->all());
		return view($this->viewFolder.'.holiday.import')->with($this->data);
		
	}
	public function postEdit(Request $request){	
		$this->data['row'] = DB::table('mef_holiday')->where('Id', $request->Id)->first();
		
		return view($this->viewFolder.'.holiday.new')->with($this->data);
    }
	
	public function postSave(Request $request){
		$data = $request->only('title','date');	
		$date = str_replace('/', '-', $data['date']);		
		$data['date'] = date('Y-m-d', strtotime($date));
		// dd($this->user);
		if($request->Id==0){
			/* Save data */
			$result = DB::table('mef_holiday')->where('date', $data['date'])->count();
			
			if($result >0){
				return json_encode(array("code" => 0, "message" => "មិនអនុញ្ញាតឲ្យបញ្ចូលទិន្នន័យស្ទួន សូមធ្វើការបន្ថែមឬកែប្រែទៅតាមកាលបរិច្ឆេទ", "data" => ""));
			}
			
			$data['created_dt']=date("Y-m-d");
			$data['updated_dt']=date("Y-m-d");
			$data['created_by']=$this->user->id;
			// $data['moef_role_id']=$this->user->moef_role_id;
			DB::table('mef_holiday')->insert($data);
            /* End Save data */
		}else{
			$result = DB::table('mef_holiday')->where('date', $data['date'])->count();
			
			if($result >0){
				DB::table('mef_holiday')
					->where('Id', $request->Id)
					->update([
						'title'		=>$data['title'],
						'updated_dt'		=>date("Y-m-d"),
						'created_by'		=>$this->user->id					
					]);
			}else{
				DB::table('mef_holiday')
					->where('Id',$request->Id)
					->update([
						'title'		=>$data['title'],
						'date'		=>$data['date'],
						'updated_dt'		=>date("Y-m-d"),
						'created_by'		=>$this->user->id					
					]);
			}
			
			if($result >0){
				return json_encode(array("code" => 1, "message" => "លោកអ្នកអាចកែប្រែត្រឹមតែចំណងជើងប៉ុណ្ណោះ", "data" => ""));
			}
		}
		return json_encode(array("code" => 1, "message" => $this->messages['success'], "data" => ""));
        
    }
	public function postDelete(Request $request){
        $Id = isset($request['Id']) ? $request['Id']:'';
		
        $result = DB::table('mef_holiday')->whereIn('Id',$Id)->delete();
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

	public function postExport(Request $request){
		// dd($request->all());
		$filename = 'របាយការណ៍ច្បាប់ឈប់សម្រាក'.date("Y-m-d h-i-s");
		$data['is_group']= '';
		$data['text'] = 'សំណើរសុំច្បាប់';
		$data['row'] = (object) array('Name'=>'របាយការណ៍ច្បាប់ឈប់សម្រាក');
		if(!isset($request['mef_officer_id'])){
			$data['is_group']= 'group';
		}
		$data['array'] = $this->holiday->search($request->all());
		
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
					$data_cell[$key]["ចំនួនថ្ងៃឈប់"] = $data['is_group'] == 'group' ? $values->total_duration.'ថ្ងៃ' : $values->duration.' ថ្ងៃ';
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
		 
		// return $this->holiday->export($request->all());
	}
	public function postImportexcel(Request $request)
	{
		// dd($request->all());
		$file           =       Input::file('pholiday');
        if ($file != null) {
            $fileName   =       $file->getClientOriginalName();
            $fileData   =       $file->getPathName();
        }
		$current_holiday =  DB::table('mef_holiday')->get();
		// echo $path = Input::file('file')->getRealPath();
		// echo  $fileName;
		if(Input::hasFile('pholiday')){
			$path = Input::file('pholiday')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			// var_dump($data[0]);
			
			$data_holiday = array();
			$data_holiday_err = array();
			foreach($data as $key =>$value){
				$tcheck = false;
				foreach($value->dates as $index =>$element){
						
					if($index =="date"){
						$value->date = date('Y-m-d', strtotime($element));;	
					}			
				}
				foreach($current_holiday as $hkey => $hvalue){
					if($hvalue->date==$value->date){
						$tcheck = true;
					}
					
				}
				
				if($tcheck == true){
					// $arr = array(
						// 'date'=>$value->date
						// ,'title'=>$value->title
					// );
					// array_push($data_holiday_err,$arr);
				}else{
					$arr = array(
						'date'=>$value->date
						,'title'=>$value->title
						,'created_dt' =>date("Y-m-d")
						,'updated_dt' =>date("Y-m-d")
						,'created_by' =>$this->user->id
						,'moef_role_id' =>$this->user->moef_role_id
					);
					array_push($data_holiday,$arr);
				}
				
			};
			
			if(sizeof($data_holiday)>0){
				DB::table('mef_holiday')->insert($data_holiday);
			}
			
			$result = array('allow_add'=>$data_holiday,'not_allow'=>$data_holiday_err);
			echo json_encode($data_holiday);
		}
		// return back();
	}
	
}