<?php
namespace App\Repositories\Document;
use App\Models\BackEnd\Document\Setting;
use App\Models\BackEnd\Document\Source;
use App\Models\BackEnd\Document\Flow;
use App\Models\BackEnd\Document\Category;
use App\Models\BackEnd\Document\Privacy;
class SettingRepository extends BaseRepository
{
    protected $model;

    public function __construct(Setting $Setting,Source $Source,Flow $Flow,Category $Category,Privacy $Privacy)
    {
		$this->model = $Setting;
		$this->sources = $Source;
		$this->flows = $Flow;
		$this->categories = $Category;
		$this->privacys = $Privacy;
    }
	public function source(){
		return $this->sources->get();
	}
	public function privacy(){
		return $this->privacys->get();
	}
	public function flow(){
		return $this->flows->get();
	}
	public function category(){
		return $this->categories->get();
	}
}