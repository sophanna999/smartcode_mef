<?php

namespace App\Models\BackEnd\Config;
use Illuminate\Support\Facades\DB;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Config;
class ConfigModel
{

    public function __construct()
    {
        $this->constant = Config::get('constant');
        $this->table = Config::get('table');
        dd('yaya');
		$this->Tool = new Tool();
    }
	public function postSave($data){
        $paths = 'files/config/';
		$rowObj = $this->getDataByRowId();
		if (Input::hasFile('avatar')) {
            $files = Input::file('avatar');
            $extension = ".".strtolower($files->getClientOriginalExtension());
            $random_name = $this->Tool->mt_rand_str(5, '0123456789');
            $convertName = time() . "_" . $random_name . $extension;
			
			//Move image to folder
            $files->move($paths, $convertName);
			if($rowObj != null){
				if($rowObj->avatar != ""){
					if (Storage::disk('public')->exists($rowObj->avatar)){
						Storage::disk('public')->delete($rowObj->avatar);
					}
				}
            }
            $imageUrl = $paths . $convertName;
            $data['avatarPic'] = $imageUrl;
        }else{
			$data['avatarPic'] = $rowObj != null ? $rowObj->avatar:'';
		}
		/* Click remove sign */
		if($data['statusRemovePicture'] == 1){
			if (Storage::disk('public')->exists($rowObj->avatar)){
				$data['avatarPic'] = '';
				Storage::disk('public')->delete($rowObj->avatar);
			}
		}

		DB::table($this->table['MEF_CONFIG'])
			->where('id', $data['Id'])
			->update([
				'header' 				=>$data['header'],
				'footer' 				=>$data['footer'],
				'InstitutionName_KH' 	=>$data['InstitutionName_KH'],
				'InstitutionName_EN' 	=>$data['InstitutionName_EN'],
				'avatar' 				=>$data['avatarPic']
			]);

		return redirect($this->constant['secretRoute'].'/config');
    }
	public function getDataByRowId(){
        return DB::table($this->table['MEF_CONFIG'])->first();
    }
}
?>