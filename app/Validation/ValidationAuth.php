<?php

namespace App\Validation;

use Illuminate\Support\Facades\Session;
use Validator;

class ValidationAuth {

    public function __construct() {

    }

    public function validationUserSession(){
        if (!Session::has('sessionUser')) {
            return 0;
        } else {
            return 1;
        }
    }

    public function validationLogin(array $data)
    {
        return Validator::make($data, [
            'user_name' => 'required',
            'password' => 'required',
        ]);
    }
}

?>