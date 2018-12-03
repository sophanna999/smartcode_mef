<?php

namespace App\Models\BackEnd\Holiday;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class HolidayModel
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
        $listDb = $this->getHoliday();
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
					case 'title':
                        $listDb = $listDb->where('title','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }   

        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"           	=> $row->Id,
                "date"   		=> $this->Tool->dateformate($row->date,'/'),
				"title"	=> $row->title
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }
	private function getHoliday(){
		
		return $data = DB::table('mef_holiday')
				->whereYear('date','=', date('Y'))
				->orderBy('date', 'ASC');
				
	}
	
}
?>