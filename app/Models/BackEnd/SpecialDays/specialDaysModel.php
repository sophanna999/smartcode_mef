<?php

namespace App\Models\BackEnd\SpecialDays;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SpecialDaysModel
{

    public function __construct()
    {
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->Tool = new Tool();
    }
	
    public function getDataByRowId($id){
//        return DB::table('v_take_leave_role_type')->where('Id', $id)->first();
        return  DB::select(DB::raw("call get_take_leave_role_type('".$id."');"));
    }
	public function postSave($data){
		
	}
	
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "date";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = $this->getSpecialDays();
		$total = count($listDb->get());

        if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'date':
						$arrFilterValue = \DateTime::createFromFormat('d/m/Y', $arrFilterValue)->format('Y-m-d');
                        $listDb = $listDb->where('date','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'reason':
                        $listDb = $listDb->where('reason','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'departmentName':
                        $listDb = $listDb->where('departmentName','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'shiftName':
                        $listDb = $listDb->where('shiftName','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }   

        $listDb = $listDb->get();
        
        return json_encode(array('total'=>$total,'items'=>$listDb));
    }
	private function getSpecialDays(){
		
		return $data = DB::table('v_specialDays')->groupBy('Id')
				->orderBy('Id', 'DESC');
				
	}

    // private function getSpecialDaysData($id){
        
    //     return $data = DB::table('v_specialDays')->where('Id',$id)->first();
                
    // }

    public function getDepartment()
    {
        $data = DB::table('mef_department')->get();
        $arr = array(array("text" => "", "value" => ""));
        foreach ($data as $row) {
            $arr[] = array(
                'text' => $row->Name,
                "value" => $row->Id
            );
        }
        return $arr;
    }

    public function getOffice($id)
    {
        $data = DB::table('mef_office')->where('mef_department_id',$id)->get();
        $arr = array(array("text" => "", "value" => ""));
        foreach ($data as $row) {
            $arr[] = array(
                'text' => $row->Name,
                "value" => $row->Id
            );
        }
        return $arr;
    }
    public function getMultiSelectOffice($id){
        $obj =  DB::table('mef_office')->where('mef_department_id',$id)->select('Name','Id')->get();
        $arr = array(array("text" => "", "value" => ""));
        foreach($obj as $row){
            $arr[] = array(
                'displayMember'     =>$row->Name,
                "valueMember"       =>$row->Id
            );
        }
        // dd($arr);
        return $arr;
    }
    public function getOfficeById($id){
        $obj =  DB::table('mef_sub_specialday')->select('officeId')->where('specialDayId',$id)->get();
        $arr = array(array("text" => "", "value" => ""));
        foreach($obj as $row){
            $arr[] = $row->officeId;
        }
        return $arr;
    }

    public function getMultiSelectOfficer($id){
        $obj =  DB::table('v_mef_officer')->where('office_id',$id)->select('full_name_kh','id')->get();
        $arr = array();
        foreach($obj as $row){
            $arr[] = array(
                'displayMember'     =>$row->full_name_kh,
                "valueMember"       =>$row->Id
            );
        }
        return $arr;
    }
    public function getOfficerById($id){
        $obj =  DB::table('mef_sub_specialday')->select('officerId')->where('specialDayId',$id)->get();
        $arr = array();
        foreach($obj as $row){
            $arr[] = $row->officerId;
        }
        return $arr;
    }
	
}
?>