<?php
namespace App\Validation\Meeting;
use Validator;

class ValidationMeeting {

    public function __construct() {

    }

    public function validationSaveEdit(array $data){
        if($data['Id'] == 0){
			$rules = array(
				'meeting_date'	=> 'required|unique:moef_meeting',
			);
            return Validator::make($data, $rules);
        }else{
            return Validator::make($data, [

            ]);
        }
    }
}

?>