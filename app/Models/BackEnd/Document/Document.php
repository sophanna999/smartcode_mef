<?php
namespace App\Models\BackEnd\Document;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doc extends Model
{

	protected $table = 'fm_document';

    public function __construct(){
		parent::__construct();
    }
	public function attatchments()
    {
        return $this->hasMany('App\Models\BackEnd\Document\Attatchment','document_id','id');
		
		//return $this->hasMany('App\Comment', 'foreign_key', 'local_key');


    }
	
}
?>