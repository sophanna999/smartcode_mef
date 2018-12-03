<?php 
namespace App\Http\Controllers\BackEnd\Schedule;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Schedule\MeetingTypeModel;

class MeetingTypeController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->meetingType = new MeetingTypeModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.schedule.meeting-type.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->meetingType->getDataGrid($request->all());
    }
	public function postNew(Request $request){
        return view($this->viewFolder.'.schedule.meeting-type.new')->with($this->data);
    }
    public function postEdit(Request $request){
        $this->data['row'] = $this->meetingType->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.schedule.meeting-type.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->meetingType->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->meetingType->postDelete($listId);
    }

}
