<?php

namespace App\Models\BackEnd\CurrentAddress;
use Illuminate\Support\Facades\DB;
use Config;

class ProvinceModel
{

    public function __construct()
    {
		$this->messages = Config::get('constant');
    }

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "name_kh";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        
		$listDb = DB::table('mef_province AS pro')
            ->select('pro.*');
		$total = count($listDb->get());
        
		if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
					case 'name_en':
                        $listDb = $listDb->where('pro.name_en','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'name_kh':
                        $listDb = $listDb->where('pro.name_kh','LIKE','%'.$arrFilterValue.'%');
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
                "id"           		=> $row->id,
                "name_kh"   			=> $row->name_kh,
                "name_en"  			=> $row->name_en
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    
    public function postSave($data){
		$id = $data['Id'];
        if($id == 0){
            /* Save data */
			DB::table('mef_province')->insert([
				'name_kh' 				=>$data['name_kh'], 
				'name_en' 				=>$data['name_en']
			]);
            /* End Save data */
        }else{
            DB::table('mef_province')
				->where('id', $id)
				->update([
					'name_kh' 				=>$data['name_kh'], 
					'name_en' 				=>$data['name_en']
				]);
        }       
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
    public function postDelete($listId){
        foreach ($listId as $id){
           DB::table('mef_province')->where('id',$id)->delete();
        }
        return array("code" => 1,"message" => trans('trans.success'));
    }
	
    public function getDataByRowId($id){
        return DB::table('mef_province')->where('id', $id)->first();
    }

}
?>