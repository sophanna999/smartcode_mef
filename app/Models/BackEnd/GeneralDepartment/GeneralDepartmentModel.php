<?php

namespace App\Models\BackEnd\GeneralDepartment;
use Illuminate\Support\Facades\DB;
use Config;

class GeneralDepartmentModel
{

    public function __construct()
    {
		$this->messages = Config::get('constant');
    }

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "Name";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        
		$listDb = DB::table('mef_secretariat AS sec')
            ->join('mef_ministry AS m','sec.mef_ministry_id', '=', 'm.Id')
            ->select('sec.*','m.Name AS ministry_name');
		$total = count($listDb->get());
        
		if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
					case 'Abbr':
                        $listDb = $listDb->where('sec.Abbr','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'Name':
                        $listDb = $listDb->where('sec.Name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }		
		$listDb = $listDb
				->OrderBy($sort, $order)
				->take($limit)
				->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"           		=> $row->Id,
                "Name"   			=> $row->Name,
                "Abbr"  			=> $row->Abbr,
                "mef_ministry_id"	=> $row->ministry_name,
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    
    public function postSave($data){
        if($data['Id'] == 0){
            /* Save data */
			DB::table('mef_secretariat')->insert([
				'Name' 				=>$data['Name'], 
				'Abbr' 				=>$data['Abbr'],
				'mef_ministry_id'	=>$data['mef_ministry_id']
			]);
            /* End Save data */
        }else{
            DB::table('mef_secretariat')
				->where('Id', $data['Id'])
				->update([
					'Name' 				=>$data['Name'], 
					'Abbr' 				=>$data['Abbr'],
					'mef_ministry_id'	=>$data['mef_ministry_id']
				]);
        }
       
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
   /* public function postDelete($listId){
        foreach ($listId as $id){
           DB::table('mef_secretariat')->where('Id',$id)->delete();
        }
        return array("code" => 1,"message" => trans('trans.success'));
    }*/

    private function isGeneralDepartmentBusy($id){
        $numberOfRow = DB::table('mef_service_status_information')
            ->where('FIRST_GENERAL_DEPARTMENT',$id)
            ->orWhere('CURRENT_GENERAL_DEPARTMENT', $id)
            ->count();
        if($numberOfRow > 0){
            return 1;
        }else{
            return 0;
        }
    }

    public function postDelete($listId){
        //print_r("hello"); exit();
        $countDeleted = 0;
        foreach ($listId as $id){
            $boolean = $this->isGeneralDepartmentBusy($id);
            if($boolean == 1){
                $countDeleted++;
            }else{
                DB::table('mef_secretariat')->where('Id',$id)->delete();
            }
        }
        if($countDeleted >= 1 && count($listId) > 1){
            return array("code" => 0, "message" => $this->messages['itemsDeleted']);
        }else if($countDeleted == 1 && count($listId) == 1){
            return array("code" => 1, "message" => trans('trans.itemInUsed'));
        }else{
            return array("code" => 2,"message" => trans('trans.success'));
        }
    }


	public function getAllMinistry(){
        $arrList = DB::table('mef_ministry')->orderBy('Id', 'DESC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->Name,
                "value" => $row->Id
            );
        }
        return json_encode($arr);
    }
	
	
    public function getDataByRowId($id){
        return DB::table('mef_secretariat')->where('Id', $id)->first();
    }

}
?>