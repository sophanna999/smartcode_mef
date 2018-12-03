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
class PrivacyController extends Controller {
	public $data = array();
	public function __construct(){
		$this->viewFolder = 'front-end';
		$this->register = new RegisterModel();
	}
	public function getIndex(){
		$this->data["defaultRouteAngularJs"] = "";
		$this->data["checkIsUrlSubmit"] = array();
		$this->data["login_page"] = true;

		return view($this->viewFolder.'.template.privacy')->with($this->data);
	}
	/* Reset password End */
}