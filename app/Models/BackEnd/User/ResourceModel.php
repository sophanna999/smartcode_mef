<?php

namespace App\Models\BackEnd\User;
use Illuminate\Support\Facades\DB;
use App\Validation\User\ValidationResource;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;


class ResourceModel
{

    public function __construct()
    {
		$this->messages = Config::get('constant');
		$this->Validation = new ValidationResource();
        $this->table = Config::get('table');
		$this->Tool = new Tool();
    }
	public function getDataGrid(){
        $listDb = DB::table($this->table['MEF_AUTHENTICATE'])
                    ->orderBy('order','asc')
                    ->where('status',0)
                    ->get();
		$total = count($listDb);
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "id"           	=> $row->id,
                "name"          => $row->name,
                "url"           => $row->url,
                "description"   => $row->description,
                "parent_id"     => $row->parent_id,
                "order"         => $row->order,
				"icon"         => $row->icon,
                "active"        => $row->active,
				"privilege"     => $row->status,
				"status"        => $row->status == 0 ? 'Backend':'Frontend'
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }
    
	public function getFrontEndDataGrid(){
        $listDb = DB::table($this->table['MEF_AUTHENTICATE'])->where('status',1)->OrderBy('order','asc')->get();
		$total = count($listDb);
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "id"           	=> $row->id,
                "name"          => $row->name,
                "url"           => $row->url,
                "description"   => $row->description,
                "parent_id"     => $row->parent_id,
                "order"         => $row->order,
				"icon"         => $row->icon,
                "active"        => $row->active,
				"privilege"     => $row->status,
				"status"        => $row->status == 0 ? 'Backend':'Frontend'
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }
	
	public function postNew($id){
        $obj_row = DB::table($this->table['MEF_AUTHENTICATE'])
                    ->where('id',$id)
                    ->first();

        $listAuthenticationDb = DB::table($this->table['MEF_AUTHENTICATE'])
                    ->orderBy('order','ASC')
                    ->where('status',0)
                    ->get();
        $arrList = array();
        foreach($listAuthenticationDb as $row){
            $arrList[] = array(
                "id"        => $row->id,
                "value"     => $row->id,
                "parentid"  => $row->parent_id,
                "text"		=> $row->name,
            );
        }
        return array("authentication" => $obj_row, "listAuthentication" => $arrList);
    }
	
	public function postNewFrontEnd($id){
        $authentication = DB::table($this->table['MEF_AUTHENTICATE'])->where('id',$id)->first();
        $listAuthenticationDb = DB::table($this->table['MEF_AUTHENTICATE'])->where('status',1)->orderBy('order','asc')->get();
        $listAuthentication = array();
        foreach($listAuthenticationDb as $row){
            $listAuthentication[] = array(
                "id"        => $row->id,
                "value"     => $row->id,
                "parentid"  => $row->parent_id,
                "text"		=> $row->name,
            );
        }
        return array("authentication" => $authentication, "listAuthentication" => $listAuthentication);
    }
	
	public function postSave($data){
		$paths = "files/icons/";
        /* Validation Insert Data */
        $validator = $this->Validation->validationSaveEdit($data);
        if ($validator->fails()) {
            $error = json_encode($validator->messages());
            $arrayError = json_decode($error);
            $message = "";
            foreach($data as $key => $val){
                if (isset($arrayError->{$key})) {
                    $message = $message . $arrayError->{$key}[0].  "<br>";
                }
            }
            return json_encode(array("code" => 0, "message" => $message, "data" => ""));
        }
        /* Validation Insert Data End */
		
		$rowResource = $this->getDataByRowId($data['Id']);
		if (Input::hasFile('icon')) {
            $files = Input::file('icon');
            $size = $files->getSize();
            $extension = ".".strtolower($files->getClientOriginalExtension());
            $random_name = $this->Tool->mt_rand_str(5, '0123456789');
            $convertName = time() . "_" . $random_name . $extension;
			
			//Move image to folder
            $upload = $files->move($paths, $convertName);
			if($rowResource != null){
				if($rowResource->icon != ""){
					if (Storage::disk('public')->exists($rowResource->icon)){
						Storage::disk('public')->delete($rowResource->icon);
					}
				}
            }
            $imageUrl = $paths . $convertName;
            $data['avatarPic'] = $imageUrl;
        }else{
			$data['avatarPic'] = $rowResource != null ? $rowResource->icon:'';
		}
		
        if($data['Id'] == 0){
            /* Save data */
			DB::table($this->table['MEF_AUTHENTICATE'])->insert([
				'name' 			=>$data['name'],
				'url' 			=>$data['url'], 
				'parent_id' 	=>$data['parent_id'], 
				'order' 		=>$data['order'],
				'icon' 			=>$data['avatarPic'],
				'description' 	=>$data['description'],
				'active'		=>$data['active'],
				'status'		=>$data['status']
			]);
            /* End Save data */
        }else{
            DB::table($this->table['MEF_AUTHENTICATE'])
				->where('id', $data['Id'])
				->update([
					'name' 			=>$data['name'],
					'url' 			=>$data['url'], 
					'parent_id' 	=>$data['parent_id'], 
					'order' 		=>$data['order'],
					'icon' 			=>$data['avatarPic'],					
					'description' 	=>$data['description'],
					'active'		=>$data['active'],
					'status'		=>$data['status']
				]);
        }
		
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }

    public function postDelete($id){
	   $hasParent = DB::table($this->table['MEF_AUTHENTICATE'])->where('parent_id',$id)->count();
        if($hasParent > 0){
            return json_encode(array("code" => 0, "message" => trans('trans.itemInUsed'), "data" => "data"));
        }else{
			DB::table($this->table['MEF_AUTHENTICATE'])->where('id',$id)->delete();
			return array("code" => 1,"message" => trans('trans.success'));	
		}
    }

    public function getDataByRowId($id){
        return DB::table($this->table['MEF_AUTHENTICATE'])->where('id', $id)->first();
    }
	
	public function postSavePrivilege($data){
        if($data){
            unset($data['_token']);
        }
		$position = DB::table('mef_position_to_module')->where('mef_authenticate_id', $data['mef_authenticate_id'])->first();
		if(count($position) > 0){
			DB::table('mef_position_to_module')
				->where('mef_authenticate_id', $data['mef_authenticate_id'])
				->update([
					'mef_position_id' => $data['mef_position_id']
				]);
		} else {
			DB::table('mef_position_to_module')->insert($data);
		}
       
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
	
	public function getPrivilegeById($id){
		$result = DB::table('mef_position_to_module')->where('mef_authenticate_id', $id)->first();
		if($result){
			return json_encode($result);
		} else {
			return json_encode('');
		}
		
	}

}
?>