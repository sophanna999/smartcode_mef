<?php
namespace App\Validation\CentralMinistry;
use Validator;

class ValidationCentralMinistry {

    public function __construct() {

    }

    public function validationSaveEdit(array $data){
        if($data['Id'] == 0){
			$rules = array(
				'Name' 		=> 'required'
			);
            return Validator::make($data, $rules);
        }else{
            return Validator::make($data, array('Name' => 'required'));
        }
    }
}

?>