<?php

namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Config;
use App\libraries\Tool;
class RegisterModel{
	
	public function __construct()
    {
		$this->Tool = new Tool();
    }
	
	public function doRegister($data){
	    $user_name = trim($data['USER_NAME']);
	    $user_name = str_replace(' ','_',$user_name);
		$array = array(
			'user_name'			    =>$user_name,
			'password'			    =>str_replace("$2y$", "$2a$", bcrypt($data['USER_PASSWORD'])),
			'salt'				    =>$data['USER_PASSWORD'],
			'register_date'		    =>date('Y-m-d H:i:s'),
			'is_register'		    =>0,
            'active'			    =>0,
            'confirmation_code'     =>$data['confirmation_code'],
            'generate_id'           =>$user_name
		);

		$officer_id = DB::table('mef_officer')->insertGetId($array);
		$userId = array('MEF_OFFICER_ID'=>$officer_id,'IS_REGISTER'=>0);
		
		/*Award*/
		$award_1 = array('AWARD_TYPE'=>1,'MEF_OFFICER_ID'=>$officer_id);
		$award_2 = array('AWARD_TYPE'=>2,'MEF_OFFICER_ID'=>$officer_id);
		DB::table('mef_appreciation_awards')->insert($award_1);
		DB::table('mef_appreciation_awards')->insert($award_2);

		/*Personal Info*/
		$array_personal = array(
			'MEF_OFFICER_ID'	=>$officer_id,
			'IS_REGISTER'		=>0,
			'FULL_NAME_EN'		=>$data['FULL_NAME_EN'],
			'FULL_NAME_KH'		=>$data['FULL_NAME_KH'],
			'EMAIL'				=>$data['EMAIL'],
			'PHONE_NUMBER_1'	=>$data['PHONE_NUMBER_1']
		);
		DB::table('mef_personal_information')->insert($array_personal);
		
		/*mef_service_status_information*/
		$array_service = array(
			'MEF_OFFICER_ID'				=>$officer_id,
			'IS_REGISTER'					=>0,
			'FIRST_MINISTRY'				=>$data['mef_ministry_id'],
			'FIRST_UNIT'					=>$data['mef_secretariat_id'],
			'FIRST_DEPARTMENT'				=>$data['mef_department_id'],
			'FIRST_OFFICE'					=>$data['mef_office_id'],
			'CURRENT_GENERAL_DEPARTMENT'	=>$data['mef_secretariat_id'],
			'CURRENT_DEPARTMENT'			=>$data['mef_department_id'],
			'CURRENT_OFFICE'				=>$data['mef_office_id']
		);
		DB::table('mef_service_status_information')->insert($array_service);
		
		
		/*Family Status*/
		DB::table('mef_family_status')->insert($userId);

		/*Work History*/
		DB::table('mef_work_history')->insert($userId);

		$data_private = array(
		    'MEF_OFFICER_ID'    =>$officer_id,
            'IS_REGISTER'       =>0
        );
		DB::table('mef_working_history_private')->insert($data_private);

		/* Officer Current address */
        $data_current_address = array(
            'mef_officer_id'    =>$officer_id,
            'is_register'       =>0
        );
		DB::table('mef_officer_current_address')->insert($data_current_address);
		if($officer_id == true){
            return redirect('/login');
		}
	}
	
	public function postUserAvailable($name){
		$data = array();
        $row = DB:: table('mef_officer')
            ->where('user_name',$name)
			->first();
		$data['success'] = count($row) > 0 ? true:false;	
        return $data;
    }
	
	public function getAllMinistry(){
        $arrList = DB::table('mef_ministry')->orderBy('Id', 'DESC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->Name,
                "value" => $row->Id
            );
        }
        return $arr;
    }
	public function getAllSecretariatByMinistry($mef_ministry_id){
        $arrList = DB::table('mef_secretariat')
                ->where('mef_ministry_id',$mef_ministry_id)
                ->orderBy('Id', 'DESC')
                ->get();
        $arr = array(array("text"=>"", "value" => ""));

        foreach($arrList as $row){
        	if($row->Abbr != ''){
        		$str = ' -'.$row->Abbr;
        	}else{
        		$str = '';
        	}

            $arr[] = array(
                'text' 	=>$row->Name.$str,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	public function getDepartmentBySecretariatId($mef_secretariat_id){
        $arrList = DB::table('mef_department')
                ->where('mef_secretariat_id',$mef_secretariat_id)
                ->orWhere('Name','មិនមាន')
                ->orderBy('Id', 'DESC')
                ->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
        	if($row->Abbr != ''){
        		$str = ' -'.$row->Abbr;
        	}else{
        		$str = '';
        	}

            $arr[] = array(
                'text' 	=>$row->Name.$str,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	public function getOfficeByDepartmentId($departmentId){
        $arrList = DB::table('mef_office')
                ->where('mef_department_id',$departmentId)
                ->orWhere('Name','មិនមាន')
                ->orderBy('Id', 'DESC')
                ->get();
        $arr = array(array("text"=>"", "value" => ""));

        foreach($arrList as $row){
        	if($row->Abbr != ''){
        		$str = ' -'.$row->Abbr;
        	}else{
        		$str = '';
        	}
            $arr[] = array(
                'text' 	=>$row->Name.$str,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	public function verifyEmail($email){
		$result = DB::table('mef_personal_information')->where('EMAIL',$email)->get();
		if(count($result) > 0){
			return json_encode(array("code" => 0, "message" => "សារអេឡិកត្រូនិកនេះត្រូវបានប្រើប្រាស់រួចម្តងហើយ", "data" => ""));
		} else {
			return json_encode(array("code" => 1, "message" => "Available", "data" => ""));
		}
		
	}
	public function checkUser($data=''){
		$row = DB:: table('mef_officer')
            ->where('user_name',$data->user)
			->first();
		if(isset($row->password)){
			if(Hash::check($data->oldPass,$row->password)){
				//Update officer password
				return $row->Id;
			} else {
				return false;
			}
		}else{
			return false;
		}
	}
	public function modChangePassword($data=''){
		$row = DB:: table('mef_officer')
            ->where('user_name',$data->user)
			->first();
		if($this->checkUser($data)==true){
			//Update officer password
			return DB::table('mef_officer')
				->where('Id', $row->Id)
				->update(['password'   => str_replace("$2y$", "$2a$", bcrypt($data->password))]);
		}else{
			return false;
		}
	}
	
	/* Reset Password */
	public function postResetPassword($request)
    {
		$email = $request["email"];
		$row = DB:: table('mef_personal_information')
            ->where('EMAIL',$email)
			->first();
		if($row == null){
			return array("code" => 0, "message" => "អ៊ីម៉ែលគ្មានក្នុងប្រព័ន្ធ", "data" => "");
		}else{
			$mef_officer_id = $row->MEF_OFFICER_ID;
			$dataFieldResetPassword = $this->createFieldResetPassword($mef_officer_id);
			$data	= (object)array(
				"HASHKEY" => $dataFieldResetPassword->HASHKEY,
				"EMAIL" => $row->EMAIL,
				"FULL_NAME_KH" => $row->FULL_NAME_KH
			);
			return array("code" => 1, "message" => "success", "data" => $data);
		}
    }
	
	function createFieldResetPassword($mef_officer_id){
		// mef_forget_password
		$array = array(
			'MEF_OFFICER_ID'	=>$mef_officer_id,
			'HASHKEY'			=>$this->setHashkey(),
			'CREATE_DATE'		=>date('Y-m-d H:i:s'),
			'STATUS'			=> 0
		);
		$mef_reset_password_id = DB::table('mef_forget_password')->insertGetId($array);
		$row = DB:: table('mef_forget_password')->where('ID',$mef_reset_password_id)->first();
		return $row;
	}
	
	public function getResetPasswordAction($request){
		$row = DB:: table('mef_forget_password')->where('HASHKEY',$request["hashkey"])->where('STATUS',0)->first();
		if($row == null){
			return array("code" => 0, "message" => "This hashkey code not much", "data" => "");
		}
		$yesterday = date("Y-m-d H:i:s", time() - 86400);
		$create_date = $row->CREATE_DATE;
		if($create_date < $yesterday){
			return array("code" => 0, "message" => "This has been expired!", "data" => "");
		}
		return array("code" => 1, "message" => "success", "data" => $row);
	}
	
	public function postResetPasswordAction($mefForgetPassword,$request){
		$password = $request["password"];
		$confirm_password = $request["confirm_password"];
		if($password != $confirm_password){
			return array("code" => 0, "message" => "ពាក្យសម្ងាត់របស់លោកអ្នកមិនត្រឹមត្រូវ", "data" => "");
		}
		// Hashkey Table 
		$id = $mefForgetPassword->ID;
		// mef_officer
		$mef_officer_id = $mefForgetPassword->MEF_OFFICER_ID;
		// reset officer password
		$mef_officer_reset_pw = DB::table('mef_officer')
				->where('Id', $mef_officer_id)
                ->update(['password'   => str_replace("$2y$", "$2a$", bcrypt($password))]);
		// update mef_forget_password
		$mef_forget_password = DB::table('mef_forget_password')
				->where('ID', $id)
				->update(['STATUS'   => 1]);
		// get mef_officer
		$mef_officer = DB::table('mef_officer')->where('Id', $mef_officer_id)->first();
		return array("code" => 1, "message" => "ពាក្យសម្ងាត់របស់លោកអ្នកត្រូវបានបង្កើតឡើងវិញជោគជ័យ", "data" => $mef_officer);
	}
	
	// Set Hash key
    function setHashkey()
    {
        return $this->hashkey = $this->checkHashkey();
    }
	
	function checkHashkey(){
		$hash = $this->Tool->mt_rand_str (20,'abcdefghijklmnopqrstuvwxyz1234567890');
        $has_key = DB:: table('mef_forget_password')->where('HASHKEY',$hash)->count();
        if ($has_key > 0 ) {
            return $this->setHashkey();
        } else {
            return $hash;
        }
	}
	/* Reset Password End */

	public function activeOfficerByConfirmationCode($confirmation_code,$data = array()){
	    $row = DB::table('mef_officer')->where('confirmation_code',$confirmation_code)->update($data);
	    if ($row){
	        return $row;
        }

    }
    public function getOfficerByConfirmationCode($confirmation_code){
	    $row = DB::table('mef_officer')
                ->select('confirmation_code')
                ->where('confirmation_code',$confirmation_code)
                ->first();
	    if ($row){
	        return $row;
        }
    }
}
?>