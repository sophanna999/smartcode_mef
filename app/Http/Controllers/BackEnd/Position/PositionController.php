<?php 
namespace App\Http\Controllers\BackEnd\Position;
use App\Http\Controllers\BackendController;
use App\Models\BackEnd\Position\PositionModel;
use Illuminate\Http\Request;
use App\Models\BackEnd\Position\titleModel;

class PositionController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->position = new PositionModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.position.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->position->getDataGrid($request->all());
    }
	/*public function postNew(){
        
        
        return view($this->viewFolder.'.position.new')->with($this->data);
    }*/

    public function postNew(Request $request){
        
        $this->data['listPosition'] = json_encode($this->position->getListPosition());
        $this->data['listPositionCheck'] = json_encode(array());
        return view($this->viewFolder.'.position.new')->with($this->data);
    }

    public function postEdit(Request $request){
        $this->data['row'] = $this->position->getDataByRowId($request['Id']);

        $this->data['listPosition'] = json_encode($this->position->getListPosition());
       // print_r($this->data['listPosition']);exit();
        //$this->data['listPositionCheck'] = $this->data['row']->MEMBER_ID;
        //print_r($this->data['listPositionCheck']);exit();


            //json_encode($this->position->getListPositionByMemberId($this->data['row']->MEMBER_ID));
        //print_r($this->data['listPositionCheck']);exit();
        $check =  explode(',',$this->data['row']->MEMBER_ID);
        $this->data['listPositionCheck'] = json_encode($this->position->getListPositionByMemberId($check));
        return view($this->viewFolder.'.position.new')->with($this->data);
    }
	public function postSave(Request $request){
        //print_r($request->all());exit();
        return $this->position->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->position->postDelete($listId);
    }

}
