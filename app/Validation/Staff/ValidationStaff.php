<?php
namespace App\Validation\Staff;
use Validator;

class ValidationStaff {

    public function __construct() {

    }

    public function validationSaveEdit(array $data){
        if($data['Id'] == 0){
			$rules = array(
				'first_name' 		=> 'required',
                'last_name' 		=> 'required',
				'full_name' 		=> 'required',
				'email' 			=> 'required|email',
				'phone_number'		=> 'required|min:9|max:18',
				'avatar'			=> 'mimes:jpeg,bmp,png'
			);
            return Validator::make($data, $rules);
        }else{
            return Validator::make($data, [
                'first_name' 		=> 'required',
                'last_name' 		=> 'required',
				'full_name' 		=> 'required',
				'email' 			=> 'required|email',
				'phone_number'		=> 'required|min:9|max:18',
				'avatar'			=> 'mimes:jpeg,bmp,png'
            ]);
        }
    }
}

?>