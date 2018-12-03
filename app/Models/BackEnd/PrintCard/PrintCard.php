<?php

namespace App\Models\BackEnd\PrintCard;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Excel;

class PrintCard
{

    public function __construct()
    {
        $this->constant = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
    }

}