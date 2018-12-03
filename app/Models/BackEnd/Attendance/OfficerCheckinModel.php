<?php
namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
use App\Models\BackEnd\BackEndModel;

class OfficerCheckinModel extends BackEndModel
{

    public function __construct()
    {
        $this->constant = Config::get('constant');
        $this->table = Config::get('table');
        $this->userSession = session('sessionUser');
		$this->member = explode(',',$this->userSession->mef_member_id);
		array_push($this->member,strval($this->userSession->id));//dd($this->member);
    }
    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "FULL_NAME_KH";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = $this->getAllOfficer(null,null,null,'NA',false);
		$total = count($listDb->get());

        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'FULL_NAME_KH':
                        $listDb = $listDb->where('FULL_NAME_KH','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'FULL_NAME_EN':
                        $listDb = $listDb->where('FULL_NAME_EN','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'time':
                        $listDb = $listDb->where('time','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'date':
                    	 $arrFilterValue = \DateTime::createFromFormat('d/m/Y g:i A', $arrFilterValue)->format('Y-m-d');
                        $listDb = $listDb->where('date','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }   

        $list = $listDb->get();
        
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    public function getListCheckin($param=array())
    {
    	$data = DB::table('mef_service_status_information AS ssi')
    		->leftJoin('mef_personal_information AS pi','pi.MEF_OFFICER_ID','=','ssi.MEF_OFFICER_ID')
    		->select('ssi.MEF_OFFICER_ID as value','pi.FULL_NAME_KH as text','pi.FULL_NAME_EN')
            ->orderBy('ssi.CURRENT_POSITION','ASC')
            ->where('CURRENT_GENERAL_DEPARTMENT',$this->userSession->mef_general_department_id);
        if(sizeof($param)>0){
            foreach ($param as $key => $value) {
                $data=$data->where($key,$value);
            }
        }
        $arr = array( (object) array("text"=>"", "value" => "0"));
        $arr = array_merge($arr,$data->get());
        return $arr;
    }
    // function return array lists
    public function listOfficerId($param=array())
    {
        $data = DB::table('mef_service_status_information AS ssi');
            
        if(sizeof($param)>0){
            foreach ($param as $key => $value) {
                $data=$data->where($key,$value);
            }
        }
        $data = $data->lists('ssi.MEF_OFFICER_ID as value');
        return $data;
    }

}