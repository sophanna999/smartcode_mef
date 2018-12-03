<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attatchment extends Model
{
	protected $table = 'fm_document_attatchment';
	
    public function __construct(){
		parent::__construct();
		use SoftDeletes;
		protected $dates = ['deleted_at'];
    }
    public function document()
    {
        return $this->belongsTo('App\Models\BackEnd\Document\Document','document_id','id');
    }
}
?>