<?php 
namespace App\Http\Controllers\BackEnd\Schedule;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Schedule\MeetingLeaderModel;

class MeetingLeaderController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->meetingLeader = new MeetingLeaderModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.schedule.meeting-leader.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->meetingLeader->getDataGrid($request->all());
    }
	
	public function postNew(Request $request){
        return view($this->viewFolder.'.schedule.meeting-leader.new')->with($this->data);
    }
    public function postEdit(Request $request){
        $this->data['row'] = $this->meetingLeader->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.schedule.meeting-leader.new')->with($this->data);
    }

	public function postSave(Request $request){
        $array = $this->meetingLeader->checkLeaderEmail($request['email']);
        $old_email = $request['old_email'];
        $email = $array[0]['email'] != '' ? $array[0]['email']:'';
        if ($old_email != $email && $array[0]['success'] == true){
            return json_encode(array("code" => 0, "message" => trans('schedule.email_taken'), "data" => ""));
        }else{
            return $this->meetingLeader->postSave($request->all());
        }
    }
	
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->meetingLeader->postDelete($listId);
    }
}
