<?php 
namespace App\Http\Controllers\BackEnd\Degree;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Degree\DegreeModel;

class DegreeController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->degree = new DegreeModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.degree.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->degree->getDataGrid($request->all());
    }
	public function postNew(){
        return view($this->viewFolder.'.degree.new')->with($this->data);
    }
    public function postEdit(Request $request){
        $this->data['row'] = $this->degree->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.degree.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->degree->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->degree->postDelete($listId);
    }

}
