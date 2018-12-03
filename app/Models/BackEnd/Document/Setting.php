<?php
namespace App\Models\BackEnd\Document;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $table = 'fm_tracking_setting';

	public function group(){
		return $this->belongsTo('App\Models\BackEnd\Document\Setting', 'parent_id', 'id');
	}
	
	public function tracking(){
		return $this->belongsTo('App\Models\BackEnd\Document\Tracking', 'source', 'id');
	}
	public function scopeSource($query){
		return $query->where('parent_id', '=', 1);
	}
	public function scopePrivacy($query){
		return $query->where('parent_id', '=', 4);
	}
	public function scopeCategory($query){
		return $query->where('parent_id', '=', 15);
	}
	public function scopeFlow($query){
		return $query->where('parent_id', '=', 19);
	}
	/*public function scopeOfName($query, $type)
    {
        return $query->where('type', $type);
    } */
	public function child()
    {
        return $this->belongsTo('Setting','parent_id');
    }
}
?>
