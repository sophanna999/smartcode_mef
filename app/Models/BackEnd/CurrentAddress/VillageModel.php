<?php

namespace App\Models\BackEnd\CurrentAddress;
use Illuminate\Support\Facades\DB;
use Config;

class VillageModel
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
        
		$listDb = DB::table('mef_villages AS vil')
			->join('mef_commune as comm', 'comm.id', '=', 'vil.mef_commune_id')
			->join('mef_districts as dis', 'dis.id', '=', 'comm.mef_district_id')
			->join('mef_province as pro', 'pro.id', '=', 'dis.mef_province_id')
            ->select('vil.*','comm.name_kh as name_kh_comm','dis.name_kh as name_kh_dis','pro.name_kh as name_kh_pro');
		$total = count($listDb->get());
        
		if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
					case 'name_en':
                        $listDb = $listDb->where('vil.name_en','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'name_kh':
                        $listDb = $listDb->where('vil.name_kh','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'name_kh_pro':
                        $listDb = $listDb->where('pro.name_kh','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'name_kh_dis':
                        $listDb = $listDb->where('dis.name_kh','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'name_kh_comm':
                        $listDb = $listDb->where('comm.name_kh','LIKE','%'.$arrFilterValue.'%');
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
                "name_kh"   		=> $row->name_kh,
                "name_en"  			=> $row->name_en,
				"name_kh_pro"		=> $row->name_kh_pro,
				"name_kh_dis"		=> $row->name_kh_dis,
				"name_kh_comm"		=> $row->name_kh_comm
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    
    public function postSave($data){
		$id = $data['Id'];
        if($id == 0){
            /* Save data */
			DB::table('mef_villages')->insert([
				'name_kh' 				=>$data['name_kh'], 
				'name_en' 				=>$data['name_en'],
				'mef_commune_id'  		=>$data['mef_commune_id']
			]);
            /* End Save data */
        }else{
            DB::table('mef_villages')
				->where('id', $id)
				->update([
					'name_kh' 				=>$data['name_kh'], 
					'name_en' 				=>$data['name_en'],
					'mef_commune_id'  		=>$data['mef_commune_id']
				]);
        }       
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
    public function postDelete($listId){
        foreach ($listId as $id){
           DB::table('mef_villages')->where('id',$id)->delete();
        }
        return array("code" => 1,"message" => trans('trans.success'));
    }
	
    public function getDataByRowId($id){
		$listDb = DB::table('mef_villages AS vil')
			->join('mef_commune as comm', 'comm.id', '=', 'vil.mef_commune_id')
			->join('mef_districts as dis', 'dis.id', '=', 'comm.mef_district_id')
			->join('mef_province as pro', 'pro.id', '=', 'dis.mef_province_id')
            ->select('vil.*', 'dis.id as mef_district_id', 'pro.id as mef_province_id');
        return $listDb->where('vil.id', $id)->first();
    }
	
	public function getListProvince(){
        $arrList = DB::table('mef_province')->orderBy('name_kh', 'ASC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->name_kh,
                "value" => $row->id
            );
        }
        return $arr;
    }
	public function getListDistricts($mef_province_id = null){
		$query = DB::table('mef_districts')->orderBy('name_kh', 'ASC');
		if($mef_province_id != null){
			$query = $query->where('mef_province_id',$mef_province_id);
		}
        $arrList = $query->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->name_kh,
                "value" => $row->id
            );
        }
        return $arr;
    }
	public function getListCommune($mef_district_id = null){
		$query = DB::table('mef_commune')->orderBy('name_kh', 'ASC');
		if($mef_district_id != null){
			$query = $query->where('mef_district_id', $mef_district_id);
		}
        $arrList = $query->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->name_kh,
                "value" => $row->id
            );
        }
        return $arr;
    }

}
?>