<?php 
namespace App\Http\Controllers\BackEnd\CentralMinistry;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\CentralMinistry\CentralMinistryModel;

class CentralMinistryController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->central = new CentralMinistryModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.central-ministry.index')->with($this->data);
    }
	public function postIndex(Request $request){
        return $this->central->getDataGrid($request->all());
    }
	public function postNew(Request $request){
        $this->data['Id'] = $request['Id'];
        return view($this->viewFolder.'.central-ministry.new')->with($this->data);
    }
    public function postEdit(Request $request){
        $this->data['row'] = $this->central->getDataByRowId($request['Id']);
        $this->data['Id'] = $request['Id'];
        return view($this->viewFolder.'.central-ministry.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->central->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->central->postDelete($listId);
    }
}
