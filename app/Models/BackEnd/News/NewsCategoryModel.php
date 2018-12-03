<?php

namespace App\Models\BackEnd\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\libraries\Tool;

use Config;
class NewsCategoryModel
{

	public $tb_name = 'mef_news_category';
    public function __construct()
    {
		$this->messages = Config::get('constant');
	    $this->constant = Config::get('constant');
		$this->userSession = session('sessionUser');
		$this->Tool = new Tool();
    }

    public function getDataGrid($dataRequest){
        $page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
        $limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
        $sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "order_number";
        $order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "ASC";
        $offset = $page*$limit;
        $filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;

		$listDb = DB::table($this->tb_name.' AS n')
                ->leftJoin('mef_user AS u','u.id','=','n.create_by_user_id')
                ->select(
                    'n.*',
                    'u.user_name'
                )
                ->orderBy('order_number','asc');
        $listDb = $listDb->get();
        $total = count($listDb);
        $list = array();
        foreach($listDb as $row){
            $list[] = array(
                "Id"           		=>$row->Id,
                "name"   			=>$row->name,
                "user_name"         =>ucfirst($row->user_name),
                "order_number"		=>$row->order_number,
	            "icon"              =>$row->icon,
                "parent_id"         =>$row->parent_id,
	            "category_status"   =>($row->category_status==1)?"Internal":"External",
            );
        }
        return json_encode(array('total'=>$total,'items'=>$list));
    }

	public function postSave($data){
		$input = [
            'create_by_user_id'     =>$this->userSession->id,
            'mef_role_id'           =>$this->userSession->moef_role_id,
			'name'                  =>$data['name'],
			'order_number'          =>$data['order_number'],
            'parent_id'             =>intval($data['parent_id']),
			'category_status'       =>($data['category_status']==0)?1:$data['category_status'],
			'icon'                  =>$data['icon']
		];
		if($data['Id'] == 0){
			/* Save data */
			DB::table($this->tb_name)->where('order_number','>=',$input['order_number'])->increment('order_number');
			$id = DB::table($this->tb_name)->insertGetId($input);
			/* End Save data */
		}else{
			$id = $data['Id'];
			$row = $this->getDataByRowId($id);
			if (!empty($row)){
				if ($row->icon != "") {
					if (Storage::disk('public')->exists($row->icon)) {
						Storage::disk('public')->delete($row->icon);
					}
				}
				$input['icon'] = ($input['icon']!='')?$input['icon']:$row->icon;
			}
			DB::table($this->tb_name)->where('Id', $data['Id'])->update($input);
		}
		return $id;
	}

	private function isTagTaken($id){
		if(DB::table('mef_news')->where('mef_news_category_id',$id)->count() > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function postDelete($id){
        $hasParent = DB::table($this->tb_name)->where('parent_id',$id)->count();
        $isUsed = $this->isTagTaken($id);
        $row = $this->getDataByRowId($id);
        if ($hasParent>0) {
            $result = array("code" => 0, "message" => trans('trans.itemInUsed'), "data" => "data");
        }else if(!$isUsed && $row){
            if(Storage::disk('public')->exists($row->icon)){
                Storage::disk('public')->delete($row->icon);
            }
            DB::table($this->tb_name)->where('Id',$id)->delete();
            $result =  array("code" => 1,"message" => trans('trans.success'));
        }else{
            DB::table($this->tb_name)->where('Id',$id)->delete();
            $result =  array("code" => 1,"message" => trans('trans.success'));
        }

        return json_encode($result);
    }

    public function getDataByRowId($id){
        $row = DB::table($this->tb_name)->where('Id', $id)->first();
		if($row != 'null'){
			return $row;
		}else{
			return array();
		}
    }
    public function getAllNewsCategory(){
        $listDb = DB::table($this->tb_name)
                    ->select(
                        'Id',
                        'parent_id',
                        'name'
                    )
                    ->where('parent_id',0)
                    ->orderBy('order_number','ASC')
                    ->get();
        $arrList = array();
        foreach($listDb as $row){
            $arrList[] = array(
                "id"        =>$row->Id,
                "value"     =>$row->Id,
                "parentid"  =>$row->parent_id,
                "text"		=>$row->name
            );
        }
        return $arrList;
    }
}
?>