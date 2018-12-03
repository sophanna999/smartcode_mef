<?php

namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\DB;
use Config;

class EmojiModel
{

	public function __construct()
	{
		$this->userGuestSession = session('sessionGuestUser');
		$this->officer = 0;
		if ($this->userGuestSession != null) {
			$this->officer = intval($this->userGuestSession->Id);
		}
	}
	public function saveFeelingId($feeling_id){
		$array_user_feeling = array(
			"mef_officer_id" => $this->officer,
			"feeling_id" => $feeling_id,
			"create_date" => date("Y-m-d H:i:s")
		);
		DB::table('mef_feeling_to_officer')->insert($array_user_feeling);
		return $array_user_feeling;
	}
}

?>