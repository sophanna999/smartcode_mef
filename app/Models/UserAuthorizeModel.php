<?php
namespace App\Models;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Config;
class UserAuthorizeModel
{
    public function __construct(){
        $this->table = Config::get('table');
    }

    //got value "dashboard/index" in table "mef_authnticate" and than select date from table "mef_authenticate_to_role" (Menglay)
    public function userAuthorize(){
        $segmentTwo = Request::segment(2);
        $segmentThree = Request::segment(3);
        if($segmentThree == null){
            $segmentThree = 'index';
        }
        $url = $segmentTwo . '/'. $segmentThree;
        $action = array("index", "new","delete","edit");
        if (in_array($segmentThree, $action)) {
            $userSession = session('sessionUser');
            $roleId = $userSession->moef_role_id;            
            $authentication = DB::table($this->table['MEF_AUTHENTICATE'])->where('url',$url)->first();
            if($authentication){
                $authenticationRole = DB::table($this->table['MEF_AUTHENTICATE_TO_ROLE'])
                    ->where('moef_role_id',$roleId)
                    ->where('meof_authenticate_id',$authentication->id)->get();
                if(count($authenticationRole)){
                    return array("code"=>1,"message" => "Permission grand!" ,"data" => "");
                }else{
                    return array("code"=>0,"message" => "Access denied!" ,"data" => "");
                }
            }else{
                return array("code"=>0,"message" => "no-url" ,"data" => "");
            }
        }else{
            return array("code"=>1,"message" => "Permission grand!" ,"data" => "");
        }
    }

    //get data by condition only one user has more role permission (Menglay-Modigy more role)
	public function getTreeMenuLeft($mef_role_id){

            $listDb = DB::table('mef_authenticate')
                ->select(
                    'mef_authenticate.id'
                    ,'mef_authenticate.parent_id as parentid'
                    ,'mef_authenticate.name as text'
                    ,'mef_authenticate.url as value'
                    ,DB::raw("(CASE WHEN ( mef_authenticate.icon= '') THEN '/icon/notepad.png' ELSE CONCAT(\"/\", mef_authenticate.icon) END) as icon")
                )
				->join('mef_autenticate_to_role','mef_authenticate.id','=','mef_autenticate_to_role.meof_authenticate_id')
				->orderBy('mef_authenticate.order', 'ASC')
				->where('mef_authenticate.active',1)
				->where('mef_authenticate.status',0)
				//->where('mef_autenticate_to_role.moef_role_id',$mef_role_id)
                //(Menglay-Modigy)
                ->whereIn('mef_autenticate_to_role.moef_role_id', $mef_role_id)
				->get();

        return json_encode($listDb);
    }
    public function getTreeMenuIdByUrl(){
        $segmentTwo = Request::segment(2);
        $authentication = DB::table($this->table['MEF_AUTHENTICATE'])->where('url',$segmentTwo)->first();
        //print_r($authentication); exit();
        if($authentication == null){
            return 0;
        }
        return $authentication->id;
    }
}
?>