<?php 
namespace App\Http\Controllers\BackEnd\CurrentAddress;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\CurrentAddress\CommuneModel;

class CommuneController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->Model = new CommuneModel();
		$this->viewFolder = $this->viewFolder.'.current-address.commune';
    }

    public function getIndex(){
        return view($this->viewFolder.'.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->Model->getDataGrid($request->all());
    }
	public function postNew(Request $request){
		$this->data['listProvince'] = $this->Model->getListProvince();
		$this->data['listDistricts'] = array(array("text"=>"", "value" => ""));
        return view($this->viewFolder.'.new')->with($this->data);
    }
	public function postEdit(Request $request){
        $this->data['row'] = $this->Model->getDataByRowId($request['Id']);
		$this->data['listProvince'] = $this->Model->getListProvince();
		$this->data['listDistricts'] = $this->Model->getListDistricts($this->data['row']->mef_province_id);
        return view($this->viewFolder.'.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->Model->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->Model->postDelete($listId);
    }
	public function postGetDistrictByProId(Request $request){
        $mef_province_id = isset($request['mef_province_id']) ? $request['mef_province_id']:'';
        return $this->Model->getListDistricts($mef_province_id);
    }
}
