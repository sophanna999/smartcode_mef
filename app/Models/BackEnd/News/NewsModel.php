<?php

namespace App\Models\BackEnd\News;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\libraries\Tool;

use Config;

class NewsModel
{

	public $tb_name = 'mef_news';

	public function __construct()
	{
		$this->messages = Config::get('constant');
		$this->userSession = session('sessionUser');
		$this->Tool = new Tool();
	}

	public function getDataGrid($dataRequest)
	{
		$page = $dataRequest['pagenum'] ? intval($dataRequest['pagenum']) : 0;
		$limit = $dataRequest['pagesize'] ? intval($dataRequest['pagesize']) : $this->constant['pageSize'];
		$sort = isset($dataRequest['sortdatafield']) ? strval($dataRequest['sortdatafield']) : "create_date";
		$order = isset($dataRequest['sortorder']) ? strval($dataRequest['sortorder']) : "DEC";
		$offset = $page * $limit;
		$filtersCount = isset($dataRequest['filterscount']) ? intval($dataRequest['filterscount']) : 0;

		$listDb = DB::table('mef_news AS n')
			->leftJoin('mef_user AS u', 'n.create_by_user_id', '=', 'u.id')
			->join('mef_news_category AS c', 'n.mef_news_category_id', '=', 'c.Id')
			->select('n.*', 'u.user_name', 'c.name as news_category');
		$total = count($listDb->get());
		if ($filtersCount > 0) {
			for ($i = 0; $i < $filtersCount; $i++) {
				$arrFilterName = isset($dataRequest['filterdatafield' . $i]) ? $dataRequest['filterdatafield' . $i] : '';
				$arrFilterValue = isset($dataRequest['filtervalue' . $i]) ? strval($dataRequest['filtervalue' . $i]) : '';
				switch ($arrFilterName) {
					case 'title':
						$listDb = $listDb->where('n.title', 'LIKE', '%' . $arrFilterValue . '%');
						break;
					case 'short_description':
						$listDb = $listDb->where('n.short_description', 'LIKE', '%' . $arrFilterValue . '%');
						break;
					case 'create_by_user_id':
						$listDb = $listDb->where('u.user_name', 'LIKE', '%' . $arrFilterValue . '%');
						break;
					case 'news_category':
						$listDb = $listDb->where('c.name', 'LIKE', '%' . $arrFilterValue . '%');
						break;
					case 'create_date' :
						$arrFilterValue = \DateTime::createFromFormat('d/m/Y', $arrFilterValue)->format('Y-m-d');
						$listDb = $listDb->where('n.create_date','LIKE','%'.$arrFilterValue.'%');
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
		foreach ($listDb as $row) {
			$list[] = array(
				"Id"                => $row->Id,
				"title"             => $row->title,
				"short_description" => $row->short_description,
				"is_publish"        => $row->is_publish,
				"latest_news"       => $row->latest_news,
				"image"             => $row->image,
				'create_date'       =>$row->create_date,
				'is_mef_news'       => $row->is_mef_news,
				"create_by_user_id" => ucfirst($row->user_name),
				"news_category"     =>$row->news_category
			);
		}
		return json_encode(array('total' => $total, 'items' => $list));
	}


	public function postSave($data)
	{

		$paths = "files/news/";
		$rowResource = $this->getDataByRowId($data['Id']);
		if (Input::hasFile('image')) {
			$files = Input::file('image');
			$size = $files->getSize();
			$extension = "." . strtolower($files->getClientOriginalExtension());
			$random_name = $this->Tool->mt_rand_str(5, '0123456789');
			$convertName = time() . "_" . $random_name . $extension;

			//Move image to folder
			$upload = $files->move($paths, $convertName);
			if ($rowResource != null) {
				if ($rowResource->image != "") {
					if (Storage::disk('public')->exists($rowResource->image)) {
						Storage::disk('public')->delete($rowResource->image);
					}
				}
			}
			$imageUrl = $paths . $convertName;
			$data['image'] = $imageUrl;
		} else {
			$data['image'] = $rowResource != null ? $rowResource->image : '';
		}
		$input = [
			'create_by_user_id'     => $this->userSession->id,
            'mef_role_id'           =>$this->userSession->moef_role_id,
			'mef_news_category_id'  => $data['news_category'],
			'mef_news_tag_id'  => $data['news_tag'],
			'title'                 => $data['title'],
			'image'                 => $data['image'],
			'url'                   => $data['url'],
			'short_description'     => $data['short_description'],
			'long_description'      => $data['long_description'],
			'is_mef_news'           => isset($data['is_mef_news']) ? $data['is_mef_news'] : 0,
			'latest_news'           => isset($data['latest_news']) ? $data['latest_news'] : 0,
			'is_publish'            => isset($data['is_publish']) ? $data['is_publish'] : 0,
		];
		if ($data['Id'] == 0) {
			/* Save data */
			$input['create_date'] = date('Y-m-d H:i:s');
			$id = DB::table($this->tb_name)->insertGetId($input);
			/* End Save data */
		} else {
			$id = $data['Id'];
			$input['update_date'] = date('Y-m-d H:i:s');
			DB::table($this->tb_name)
				->where('Id', $data['Id'])
				->update($input);
		}

		//push notification to mobile
        $category = DB::table('mef_news_category')->where('id',$data['news_category'])->get(); //get category name
//        $url = 'http://192.168.101.203:3000/v1/new/newinfo'; //ip b menglay
        $url = 'http://103.216.50.171:3200/v1/new/newinfo';
        $fields =(object) [
            'user_id' => $this->userSession->id,
            'info_id' => $id,
            'info_type' => $category[0]->name,
            'info_title' => $data['title'],
        ];
        $data_string = json_encode($fields);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
//							'Content-Length: ' . strlen($data_string))
        );

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data_string);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $e = new \Exception(curl_error($curl), curl_errno($curl));
            curl_close($curl);
            throw $e;
        }


		$this->makeRelationNewWithTag($id, explode(",",$data['news_tag']));
		return $id;
	}

	public function makeRelationNewWithTag($news_id, $arr_tags){
		$tb_name = 'mef_news_to_tag';
		DB::table($tb_name)->where('mef_news_id',$news_id)->delete();
		foreach ($arr_tags as $tag){
			DB::table($tb_name)->insert(['mef_news_id'=>$news_id, 'mef_news_tag_id'=>$tag]);
		}
	}

	public function postDelete($listId)
	{
		DB::table($this->tb_name)->whereIn('Id', $listId)->delete();
		return array("code" => 1, "message" => $this->messages['success']);
	}

	public function getDataByRowId($id)
	{
		$row = DB::table($this->tb_name)->where('Id', $id)->first();
		if ($row != null) {
//			$row->create_date = \DateTime::createFromFormat('Y-m-d H:m:s', $row->create_date)->format('d/m/Y');
			$row->news_tag = $this->getTagsByNewsId($id);
			$row->cate_of_news = $this->getCategoryById($row->mef_news_category_id);
			return $row;
		} else {
			return array();
		}
	}

	public function getCategoryById($id){
		$result = DB::table('mef_news_category')->where('Id', $id)->first();
		return $result;
	}

	public function getAllCategories()
	{
		$newsCategories = DB::table('mef_news_category')->get();
		$arr = array(array("text" => "", "value" => ""));
		foreach ($newsCategories as $row) {
			$arr[] = array(
				'text' => $row->name,
				"value" => $row->Id
			);
		}
		return $arr;
	}

	public function getTagsByNewsId($id){
		$result = DB::table('mef_news_to_tag')->where('mef_news_id', $id)->get();
		return $result;
	}

	public function getAllNewsTag(){
		$result = DB::table('mef_news_tag')->get();
		$arr = array(array("text"=>"", "value" => ""));
		foreach($result as $row){
			$arr[] = array(
				'text' 	=> $row->name,
				"value" => $row->Id
			);
		}
		return $arr;
	}


}

?>