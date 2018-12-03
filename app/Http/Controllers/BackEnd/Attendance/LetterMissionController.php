<?php 
namespace App\Http\Controllers\BackEnd\Attendance;
use App\Http\Controllers\BackendController;
use Input;
use DB;
use File;
use Config;
use Illuminate\Support\Facades\Storage;
use App\libraries\Tool;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;
use Illuminate\Support\Facades\Response;
use App\Models\BackEnd\Attendance\LetterMissionModel;
use Illuminate\Support\Facades\Validator;
use DateTime;
class LetterMissionController extends BackendController
{
	public function __construct(){
        parent::__construct();
        $this->attendance = new LetterMissionModel();
        
		$this->Tool = new Tool();
		$this->user = session('sessionUser');
		if(!isset($this->user->mef_general_department_id))
			return array();

		$this->data['downUrl'] = asset(Config::get('constant')['secretRoute'].'/letter-mission/download-file');
    }

	public function getIndex(){
		return view($this->viewFolder.'.attendance.letter-mission.index')->with($this->data);
	}
	public function postIndex(Request $request){
        return $this->attendance->getDataGrid($request->all());
    }
	public function postNew(Request $request)
	{
		$list = $this->attendance->getAllOfficer();
		$this->data['current_dt']= date("Y-m-d");
        $this->data['list_office']=$list;
		return view($this->viewFolder.'.attendance.letter-mission.new')->with($this->data);
	}
	public function postSave(Request $request)
	{
		return $this->attendance->postSave($request->all());
	}
	public function postEdit(Request $request){
		$this->data['row'] =$this->attendance->getDataByRowId($request->Id)->first();
		$this->data['list_office'] = $this->attendance->getAllOfficer();
		$this->data['current_dt']= date("Y-m-d");
		$this->data['mef_letter_file']= $this->attendance->getMissionFile($request->Id);
		// dd($this->data['mef_letter_file']);
		return view($this->viewFolder.'.attendance.letter-mission.new')->with($this->data);
		
	}
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->attendance->postDelete($listId);
	}
	public function getDownloadFile($id)
    {
		$file = DB::table('mef_take_mission_letter_file')->where('id',$id)->first();//dd($file);
		if($file){
			return Response::download(public_path($file->ftp_file_name));
			if(Storage::disk('public')->exists($file->ftp_file_name)){dd($file);
				return Response::download(storage_path($file->ftp_file_name));
			}
		}
		return abort(404);
	}
	public function postDeleteFiles(Request $request)
	{
	  return $this->attendance->doDeleteFile($request->all());
	}
}