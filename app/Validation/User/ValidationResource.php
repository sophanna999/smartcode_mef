<?php
namespace App\Validation\User;
use Validator;

class ValidationResource {

    public function __construct() {

    }

    public function validationSaveEdit(array $data){
        if($data['Id'] == 0){
			$rules = array(
				'name' 		=> 'required',
				'url' 		=> 'required',
				'order' 	=> 'required|numeric',
				'icon'		=> 'mimes:jpeg,png'
			);
            return Validator::make($data, $rules);
        }else{
			$rules = array(
				'name' 		=> 'required',
				'url' 		=> 'required',
				'order' 	=> 'required|numeric',
				'icon'		=> 'mimes:jpeg,png'
			);
            return Validator::make($data, $rules);
        }
    }
}

?>