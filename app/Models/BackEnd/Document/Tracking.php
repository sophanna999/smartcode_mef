<?php
namespace App\Models\BackEnd\Document;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
	protected $table = 'fm_tracking';

	public function source()
    {
		return $this->hasOne('App\Models\BackEnd\Document\Setting', 'id', 'source');
	}
	public function flow(){
		return $this->hasOne('App\Models\BackEnd\Document\Setting', 'id', 'flow');
	}
	
}
?>
