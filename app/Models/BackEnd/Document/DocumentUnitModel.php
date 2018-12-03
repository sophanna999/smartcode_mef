<?php

namespace App\Models\BackEnd\Document;
use Illuminate\Support\Facades\DB;
use Config;

class DocumentUnitModel
{
    public $tb_name = 'fm_unit';
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
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "order_number";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;

        $listDb = DB::table('fm_unit as un')
            ->Join('mef_user as u','u.id','=','un.user_id')
             ->select(
                'un.id',
                'un.unit_name',
                'un.address',
                'un.email',
                'un.website',
                'un.order_number',
                'un.active',
                'un.created_date',
                'un.modify_date',
                'u.user_name'
                )
            ->orderBy('un.order_number','DESC');
		$total = count($listDb->get());
        $listDb = $listDb
				->OrderBy($sort, $order)
				->take($limit)
				->skip($offset);
        $listDb = $listDb->get();
        $list = array();

        return json_encode(array('total'=>$total,'items'=>$listDb));
    }

    
    public function postSave($data){
        $input = [
            'user_id'                   =>$this->userSession->id,
            'unit_name'        	        => $data['unit_name'],
            'address'                   => $data['address'],
            'email'                     => $data['email'],
            'website'                   => $data['website'],
            'order_number'              => $data['order_number'],
            'active'                    => isset($data['active'])? $data['active'] : 0,

        ];
        $duplicate_file = DB::table('fm_unit')->where('unit_name',$input['unit_name'])->get();
        if(count($duplicate_file) >0){
            return json_encode(array("code" => 0, "message" => "ឈ្មោះក្រុមហ៊ុននេះមានរួចហើយ សូមពិនិត្យមើលម្តងទៀត " .$input['unit_name'], "data" => ""));
        }else{
            if($data['id'] == 0){
                /* Save data */
                $input['created_date'] = date('Y-m-d H:i:s');
                $id = DB::table($this->tb_name)->insertGetId($input);
                /* End Save data */
            }else{
                $id = $data['id'];
                $input['modify_date'] = date('Y-m-d H:i:s');
                DB::table('fm_unit')
                    ->where('id', $data['id'])
                    ->update($input);
            }
        }
       // return $id;
        $array = array('id'=>$id,'text'=>$data['unit_name']);
       return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" =>$array));
    }

    private function isTitleInUsed($id){
        if(DB::table('fm_unit')->where('id',$id)->count() > 0){
            return 1;
        }else{
            return 0;
        }
    }

    public function postDelete($id){
        DB::table('fm_unit')->where('id',$id)->delete();
        $result =  array("code" => 2,"message" => trans('trans.success'));
        return json_encode($result);
    }

    public function getDataByRowId($id){
        return DB::table('fm_unit')->where('id', $id)->first();
    }
}
?>