<?php

namespace App\Models\BackEnd\Position;
use Illuminate\Support\Facades\DB;
use App\Validation\Position\ValidationPosition;
use Config;

class PositionModel
{

    public function __construct()
    {
        $this->Validation = new ValidationPosition();
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
    }

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "ORDER_NUMBER";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = DB::table($this->table['MEF_POSITION']);
        $total = count($listDb->get());
        $listDb = $listDb
            ->OrderBy($sort, $order)
            ->take($limit)
            ->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "ID"           	=> $row->ID,
                "NAME"   		=> $row->NAME,
                "ORDER_NUMBER"	=> $row->ORDER_NUMBER
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }


    public function postSave($data){
        /* Validation Insert Data */
        $validator = $this->Validation->validationSaveEdit($data);
        if ($validator->fails()) {
            $error = json_encode($validator->messages());
            $arrayError = json_decode($error);
            $message = "";
            foreach($data as $key => $val){
                if (isset($arrayError->{$key})) {
                    $message.= $arrayError->{$key}[0].  "<br>";
                }
            }
            return json_encode(array("code" => 0, "message" => $message, "data" => ""));
        }
        /* Validation Insert Data End */

        if($data['Id'] == 0){
            /* Save data */
            DB::table($this->table['MEF_POSITION'])->insert([
                'NAME' 		    =>$data['NAME'],
                'MEMBER_ID'     =>$data['position'],
                'ORDER_NUMBER' 	=>$data['ORDER_NUMBER']
            ]);
            /* End Save data */
        }else{
            DB::table($this->table['MEF_POSITION'])
                ->where('ID', $data['Id'])
                ->update([
                    'NAME' 		    =>$data['NAME'],
                    'MEMBER_ID'     =>$data['position'],
                    'ORDER_NUMBER' 	=>$data['ORDER_NUMBER']
                ]);
        }

        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
    private function isPositionInUsed($id){
        if(DB::table($this->table['MEF_USER'])->where('ID',$id)->count() > 0){
            return 1;
        }else{
            return 0;
        }
    }
    private function isPositionBusy($id){
        $numberOfRow = DB::table('mef_service_status_information')
            ->where('FIRST_POSITION',$id)
            ->orWhere('ADDITIONAL_POSITION', $id)
            ->orWhere('CURRENT_POSITION',$id)
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
            $boolean = $this->isPositionBusy($id);
            if($boolean == 1){
                $countDeleted++;
            }else{
                DB::table($this->table['MEF_POSITION'])->where('ID',$id)->delete();
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
        return DB::table($this->table['MEF_POSITION'])->where('ID', $id)->first();
    }
    public function getPositionIdByName($position){
        $row = DB::table($this->table['MEF_POSITION'])->select('ID')->where('NAME',$position)->first();
        return $row->ID;
    }

    public function getPositionViewer(){
        $list_position = DB::table('mef_position')->orderBy('ORDER_NUMBER','asc')->get();
        $arr = array(array("displayMember"=>"", "valueMember" => ""));
        foreach($list_position as $row){
            $arr[] = array(
                'displayMember' => $row->NAME,
                "valueMember" => $row->ID
            );
        }
        return json_encode($arr);
    }
    public function getListPosition(){
        $arr = array(array('text'=>'','value'=>''));
        $obj =  DB::table('mef_position')
            ->select(
                'ID AS value',
                'NAME AS text')
            ->orderBy('ORDER_NUMBER','ASC')
            ->get();
        return array_merge($arr,$obj);
    }
    //public function getListPositionByMemberId($member_id){

    //$arr = array(array('text'=>'','value'=>''));
    //$obj =  DB::table('mef_position')
    // ->select(
    // 'ID AS value',
    // 'NAME AS text')
    //->where('ID', $member_id)
    // ->orderBy('ORDER_NUMBER','ASC')
    // ->get();
    //return array_merge($arr,$obj);
    // }

    public function getListPositionByMemberId($ids){
        $obj = array();
        if(!empty($ids)){
            foreach ($ids as $key => $value){
                $obj[] =  array(
                    "text" => DB::table('mef_position')->select('NAME')->where('ID',$value)->first(),
                    "value" => $value,
                );
            }
        }
        return $obj;
    }

}
?>