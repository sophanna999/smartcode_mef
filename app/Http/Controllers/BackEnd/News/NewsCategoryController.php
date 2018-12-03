<?php
namespace App\Http\Controllers\BackEnd\News;

use App\Http\Controllers\BackendController;
use App\Models\BackEnd\News\NewsCategoryModel;
use Illuminate\Http\Request;
use Config;
use Intervention\Image\Facades\Image;

class NewsCategoryController extends BackendController
{

	public function __construct()
	{
		parent::__construct();
		$this->messages = Config::get('constant');
		$this->newsCategory = new NewsCategoryModel();
	}

	public function getIndex()
	{
		$this->data['category_status'] = json_encode(['Internal', 'External']);
		return view($this->viewFolder . '.news.category.index')->with($this->data);
	}

	public function postIndex(Request $request)
	{

		return $this->newsCategory->getDataGrid($request->all());
	}

	public function postNew(Request $request)
	{
		return $this->loadView($request);
	}

	public function postEdit(Request $request)
	{
		return $this->loadView($request);
	}

	private function loadView(Request $request)
	{
	    $category = $this->newsCategory->getAllNewsCategory();
		$cate_status = [['text'=>'Internal','value'=>1],['text'=>'External','value'=>2]];
		$this->data['status'] = json_encode($cate_status);
		$this->data['news_category'] = $category;
		$this->data['row'] = $this->newsCategory->getDataByRowId($request['Id']);
		return view($this->viewFolder . '.news.category.new')->with($this->data);
	}

	public function postSave(Request $request)
	{
		$row = [];
		$icon_path='';
		$input = $request->all();
		$icon = $request->file('icon');
		if ($icon!=null) $icon_path = $this->uploadAndResize($icon);
		$input['icon'] = $icon_path;
		$id = $this->newsCategory->postSave($input);
		return json_encode(array("code" => 1, "message" => $this->messages['success'], "data" => ""));
	}

	public function postDelete(Request $request)
	{
		$listId = isset($request['Id']) ? $request['Id'] : '';
		return $this->newsCategory->postDelete($listId);
	}

	private function uploadAndResize($image, $size=120)
	{
		$uploadPath = 'files/category_icons';
		try
		{
			$extension 		= 	$image->getClientOriginalExtension();
			$imageRealPath 	= 	$image->getRealPath();
			$random_name = $this->data['tool']->mt_rand_str(5, '0123456789');
			$thumbName = time() . "_" . $random_name .".". $extension;

			$img = Image::make($imageRealPath); // use this if you want facade style code
			$img->resize(intval($size), null, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save(public_path($uploadPath). '/'. $thumbName);
			return $uploadPath.'/'.$img->basename;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
}
