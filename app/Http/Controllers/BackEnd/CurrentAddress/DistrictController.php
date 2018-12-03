<?php 
namespace App\Http\Controllers\BackEnd\CurrentAddress;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\CurrentAddress\DistrictModel;

class DistrictController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->Model = new DistrictModel();
		$this->viewFolder = $this->viewFolder.'.current-address.district';
    }

    public function getIndex(){
        return view($this->viewFolder.'.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->Model->getDataGrid($request->all());
    }
	public function postNew(Request $request){
		$this->data['listProvince'] = $this->Model->getListProvince();
        return view($this->viewFolder.'.new')->with($this->data);
    }
	public function postEdit(Request $request){
		$this->data['listProvince'] = $this->Model->getListProvince();
        $this->data['row'] = $this->Model->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->Model->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->Model->postDelete($listId);
    }

}
