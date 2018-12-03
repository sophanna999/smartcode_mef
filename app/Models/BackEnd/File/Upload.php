<?php
namespace App\Models\BackEnd\File;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model {

	protected $fillable = [
							'user_id',
							'module',
							'r_key'
						];
	protected $primaryKey = 'id';
	protected $table = 'mef_uploads';

	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
