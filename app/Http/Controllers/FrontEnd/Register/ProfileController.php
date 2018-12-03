<?php 
namespace App\Http\Controllers\FrontEnd\Register;
use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Validator;
use DB;
use Hash;
use App\Models\FrontEnd\ProfileModel;

class ProfileController extends FrontendController {
    public function __construct(){
        parent::__construct();
		$this->viewFolder = $this->viewFolder.'.register';
    }

    public function getChangePassword(){
        return view($this->viewFolder.'.change_password')->with($this->data);
    }

    public function postChangePassword(Request $request){

        $validation = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|different:old_password|min:6',
            'new_password_confirmation' => 'required|same:new_password'
        ]);
        
        if($request->has('old_password'))
        {
            $validation->after(function ($validation) use ($request)
            {
            if (!$this->valid_password($request)) 
            {
                    $validation->errors()->add('old_password', 'ពាក្យសម្ងាត់ចាស់មិនត្រឹមត្រូវ');
                }
            });
        }

        if($validation->fails())
        {
            return redirect()->back()->withErrors($validation->messages());
        }

		$officer = DB::table('mef_officer')->whereId(session('sessionGuestUser')->Id)->update(['password'   => str_replace("$2y$", "$2a$", bcrypt($request->input('new_password'))), 'salt'  => $request->input('new_password')]);

        return redirect()->back()->withMessage(trans('messages.password_changed'));    
    }

    private function valid_password($request){

        $auth = session('sessionGuestUser');
        $officer = DB::table('mef_officer')->whereId($auth->Id)->first();

        return Hash::check( $request->input('old_password'), $officer->password );
    }
    

}
