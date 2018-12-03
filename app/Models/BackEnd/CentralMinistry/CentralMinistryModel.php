<?php

namespace App\Models\BackEnd\CentralMinistry;
use Illuminate\Support\Facades\DB;
use App\Validation\CentralMinistry\ValidationCentralMinistry;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;


class CentralMinistryModel
{

    public function __construct()
    {
		$this->messages = Config::get('constant');
		$this->Validation = new ValidationCentralMinistry();
		$this->Tool = new Tool();
    }
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "Id";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        $listDb = DB::table('mef_ministry');
        $total = count($listDb->get());
        $listDb = $listDb
				->OrderBy($sort, $order)
				->take($limit)
				->skip($offset);       
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"           		=> $row->Id,
                "Name"              => $row->Name,
				"Abbr"				=> $row->Abbr
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
		
		$row = $this->getDataByRowId($data['Id']);
		$inputData = array(
            'Name'      =>$data['Name'] ,
			'Abbr'		=>$data['Abbr']
            );
        if($data['Id'] == 0){
			DB::table('mef_ministry')->insert($inputData);
        }else{
            DB::table('mef_ministry')->where('Id',$data['Id'])->update($inputData);
        }
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }

	/*public function postDelete($listId){
        foreach ($listId as $id){
            DB::table('mef_ministry')->where('Id',$id)->delete();
        }
       return array("code" => 1,"message" => trans('trans.success'));
    }*/

    private function isMinistryBusy($id){
        $numberOfRow = DB::table('mef_service_status_information')
            ->where('FIRST_MINISTRY',$id)
            ->orWhere('CURRENT_MINISTRY', $id)
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
            $boolean = $this->isMinistryBusy($id);
            if($boolean == 1){
                $countDeleted++;
            }else{
                DB::table($this->table['mef_ministry'])->where('ID',$id)->delete();
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
        return DB::table('mef_ministry')->where('Id', $id)->first();
    }
}
?>