<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tracking extends Model
{
	protected $table = 'fm_tracking';
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    public function __construct(){
		parent::__construct();
	
    }
   
}
?>
