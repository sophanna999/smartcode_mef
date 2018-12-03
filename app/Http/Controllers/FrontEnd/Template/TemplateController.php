<?php
namespace App\Http\Controllers\FrontEnd\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FrontEnd\RegisterModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Support\Facades\Mail;
use File;
class TemplateController extends Controller {
	public $data = array();
	public function __construct(){
		$this->viewFolder = 'front-end';
		$this->register = new RegisterModel();
	}
	public function getIndex(){
		$this->data["defaultRouteAngularJs"] = "";
		$this->data["checkIsUrlSubmit"] = array();
		$this->data["login_page"] = true;

		return view($this->viewFolder.'.template.index')->with($this->data);
	}
	public function getGetRegister(){
			$listMinistry = $this->register->getAllMinistry();
			$this->data['listMinistry'] = json_encode($listMinistry);
			$this->data['listSecretariat'] = json_encode(array(array('value'=>'','text'=>'')));
			$this->data['listDepartment'] = json_encode(array(array('value'=>'','text'=>'')));
			$this->data['listOffice'] = json_encode(array(array('value'=>'','text'=>'')));
			return view($this->viewFolder.'.template.index')->with($this->data);
		}
	/* Reset password End */
}
