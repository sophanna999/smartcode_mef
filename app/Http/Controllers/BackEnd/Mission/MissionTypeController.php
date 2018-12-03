<?php 
namespace App\Http\Controllers\BackEnd\Mission;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Mission\MissionTypeModel;

class MissionTypeController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->Model = new MissionTypeModel();
		$this->viewFolder = $this->viewFolder.'.mission.mission-type';
    }

    public function getIndex(){
        return view($this->viewFolder.'.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->Model->getDataGrid($request->all());
    }
	public function postNew(Request $request){
        return view($this->viewFolder.'.new')->with($this->data);
    }
    public function postEdit(Request $request){
        $this->data['row'] = $this->Model->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->Model->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['id']) ? $request['id']:'';
        return $this->Model->postDelete($listId);
    }

}
