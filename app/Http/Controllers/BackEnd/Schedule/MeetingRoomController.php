<?php
namespace App\Http\Controllers\BackEnd\Schedule;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Schedule\MeetingRoomModel;

class MeetingRoomController extends BackendController {

	public function __construct(){
		parent::__construct();
		$this->meetingRoom = new MeetingRoomModel();
	}

	public function getIndex(){
		return view($this->viewFolder.'.schedule.meeting-room.index')->with($this->data);
	}

	public function postIndex(Request $request){
		return $this->meetingRoom->getDataGrid($request->all());
	}
	public function postNew(Request $request){
		return view($this->viewFolder.'.schedule.meeting-room.new')->with($this->data);
	}
	public function postEdit(Request $request){
		$this->data['row'] = $this->meetingRoom->getDataByRowId($request['Id']);
		return view($this->viewFolder.'.schedule.meeting-room.new')->with($this->data);
	}
	public function postSave(Request $request){
		return $this->meetingRoom->postSave($request->all());
	}
	public function postDelete(Request $request){
		$listId = isset($request['Id']) ? $request['Id']:'';
		return $this->meetingRoom->postDelete($listId);
	}

}
