<?php 
namespace App\Http\Controllers\BackEnd\Language;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\Language\LanguageModel;

class LanguageController extends BackendController {

    public function __construct(){
        parent::__construct();
		$this->language = new LanguageModel();
    }

    public function getIndex(){
        return view($this->viewFolder.'.language.index')->with($this->data);
    }
	
	public function postIndex(Request $request){
        return $this->language->getDataGrid($request->all());
    }
	public function postNew(){
        return view($this->viewFolder.'.language.new')->with($this->data);
    }
    public function postEdit(Request $request){
        $this->data['row'] = $this->language->getDataByRowId($request['Id']);
        return view($this->viewFolder.'.language.new')->with($this->data);
    }
	public function postSave(Request $request){
        return $this->language->postSave($request->all());
    }
	public function postDelete(Request $request){
        $listId = isset($request['Id']) ? $request['Id']:'';
        return $this->language->postDelete($listId);
    }

}
