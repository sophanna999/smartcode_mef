<?php

namespace App\Validation\Position;

use Validator;

class ValidationPosition {

    public function __construct() {

    }

    public function validationSaveEdit(array $data){
        if($data['Id'] == 0){
            return Validator::make($data, [
                'NAME' 		=> 'required|min:2|max:255|unique:mef_position',
            ]);
        }else{
            return Validator::make($data, [
                'NAME' 		=> 'required|min:2|max:255',
            ]);
        }
    }
}

?>