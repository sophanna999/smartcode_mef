<?php 
namespace App\Http\Controllers\BackEnd\Degree;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Degree\SkillModel;

class SkillController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->skill = new SkillModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.skill.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->skill->getDataGrid($request->all());
    }
	public function postNew(){
        return view($this->viewFolder.'.skill.new')->with($this->data);
    }
    public function postEdit(Request $request){
        $this->data['row'] = $this->skill->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.skill.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->skill->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->skill->postDelete($listId);
    }

}
