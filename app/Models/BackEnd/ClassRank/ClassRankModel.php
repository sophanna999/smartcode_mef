<?php

namespace App\Models\BackEnd\ClassRank;
use Illuminate\Support\Facades\DB;
use Config;
class ClassRankModel
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
        $listDb = DB::table('mef_class_ranks');
		$total = count($listDb->get());
        $listDb = $listDb
				->OrderBy($sort, $order)
				->take($limit)
				->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"    =>$row->Id,
                "Name"  =>$row->Name,
				"Order"	=>$row->Order
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    
    public function postSave($data){
        if($data['Id'] == 0){
            /* Save data */
			DB::table('mef_class_ranks')->insert([
				'Name' 		=>$data['Name'],
				'Order'		=>$data['Order']
			]);
            /* End Save data */
        }else{
            DB::table('mef_class_ranks')
				->where('Id', $data['Id'])
				->update([
				'Name'		=>$data['Name'],
				'Order'		=>$data['Order']
				]);
        }
       
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
	
   /* public function postDelete($listId){
        foreach ($listId as $id){
			DB::table('mef_class_ranks')->where('Id',$id)->delete();
        }
        return array("code" => 1,"message" => trans('trans.success'));
    }*/


    private function isClassRankBusy($id){
        $numberOfRow = DB::table('mef_service_status_information')
            ->where('CURRENT_OFFICER_CLASS',$id)
            ->orWhere('FIRST_OFFICER_CLASS', $id)
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
            $boolean = $this->isClassRankBusy($id);
            if($boolean == 1){
                $countDeleted++;
            }else{
                DB::table('mef_class_ranks')->where('Id',$id)->delete();
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



    public function getDataByRowId($id){
        return DB::table('mef_class_ranks')->where('Id', $id)->first();
    }
}
?>