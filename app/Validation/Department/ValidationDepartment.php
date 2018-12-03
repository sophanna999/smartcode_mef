<?php

namespace App\Validation\Department;

use Validator;

class ValidationDepartment {

    public function __construct() {

    }

    public function validationSaveEdit(array $data){
        if($data['Id'] == 0){
            return Validator::make($data, [
                'Name' 		=> 'required|min:2|max:255',
            ]);
        }else{
            return Validator::make($data, [
                'Name' 		=> 'required|min:2|max:255'
            ]);
        }
    }
}

?>