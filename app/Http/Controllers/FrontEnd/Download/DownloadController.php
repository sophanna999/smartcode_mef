<?php 
namespace App\Http\Controllers\FrontEnd\Download;
use Input;
use DB;
use Excel;
use App\Http\Controllers\FrontendController;
use App\Models\FrontEnd\DownloadModel;
use App\Models\FrontEnd\PersonalInfoModel;
use App\Models\FrontEnd\BackgroundStaffGovInfoModel;
use App\Http\Controllers\FrontEnd\BackgroundStaffGovInfo\BackgroundStaffGovInfoController;
use Session;
class DownloadController extends FrontendController
{
	public function __construct(){
        parent::__construct();
         $this->staffGovModel = new BackgroundStaffGovInfoModel();
		 $this->downloadModel = new DownloadModel();
		 $this->personalInfoModel = new PersonalInfoModel();
		 $this->BackgroundStaffGovInfoController = new BackgroundStaffGovInfoController();
    }
	public function importExport()
	{
		return view('importExport');
	}
	
	public function getFil(){
		DB::table('mef_personal_information')->orderBy('ID')->chunk(100, function($users) {
			foreach ($users as $key => $user) {
				echo json_encode($user);
			}
		});
	}
	public function getIndex(){
		return view($this->viewFolder.'.background-staff-gov-info.download');
    }
	public function getDownloadExcel()
	{
		$user = session('sessionGuestUser');
		$user = $user->Id;
		$data['userInfo'] = $this->downloadModel->getPersonalInfo($user);
		$data['personalInfo'] = $this->personalInfoModel->getPersonalInfByUserId();
		$situation = $this->BackgroundStaffGovInfoController->postGetSituationPublicInfoByUserId();
		$data['Situation'] = json_decode($situation);
		// $framework = $this->postGetSituationOutSideFrameWorkByServiceStatusId();
		// $frameworkFree = $this->postGetSituationOutSideFrameWorkFreeByServiceStatusId();
		// return json_encode($array);
		// $data['situation'] = array('main'=>$data,'framework'=>$framework, 'frameworkFree'=>$frameworkFree);
		
            // $data = array($head);
            

		// echo json_encode(array_merge($this->data['userInfo'],$this->data['ministory']));
		echo json_encode($data);
		// foreach ($data as $key => $values) {
			// echo $key;
		// }
					
		// $data = $data['userInfo'];
		
		// Excel::create('Filename', function($excel) use ($data) {
			// foreach($data as $key =>$value){
				// $excel->sheet($key, function($sheet) use ($value) {
					// $data_cell=array();
					// foreach ($value as $key => $values) {
						// $data[$key]=$values;
					// }
					// $sheet->fromArray(array($data));
					// $sheet->protect('12345', function(\PHPExcel_Worksheet_Protection $protection) {
						// $protection->setSort(true);
					// });
					// $setPass = $sheet->getProtection()->setFormatCells(true);
				// });
			// }
		// })->export('xls');

	}
	public function postImportExcel()
	{
		$file           =       Input::file('business');
        if ($file != null) {
            $fileName   =       $file->getClientOriginalName();
            $fileData   =       $file->getPathName();
        }
		// echo $path = Input::file('file')->getRealPath();
		// echo  $fileName;
		if(Input::hasFile('business')){
			$path = Input::file('business')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			// var_dump($data[0]);
			echo json_encode($data);
			
		}
		// return back();
	}
}