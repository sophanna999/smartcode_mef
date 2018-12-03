<?php 
namespace App\Http\Controllers\FrontEnd\Emoji;
use App\Http\Controllers\FrontendController;
use Session;
use App\Models\FrontEnd\EmojiModel;

class EmojiController extends FrontendController {
    public function __construct(){
        parent::__construct();
		$this->viewFolder = $this->viewFolder.'.emoji';
		$this->data["defaultRouteAngularJs"]	= '';
		$this->Models = new EmojiModel();
    }

    public function getIndex(){
		//print_r($this->viewFolder); exit();
        return view($this->viewFolder.'.index')->with($this->data);
    }
    public function getFeeling($feeling_id = 1){
		/*
		1 = happy; 2 = sad; 3 = worry;
		*/
		$feeling_id = intval($feeling_id);
		$arr_feeling = array(1, 2, 3);
		if (!in_array($feeling_id, $arr_feeling)) {
			$feeling = 1;  
		}
		$this->Models->saveFeelingId($feeling_id);
		Session::put('feeling_id', $feeling_id);
		return redirect('/');
    }
}
