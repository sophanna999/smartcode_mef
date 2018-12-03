<?php namespace App\Http\Controllers;
use App\Models\UserAuthorizeModel;
use App\libraries\Tool;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Config;
use Session;
class PublicController extends Controller {
    

	public function getUserReq($key){
		
		$this->user = session('sessionUser');
	
		if($this->user){
			return redirect('attendance/user-req/'.$key);
		}else{
			Session::put('attendance_mail', $key);
			
			return redirect('login');
		}
	}
}
