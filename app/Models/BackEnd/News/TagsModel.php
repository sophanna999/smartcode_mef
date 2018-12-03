<?php

namespace App\Models\BackEnd\News;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class TagsModel
{

    public function __construct()
    {
        $this->constant = Config::get('constant');
        $this->table = Config::get('table');
		$this->Tool = new Tool();
        $this->userSession = session('sessionUser');
    }
	public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "order_number";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;
        
		$listDb = DB::table('mef_news_tag AS t')
                    ->leftJoin('mef_user AS u','u.id','=','t.create_by_user_id')
                    ->select(
                        't.Id',
                        't.name',
                        't.order_number',
                        't.icon',
                        'u.user_name'
                    );
        $total = count($listDb->get());
        

        if($filtersCount>0){			
            for ($i=0; $i < $filtersCount; $i++) {
                $arrFilterName  = isset($dataRequest['filterdatafield'.$i]) ? $dataRequest['filterdatafield'.$i] : '';
                $arrFilterValue = isset($dataRequest['filtervalue'.$i]) ? strval($dataRequest['filtervalue'.$i]) : '';
                switch($arrFilterName){
                    case 'name':
                        $listDb = $listDb->where('t.name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    case 'user_name':
                        $listDb = $listDb->where('u.user_name','LIKE','%'.$arrFilterValue.'%');
                        break;
                    default:
                        #Code...
                        break;
                }
            }
            $total = count($listDb->get());
        }
		$listDb = $listDb
				->orderBy($sort, $order)
				->take($limit)
				->skip($offset);
        $listDb = $listDb->get();
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"           				=>$row->Id,
				"name"  					=>$row->name,
				"icon"  					=>$row->icon,
                "order_number"       		=>$row->order_number,
                "user_name"                 =>ucfirst($row->user_name)
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }
    

	public function postSave($data){
        $paths = 'files/tags/';
		$row = $this->getDataByRowId($data['Id']);
		if (Input::hasFile('icon')) {
            $files = Input::file('icon');
            $size = $files->getSize();
            $extension = ".".strtolower($files->getClientOriginalExtension());
            $random_name = $this->Tool->mt_rand_str(5, '0123456789');
            $convertName = time() . "_" . $random_name . $extension;
			
			//Move image to folder
            $upload = $files->move($paths, $convertName);
			if($row != null){
				if($row->icon != ""){
					if (Storage::disk('public')->exists($row->icon)){
						Storage::disk('public')->delete($row->icon);
					}
				}
            }
            $imageUrl = $paths . $convertName;
            $data['iconPic'] = $imageUrl;
        }else{
			$data['iconPic'] = $row != null ? $row->icon:'';
		}
		/* Click remove sign */
		if($data['statusRemovePicture'] == 1){
			if (Storage::disk('public')->exists($row->icon)){
				$data['iconPic'] = '';
				Storage::disk('public')->delete($row->icon);
			}
		}

		$array = array(
            'name' 			    =>$data['name'],
			'user_mood' 	    =>$data['user_mood'],
            'order_number' 	    =>$data['order_number'],
            'icon' 			    =>$data['iconPic'],
            'mef_role_id'       =>$this->userSession->moef_role_id,
            'create_by_user_id' =>$this->userSession->id
        );
        if($data['Id'] == 0){
            /* Save data */
	        DB::table('mef_news_tag')->where('order_number','>=',$data['order_number'])->increment('order_number');
			DB::table('mef_news_tag')->insert($array);
            /* End Save data */
        }else{
            DB::table('mef_news_tag')->where('Id', $data['Id'])->update($array);
        }
        return json_encode(array("code" => 1, "message" => $this->constant['success'], "data" => ""));
    }
	public function postDelete($listId){
        $countDeleted = 0;
        foreach ($listId as $id){
            $boolean = $this->isTagTaken($id);
			$row = $this->getDataByRowId($id);
            if($boolean == 1){
				$countDeleted++;
			}else{
				if($row->icon != ''){
					if(Storage::disk('public')->exists($row->icon)){
						Storage::disk('public')->delete($row->icon);
					}
				}
				DB::table('mef_news_tag')->where('Id',$id)->delete();
			}
        }
        if($countDeleted >= 1 && count($listId) > 1){
            return array("code" => 0, "message" => $this->constant['itemsDeleted']);
        }else if($countDeleted == 1 && count($listId) == 1){
            return array("code" => 1, "message" => $this->constant['itemInUsed']);
        }else{
            return array("code" => 2,"message" => $this->constant['success']);
        }
    }
    private function isTagTaken($id){
        if(DB::table('mef_news_to_tag')->where('mef_news_tag_id',$id)->count() > 0){
            return 1;
        }else{
            return 0;
        }
    }
	public function getDataByRowId($id){
        return DB::table('mef_news_tag')->where('Id', $id)->first();
    }

}
?>