<?php

namespace App\Models\BackEnd\Document;
use Illuminate\Support\Facades\DB;
use Config;

class DocumentTypeModel
{
    public $tb_name = 'fm_document_type';
    public function __construct()
    {
		//$this->Validation = new ValidationPosition();
		$this->messages = Config::get('constant');
        $this->userSession = session('sessionUser');
        $this->table = Config::get('table');
    }

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "id";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;

        $listDb = DB::table('mef_user as u')
                ->Join('fm_document_type as d','u.id','=','d.user_id')
                ->select(
                    'd.*',
                    'u.user_name'
                )
                ->orderBy('d.id','DESC');
		$total = count($listDb->get());
        $listDb = $listDb
				->OrderBy($sort, $order)
				->take($limit)
				->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "id"           	    => $row->id,
                "document_type"   	=> $row->document_type,
                "user_name"         =>ucfirst($row->user_name)
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

    
    public function postSave($data){
        $input = [
            'user_id'                   =>$this->userSession->id,
            'document_type' 		    =>$data['document_type']
        ];

        if($data['id'] == 0){
            /* Save data */
            $input['created_date'] = date('Y-m-d H:i:s');
            $id = DB::table($this->tb_name)->insertGetId($input);
			/* End Save data */
        }else{
            $id = $data['id'];
            $input['modify_date'] = date('Y-m-d H:i:s');
            DB::table('fm_document_type')
				->where('id', $data['id'])
                ->update($input);
        }
        //return $id;
        $array = array('id'=>$id,'text'=>$data['document_type']);
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => $array));
    }

    private function isTitleInUsed($id){
        if(DB::table('fm_document_type')->where('id',$id)->count() > 0){
            return 1;
        }else{
            return 0;
        }
    }

    public function postDelete($id){
        DB::table('fm_document_type')->where('id',$id)->delete();
        $result =  array("code" => 2,"message" => trans('trans.success'));
        return json_encode($result);
    }

    public function getDataByRowId($id){
        return DB::table('fm_document_type')->where('id', $id)->first();
    }

	
}
?>