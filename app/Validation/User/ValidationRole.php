<?php

namespace App\Validation\User;

use Validator;

class ValidationRole {

    public function __construct() {

    }

    public function validationSaveEdit(array $data){
        if($data['Id'] == 0){
            return Validator::make($data, [
                'role' 		=> 'required|min:2|max:255|unique:mef_role'
            ]);
        }else{
            return Validator::make($data, [
                'role' 		=> 'required|min:2|max:255'
            ]);
        }
    }
}

?>