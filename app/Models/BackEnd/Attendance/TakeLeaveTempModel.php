<?php

namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
use Excel;
use File;
use Storage;
use Input;
use Illuminate\Support\Facades\Mail;
use App\libraries\Tool;
use Illuminate\Database\Eloquent\Model;

class TakeLeaveTempModel extends Model
{
	protected $table = 'mef_temp_user_activity';
    public $timestamps = false;
    
}