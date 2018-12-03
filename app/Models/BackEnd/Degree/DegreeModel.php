<?php

namespace App\Models\BackEnd\Degree;
use Illuminate\Support\Facades\DB;
use Config;
class DegreeModel
{
    public function __construct()
    {
		$this->messages = Config::get('constant');
        $this->table = Config::get('table');
    }

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "Order";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = DB::table('mef_degree');
		$total = count($listDb->get());
        $listDb = $listDb
				->orderBy($sort, $order)
				->take($limit)
				->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"    =>$row->Id,
                "Name"  =>$row->Name,
				"Type"  =>$row->Type,
				"Order"	=>$row->Order
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    
    public function postSave($data){
        if($data['Id'] == 0){
            /* Save data */
			DB::table('mef_degree')->insert([
				'Name' 		=>$data['Name'],
				'Type' 		=>$data['Type'],
				'Order' 	=>$data['Order']
			]);
            /* End Save data */
        }else{
            DB::table('mef_degree')
				->where('Id', $data['Id'])
				->update([
					'Name'		=>$data['Name'],
					'Type' 		=>$data['Type'],
					'Order' 	=>$data['Order']
				]);
        }
       
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
	
    public function postDelete($listId){
        foreach ($listId as $id){
			DB::table('mef_degree')->where('Id',$id)->delete();
        }
        return array("code" => 1,"message" => trans('trans.success'));
    }

    public function getDataByRowId($id){
        return DB::table('mef_degree')->where('Id', $id)->first();
    }
}
?>