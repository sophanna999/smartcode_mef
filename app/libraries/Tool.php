<?php

namespace App\libraries;
use Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class Tool {
    public function __construct()
    {
        $this->constant = Config::get('constant');
    }
    // Random String
    public	function mt_rand_str ($l, $c = 'abcdefghijklmnopqrstuvwxyz1234567890') {
        for ($s = '', $cl = strlen($c) - 1, $i = 0; $i < $l; $s .= $c[ mt_rand(0, $cl) ], ++$i) ;
        return $s;
    }

    public function dayFormat($now){
        $len=strlen($now);
        $newString="";
        for($i=1;$i<=$len;$i++){
            $number=substr($now,0,1);
            $now=substr($now,1);
            if($number=='1'){
                $newString = $newString.$this->constant['one'];
            }
            else if($number=='2'){
                $newString = $newString.$this->constant['two'];
            }
            else if($number=='3'){
                $newString = $newString.$this->constant['three'];
            }
            else if($number=='4'){
                $newString = $newString.$this->constant['four'];
            }
            else if($number=='5'){
                $newString = $newString.$this->constant['five'];
            }
            else if($number=='6'){
                $newString = $newString.$this->constant['six'];
            }
            else if($number=='7'){
                $newString = $newString.$this->constant['seven'];
            }
            else if($number=='8'){
                $newString = $newString.$this->constant['eight'];
            }
            else if($number=='9'){
                $newString = $newString.$this->constant['nine'];
            }
            else if($number=='0'){
                $newString = $newString.$this->constant['zero'];
            }
            else{
                $newString = $newString.$number;
            }
        }
        return $newString;
    }

    public function monthFormat($number){
            $newString="";
            if($number=='1' || $number=='01'){
                $newString = "មករា"; 
            }
            else if($number=='2' || $number=='02'){
                $newString = "កុម្ភៈ";
            }
            else if($number=='3' || $number=='03'){
                $newString = "មិនា";
            }
            else if($number=='4' || $number=='04'){
                $newString = "មេសា";
            }
            else if($number=='5' || $number=='05'){
                $newString = "ឧសភា";
            }
            else if($number=='6' || $number=='06'){
                $newString = "មិថុនា";
            }
            else if($number=='7' || $number=='07'){
                $newString = "កក្កដា";
            }
            else if($number=='8' || $number=='08'){
                $newString = "សីហា";
            }
            else if($number=='9' || $number=='09'){
                $newString = "កញ្ញា";
            }
            else if($number=='10'){
                $newString = "តុលា";
            }
            else if($number=='11'){
                $newString = "វិច្ឆិកា";
            }
            else if($number=='12'){
                $newString = "ធ្នូ";
            }
            else{
                $newString = $newString;
            }
    
        return $newString;
    }
	
	// Cut String
	public function after_last ($thiss, $inthat) {
		if (!is_bool($this->strrevpos($inthat, $thiss)))
			return substr($inthat, $this->strrevpos($inthat, $thiss) + strlen($thiss));
	}

	public function before_last ($thiss, $inthat)
	{
		return substr($inthat, 0, $this->strrevpos($inthat, $thiss));
	}

	public function strrevpos ($instr, $needle) {
		$rev_pos = strpos(strrev($instr), strrev($needle));
		if ($rev_pos === false) return false;
		else return strlen($instr) - $rev_pos - strlen($needle);
	}
	// Cut String End

    public function dateformate($date,$str_format='/'){
        $date_time = $date;

        $day = date("d", strtotime($date_time));
        $month = date("m", strtotime($date_time));
        $year = date("Y", strtotime($date_time));

        if($str_format=='full'){
            return $this->dayFormat($day).' '.trans('general.month').$this->monthFormat($month).' '.trans('general.year').$this->dayFormat($year);
        }
        return $date = $this->dayFormat($day).$str_format.$this->monthFormat($month).$str_format.$this->dayFormat($year);
    }
	public function khmerDate($date){
        $date_time = $date;
        $day = date("d", strtotime($date_time));
        $month = date("m", strtotime($date_time));
        $year = date("Y", strtotime($date_time));
        $date = $this->dayFormat($day).' ខែ '.$this->monthFormat($month).' ឆ្នាំ '.$this->dayFormat($year);
        return $date;
    }
    public function html_entity_encode($string){
        return htmlentities($string,ENT_QUOTES, "UTF-8");
    }
	
	public function khmerNumber($number){
		$kh_number ='';
		if($number >= 0){
			foreach(str_split($number,1) as $key => $value){
				
				$kh_number .= $this->constant[$value];
			}
		}
		return $kh_number;
	}
	
	public function getMasterDataName($tblName,$idField,$nameField,$id){
		$row = DB::table($tblName)->where($idField, $id)->first();
		if($row != null){
			return $row->{$nameField};
		}
		return "";
	}

}

?>