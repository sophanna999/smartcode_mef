<?php
namespace App\Http\Controllers\BackEnd\Mission;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Storage;
use Config;
use DB;
use App\libraries\Tool;
use Illuminate\Support\Facades\Response;
use App\Models\BackEnd\Mission\MissionModel;

class MissionController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->Model = new MissionModel();
		$this->viewFolder = $this->viewFolder.'.mission.mission';
        $this->data['downUrl'] = asset(Config::get('constant')['secretRoute'].'/mission/download-file');
        $this->data['tool'] = new Tool();
    }

    public function getIndex(){
        return view($this->viewFolder.'.index')->with($this->data);
    }

	public function postIndex(Request $request){
        return $this->Model->getDataGrid($request->all());
    }

	public function postNew(Request $request){
		return $this->new_edit($request);
    }
    public function postNewReference(Request $request)
    {
        $this->data['row'] = MissionModel::find($request['Id']);
        // dd($this->data['row']);
        return view($this->viewFolder.'.mission_number')->with($this->data);
    }
	public function postEdit(Request $request){
		return $this->new_edit($request);
    }

	function new_edit($request){
        $this->data['miss'] =$miss= MissionModel::find($request['Id']);
		$this->data['row'] = $this->Model->getDataByRowId($request['Id']);
        $this->data['list_mission_location'] = json_encode($this->Model->getListLocation());
        $this->data['list_org'] = json_encode($this->Model->getListOrganization());
        $this->data['list_tran'] = json_encode($this->Model->getListTransportation());
        $this->data['list_tags'] = json_encode($this->Model->getListTags());
        // $this->data['list_mission_tags'] = ($miss->missionTags()->get());
		$this->data['list_mission_type'] = json_encode($this->Model->getAllMissionType());
		$this->data['mef_mission_join'] = $this->Model->getMissionJoinString($request['Id']);
		$this->data['lead'] = json_encode($this->Model->getListMissionLeader($request['Id']));
        $this->data['mef_officer_department'] = $this->Model->getMefOfficerForJoinByOfficeId(0);
        $this->data['mef_mission_attachment'] = $this->Model->getAttachmentFile($request['Id']);
        // dd($this->data['list_mission_tags']);
        return view($this->viewFolder.'.new')->with($this->data);
	}

	public function postSave(Request $request){ //dd($request->all());
        return $this->Model->postSave($request->all());
    }
    public function postSaveReference(Request $request)
    {
        $model = MissionModel::find($request['id']);
        $model->fill($request['input']);
        $model->save();
        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('course.course')])]);
    }
	public function postDelete(Request $request){
        $listId = isset($request['id']) ? $request['id']:array();
        return $this->Model->postDelete($listId);
    }

	public function postOfficerForJoin(Request $request){
		$office_id = $request['Id'];
		return $this->Model->getMefOfficerForJoinByOfficeId($office_id);
	}

	public function postListMissionToOfficer(Request $request){
        $this->data['attendee'] = $this->Model->getListMissionToOfficer($request['Id']);
        $this->data['row'] = $this->Model->getDataByRowId($request['Id']);
        $this->data['lead'] = $this->Model->getListMissionLeader($request['Id']);
        return view($this->viewFolder.'.list-mission-to-officer')->with($this->data);
	}

	public function postModalExport(Request $request){
		$this->data['mef_officer_department'] = $this->Model->getMefOfficerForJoinByOfficeId(0);
		return view($this->viewFolder.'.modal-export')->with($this->data);
	}
    public function getPrintVisa($mission_id)
    { 
        $this->data['miss'] = MissionModel::find($mission_id);
        $this->data['attende'] = $this->Model->getListMissionToOfficer($mission_id);
        $this->data['row'] = $this->Model->getDataByRowId($mission_id);
        $this->data['lead'] = $this->Model->getListMissionLeader($mission_id);
        
        return view($this->viewFolder.'.visa-print')->with($this->data);
    }
    public function getPrintMission($mission_id)
    { 
        $this->data['miss'] = MissionModel::find($mission_id);
        $this->data['attende'] = $this->Model->getListMissionToOfficer($mission_id);
        $this->data['row'] = $this->Model->getDataByRowId($mission_id);
        $this->data['lead'] = $this->Model->getListMissionLeader($mission_id);
        
        return view($this->viewFolder.'.mission_print')->with($this->data);
    }
	public function postExport(Request $request){
		return $this->Model->export($request->all());
	}

	public function postCheckExport(Request $request){
		return $this->Model->checkDataExport($request->all());
	}
  public function getDownloadFile($id)
    {
      $file = DB::table('mef_mission_attachment')->where('id',$id)->first();//dd($file);
      if($file){
        return Response::download(storage_path($file->file_path.$file->file_name));
        if(Storage::disk('local')->exists($file->file_path.$file->file_name)){dd($file);
            return Response::download(storage_path($file->file_path.$file->file_name));
        }
      }
      return abort(404);
    }
  public function postDeleteFiles(Request $request)
  {
    return $this->Model->doDeleteFile($request->all());
  }

}
