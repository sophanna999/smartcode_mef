<?php

namespace App\Models\BackEnd\Department;
use Illuminate\Support\Facades\DB;
use App\Validation\Department\ValidationDepartment;
use Config;

class DepartmentModel
{

    public function __construct()
    {
		$this->Validation = new ValidationDepartment();
		$this->messages = Config::get('constant');
    }

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "mef_secretariat_id";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DESC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
		$listDb = DB::table('mef_department AS dep')
            ->join('mef_ministry AS m','dep.mef_ministry_id', '=', 'm.Id')
			->Leftjoin('mef_secretariat AS sec','dep.mef_secretariat_id', '=', 'sec.Id')
            ->select('dep.*','m.Name AS ministry_name','sec.Name AS secretariat_name');
			
		$total = count($listDb->get());
        
		if($filtersCount>0){
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
					case 'Abbr':
                        $listDb = $listDb->where('dep.Abbr','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'Name':
                        $listDb = $listDb->where('dep.Name','LIKE','%'.$arrFilterValue.'%');
                        break;
					case 'mef_secretariat_id':
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
                "mef_secretariat_id"=> $row->secretariat_name
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
			DB::table('mef_department')->insert([
				'Name' 				=>$data['Name'], 
				'Abbr' 				=>$data['Abbr'],
				"mef_ministry_id"	=>$data['mef_ministry_id'],
				'mef_secretariat_id'=>$data['mef_secretariat_id']
			]);
            /* End Save data */
        }else{
            DB::table('mef_department')
				->where('Id', $data['Id'])
				->update([
					'Name' 				=>$data['Name'], 
					'Abbr' 				=>$data['Abbr'],
					"mef_ministry_id"	=>$data['mef_ministry_id'],
					'mef_secretariat_id'=>$data['mef_secretariat_id']
				]);
        }
       
        return json_encode(array("code" => 1, "message" => trans('trans.success'), "data" => ""));
    }
	private function isDepartmentHasUser($id){
        if(DB::table('mef_user')->where('moef_department_id',$id)->count() > 0){
            return 1;
        }else{
            return 0;
        }
    }
  /*  public function postDelete($listId){
        foreach ($listId as $id){
             DB::table('mef_department')->where('Id',$id)->delete();
        }
        return array("code" => 1,"message" => trans('trans.success'));
    }*/


    private function isDepartmentBusy($id){
        $numberOfRow = DB::table('mef_service_status_information')
            ->where('FIRST_DEPARTMENT',$id)
            ->orWhere('CURRENT_DEPARTMENT', $id)
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
            $boolean = $this->isDepartmentBusy($id);
            if($boolean == 1){
                $countDeleted++;
            }else{
                DB::table('mef_department')->where('Id',$id)->delete();
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
        $arrList = DB::table('mef_ministry')->OrderBy('Id', 'DESC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->Name,
                "value" => $row->Id
            );
        }
        return $arr;
    }
	public function getAllSecretariatByMinistry($mef_ministry_id){
        $arrList = DB::table('mef_secretariat')->where('mef_ministry_id',$mef_ministry_id)->OrderBy('Id', 'DESC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
    public function getDataByRowId($id){
        return DB::table('mef_department')->where('Id', $id)->first();
    }

}
?>