<?php
namespace App\Http\Controllers\BackEnd\Attendance;

use App\Http\Controllers\BackendController;
use App\Models\BackEnd\Attendance\OfficerCheckinReportModel;
use Input;
use DB;
use App\libraries\Tool;
use Illuminate\Http\Request;
use App\Models\BackEnd\User\UserModel;
use App\Models\BackEnd\Attendance\OfficerCheckinModel;

class OfficerCheckinReportController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
		$this->tool = new Tool();
		$this->model = new OfficerCheckinReportModel();
		$this->user = session('sessionUser');
		if (!isset($this->user->mef_general_department_id))
			return array();
		
	}
	
	public function getIndex()
	{
		return view($this->viewFolder . '.attendance.officer-checkin-report.index')->with($this->data);
	}
	
	public function postIndex(Request $request)
	{
		return $this->model->getDataGrid($request->all());
	}
	
	public function getNew()
	{
		return view($this->viewFolder . '.attendance.officer-checkin.import')->with($this->data);
	}
	
	public function postImport()
	{
		return view($this->viewFolder . '.attendance.officer-checkin.import')->with($this->data);
	}
	
	public function getDetail($id)
	{
		$this->data['username'] = $this->model->getUsernameById($id);
		$this->data['officer_id'] = $id;
		return view($this->viewFolder.'.attendance.officer-checkin-report.detail')->with($this->data);
	}

	public function postDetail(Request $request){
		return $this->model->getDataDetailGrid($request->all());
	}

}