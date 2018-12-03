<?php

namespace App\Models\BackEnd\Title;
use Illuminate\Support\Facades\DB;
use Config;

class titleModel
{

    public function __construct()
    {
		//$this->Validation = new ValidationPosition();
		$this->messages = Config::get('constant');
        $this->table = Config::get('table');
    }

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "order_number";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = DB::table('mef_title');
		$total = count($listDb->get());
        $listDb = $listDb
				->OrderBy($sort, $order)
				->take($limit)
				->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "id"           	=> $row->id,
                "name"   		=> $row->name,
				"order_number"	=> $row->order_number
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    
    public function postSave($data){

        if($data['id'] == 0){
            /* Save data */
			DB::table('mef_title')->insert([
				'name' 		    =>$data['name'],
				'order_number' 	=>$data['order_number']
			]);
            /* End Save data */
        }else{
            DB::table('mef_title')
				->where('id', $data['id'])
				->update([
                    'name' 		    =>$data['name'],
                    'order_number' 	=>$data['order_number']
				]);
        }
       
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }

    private function isTitleInUsed($id){
        if(DB::table('mef_personal_information')->where('TITLE_ID',$id)->count() > 0){
            return 1;
        }else{
            return 0;
        }
    }

    public function postDelete($listId){
        $countDeleted = 0;
        foreach ($listId as $id){
            $boolean = $this->isTitleInUsed($id);
            if($boolean == 1){
                $countDeleted++;
            }else{
                DB::table('mef_title')->where('id',$id)->delete();
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
        return DB::table('mef_title')->where('id', $id)->first();
    }

	
}
?>