<?php 
namespace App\Http\Controllers\BackEnd\OrganizationChat;

use DB;
use Input;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Config;
use Mail;
class OrganizationChatController extends BackendController {
	
	public function __construct(){
		parent::__construct();
		$this->userSession = session('sessionUser');
	}
	public function getIndex(){
		return view('.back-end.organization-chat.index')->with($this->data);
    }
    public function postIndex(Request $request){
        return $this->officer->getDataGrid($request->all());
    }


}
