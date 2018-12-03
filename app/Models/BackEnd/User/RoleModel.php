<?php

namespace App\Models\BackEnd\User;
use Illuminate\Support\Facades\DB;
use App\Validation\User\ValidationRole;
use Config;

class RoleModel
{
    public function __construct()
    {
        $this->Validation = new ValidationRole();
        $this->User = new UserModel();
		$this->messages = Config::get('constant');
        $this->table = Config::get('table');
    }

    public function getDataGrid($dataRequest){
        $listDb = DB::table($this->table['MEF_ROLE'])
                ->get();
        $total = count($listDb);
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "id"           => $row->id,
                "role"         => $row->role,
                "parent_id"    => $row->parent_id,
                "description"  => $row->description,
                "active"       => $row->active,
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    public function postNew($id){
        $role = $this->getDataByRowId($id);
        $listAuthentication = DB::table($this->table['MEF_AUTHENTICATE'])
						->orderBy("order", "ASC")
						->where('status',0)
						->get();
						
        $selectedAuthentication = DB::table($this->table['MEF_AUTHENTICATE_TO_ROLE'])
						->where('moef_role_id',$id)
						->get();
        $listString = '';
        foreach($selectedAuthentication as $key=>$val){
            $listString.= $val->meof_authenticate_id.',';
        }
        $listString = substr($listString,0,-1);
        $arr = array();
        foreach($listAuthentication as $authentication){
            $arr[] = array(
                    "id"        => $authentication->id,
                    "parentid"  => $authentication->parent_id,
                    "text"      => $authentication->name,
                    "value"     => $authentication->id
                    );
        }
        $listAuthentication = $arr;
        return array(
			"role" 						=> $role, 
			"allAuthentication" 		=> $listAuthentication,
			"selectedAuthentication" 	=> $listString
		);
    }

    public function postSave($data){
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
		
        if($data['Id'] == 0){
            /* Save data */
			$insertGetId = DB::table($this->table['MEF_ROLE'])->insertGetId([
				'role' 			=>$data['role'], 
				'description' 	=>$data['description'],
				'active'		=>$data['active'],
                'parent_id'     =>$data['join_group']
			]);
            /* End Save data */
        }else{
            DB::table($this->table['MEF_ROLE'])
				->where('id', $data['Id'])
				->update([
					'role' 			=>$data['role'], 
					'description' 	=>$data['description'],
					'active'		=>$data['active'],
                    'parent_id'     =>$data['join_group']
				]);
        }
    
		//Save authentication to role
		$roleId = $data['Id'] == 0 ? $insertGetId:$data['Id'];
		$this->postAuthenticateRole($roleId,$data['authentication_id']);
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }

	private function postAuthenticateRole($roleId,$selectedAuthentication){
		DB::table($this->table['MEF_AUTHENTICATE_TO_ROLE'])->where('moef_role_id',$roleId)->delete();
        $authentication = '';
        if($selectedAuthentication != ""){
            $authentication = explode(",", $selectedAuthentication);
        }
        $dataAuthenticationRole = array();
        foreach($authentication as $key=>$val){
            $dataAuthenticationRole[] = array(
                "moef_role_id"          => $roleId,
                "meof_authenticate_id"  => $val,
            );
        }
        if(!empty($dataAuthenticationRole)){
			DB::table($this->table['MEF_AUTHENTICATE_TO_ROLE'])->insert($dataAuthenticationRole);
        }
	}

    public function getDataByRowId($id){
        return DB::table($this->table['MEF_ROLE'])->where('id', $id)->first();
    }

	public function postDelete($id){
        $boolean = $this->User->isRoleHasUser($id);
        if($boolean == 1){
            return array("code" => 1, "message" => trans('trans.itemInUsed'));
        }else{
            DB::table($this->table['MEF_ROLE'])->where('id',$id)->delete();
            DB::table($this->table['MEF_AUTHENTICATE_TO_ROLE'])->where('moef_role_id',$id)->delete();
            return array("code" => 2,"message" => trans('trans.success'));
        }
    }

	public function getRoleName(){
        $obj =  DB::table($this->table['MEF_ROLE'])->select('role')->get();
        $arr = array();
        foreach($obj as $row){
            $arr[] = $row->role;
        }
        return json_encode($arr);
    }

    public function getRoleIdByName($role){
        $row = DB::table($this->table['MEF_ROLE'])->select('id')->where('role',$role)->first();
        return $row->id;
    }

	 //sample code for get list loin group
    public function getListJoinGroup(){
        $obj =  DB::table('mef_role')
            ->select(
                'id AS value',
                'role AS text')
            ->orderBy('Id','ASC')
            ->get();
        return $obj;
    }

    //sample code for get list role when update data
    public function getListJoinGroupCheck($id){
        $obj = array();
        if(!empty($id)){
            foreach ($id as $key => $value){
                $obj[] =  array(
                    "text" => DB::table('mef_role')->select('role')->where('id',$value)->first(),
                    "value" => $value,
                );
            }
        }
        return $obj;
    }
}
?>