<?php
namespace App\Validation\User;
use Validator;

class ValidationUser {

    public function __construct() {

    }

    public function validationSaveEdit(array $data){
        if($data['Id'] == 0){
			$rules = array(
				'role' 				=> 'required',
				'department' 		=> 'required',
				'first_name' 		=> 'required',
                'last_name' 		=> 'required',
				'password' 			=> 'required:min:3',
				'email' 			=> 'required|email',
				'phone_number'		=> 'required|min:2|max:255',
				'user_name'			=> 'required|min:2|max:255|unique:mef_user',
				'avatar'			=> 'mimes:jpeg,bmp,png'
			);
            return Validator::make($data, $rules);
        }else{
            return Validator::make($data, [
                'role' 				=> 'required',
				'first_name' 		=> 'required',
                'last_name' 		=> 'required',
				'email' 			=> 'required|email',
				'phone_number'		=> 'required|min:2|max:255',
				'user_name'			=> 'required|min:2|max:255',
				'avatar'			=> 'mimes:jpeg,bmp,png'
            ]);
        }
    }
}

?>