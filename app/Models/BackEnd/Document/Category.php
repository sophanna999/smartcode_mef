<?php
namespace App\Models\BackEnd\Document;
use Illuminate\Database\Eloquent\Model;
use App\Models\BackEnd\Document\Setting;

class Category extends Setting
{
	public function newQuery($excludeDeleted = true)
	{
		return parent::newQuery($excludeDeleted)->whereParent_id(15);
	}
}
?>
