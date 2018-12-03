<?php

namespace App\Models\BackEnd\Report;
use Illuminate\Support\Facades\DB;
use Config;
class ReportModel
{

    public function __construct()
    {
        $this->table = Config::get('table');
		$this->constant = Config::get('constant');
    }
    public function getAllMinistry(){
        $arrList = DB::table('mef_ministry')->orderBy('Name', 'ASC')->get();
        $arr = array();
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=> $row->Name,
                "value" => $row->Id
            );
        }
        return $arr;
    }
	public function getAllSecretariatByMinistry(){
		$arrList = DB::table('mef_secretariat')->orderBy('Name', 'ASC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	public function getTextSecretariat(){
		$arrList = DB::table('mef_secretariat')->orderBy('Name', 'ASC')->get();
        $arr = array();
        foreach($arrList as $row){
            $arr[] = $row->Name;
        }
        return $arr;
	}
	/* Get detail officer */
	public function getRecordById($table,$id){
		$arrList = DB::table($table)->where('Id',$id)->first();
		if($arrList != null){
			return $arrList;
		}else{
			return array();
		}
	}
	public function getPositionById($id){
		$arrList = DB::table('mef_position')
				->select('NAME AS Name')
				->where('Id',$id)->first();
		if($arrList != null){
			return $arrList;
		}else{
			return array();
		}
	}
	public function getOfficerByMinistryId($id){
		$listDb = DB::table('mef_officer AS f')
				->select('p.FULL_NAME_KH','p.FULL_NAME_EN','p.EMAIL','p.PHONE_NUMBER_1','p.DATE_OF_BIRTH','status.FIRST_MINISTRY')
				->join('mef_personal_information AS p','f.Id', '=' ,'p.MEF_OFFICER_ID')
				->join('mef_service_status_information AS status','f.Id', '=' ,'status.MEF_OFFICER_ID')
				->where('status.FIRST_MINISTRY',$id)
				->orderBy('p.FULL_NAME_KH','ASC')
				->get();
		if($listDb != null){
			return $listDb;
		}else{
			return array();
		}		
	}
	
	public function getOfficerBySecretariatId($mef_department_id,$mef_office_id,$class_rank_id,$id){
		$listDb = DB::table('mef_officer AS f')
				->select('p.FULL_NAME_KH','p.FULL_NAME_EN','p.EMAIL','p.PHONE_NUMBER_1','p.DATE_OF_BIRTH','status.FIRST_UNIT')
				->join('mef_personal_information AS p','f.Id', '=' ,'p.MEF_OFFICER_ID')
				->join('mef_service_status_information AS status','f.Id', '=' ,'status.MEF_OFFICER_ID')
				->where('status.CURRENT_GENERAL_DEPARTMENT',$id)
				->where(function($query) use ($mef_department_id,$mef_office_id,$class_rank_id){
					if ($mef_department_id != '') {
						$query->where('status.CURRENT_GENERAL_DEPARTMENT',$mef_department_id);
					}
					if ($mef_office_id != '') {
						$query->where('status.CURRENT_OFFICE',$mef_office_id);
					}
					if ($class_rank_id != '') {
						$query->where('status.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->orderBy('p.FULL_NAME_KH','ASC')
				->get();
		if($listDb != null){
			return $listDb;
		}else{
			return array();
		}		
	}
	public function getOfficerByDepartmentId($mef_secretariat_id,$mef_office_id,$class_rank_id,$id){
		$listDb = DB::table('mef_officer AS f')
				->select('p.FULL_NAME_KH','p.FULL_NAME_EN','p.EMAIL','p.PHONE_NUMBER_1','p.DATE_OF_BIRTH','status.FIRST_DEPARTMENT')
				->join('mef_personal_information AS p','f.Id', '=' ,'p.MEF_OFFICER_ID')
				->join('mef_service_status_information AS status','f.Id', '=' ,'status.MEF_OFFICER_ID')
				->where('status.CURRENT_DEPARTMENT',$id)
				->where(function($query) use ($mef_secretariat_id,$mef_office_id,$class_rank_id){
					if ($mef_secretariat_id != '') {
						$query->where('status.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_office_id != '') {
						$query->where('status.CURRENT_OFFICE',$mef_office_id);
					}
					if ($class_rank_id != '') {
						$query->where('status.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->orderBy('p.FULL_NAME_KH','ASC')
				->get();
		if($listDb != null){
			return $listDb;
		}else{
			return array();
		}		
	}
	public function getOfficerByOfficeId($mef_secretariat_id,$mef_department_id,$class_rank_id,$id){
		$listDb = DB::table('mef_officer AS f')
				->select('p.FULL_NAME_KH','p.FULL_NAME_EN','p.EMAIL','p.PHONE_NUMBER_1','p.DATE_OF_BIRTH','status.FIRST_OFFICE')
				->join('mef_personal_information AS p','f.Id', '=' ,'p.MEF_OFFICER_ID')
				->join('mef_service_status_information AS status','f.Id', '=' ,'status.MEF_OFFICER_ID')
				->where('status.CURRENT_OFFICE',$id)
				->where(function($query) use ($mef_secretariat_id,$mef_department_id,$class_rank_id){
					if ($mef_secretariat_id != '') {
						$query->where('status.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_department_id != '') {
						$query->where('status.CURRENT_DEPARTMENT',$mef_department_id);
					}
					if ($class_rank_id != '') {
						$query->where('status.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->orderBy('p.FULL_NAME_KH','ASC')
				->get();
		if($listDb != null){
			return $listDb;
		}else{
			return array();
		}		
	}
	public function getOfficerByPositionId($mef_secretariat_id,$mef_department_id,$mef_office_id,$class_rank_id,$id){
		$listDb = DB::table('mef_officer AS f')
				->select('p.FULL_NAME_KH','p.FULL_NAME_EN','p.EMAIL','p.PHONE_NUMBER_1','p.DATE_OF_BIRTH','status.FIRST_POSITION')
				->join('mef_personal_information AS p','f.Id', '=' ,'p.MEF_OFFICER_ID')
				->join('mef_service_status_information AS status','f.Id', '=' ,'status.MEF_OFFICER_ID')
				->where('status.CURRENT_POSITION',$id)
				->where(function($query) use ($mef_secretariat_id,$mef_department_id,$mef_office_id,$class_rank_id){
					if ($mef_secretariat_id != '') {
						$query->where('status.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_department_id != '') {
						$query->where('status.CURRENT_DEPARTMENT',$mef_department_id);
					}
					if ($mef_office_id != '') {
						$query->where('status.CURRENT_OFFICE',$mef_office_id);
					}
					if ($class_rank_id != '') {
						$query->where('status.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->orderBy('p.FULL_NAME_KH','ASC')
				->get();
		if($listDb != null){
			return $listDb;
		}else{
			return array();
		}		
	}
	public function getOfficerByClassRankId($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$id){
		$listDb = DB::table('mef_officer AS f')
				->select('p.FULL_NAME_KH','p.FULL_NAME_EN','p.EMAIL','p.PHONE_NUMBER_1','p.DATE_OF_BIRTH','status.FIRST_OFFICER_CLASS')
				->join('mef_personal_information AS p','f.Id', '=' ,'p.MEF_OFFICER_ID')
				->join('mef_service_status_information AS status','f.Id', '=' ,'status.MEF_OFFICER_ID')
				->where('status.CURRENT_OFFICER_CLASS',$id)
				->where(function($query) use ($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id){
					if ($mef_secretariat_id != '') {
						$query->where('status.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_department_id != '') {
						$query->where('status.CURRENT_DEPARTMENT',$mef_department_id);
					}
					if ($mef_office_id != '') {
						$query->where('status.CURRENT_OFFICE',$mef_office_id);
					}
					if ($mef_position_id != '') {
						$query->where('status.CURRENT_POSITION',$mef_position_id);
					}
					
				})
				->orderBy('p.FULL_NAME_KH','ASC')
				->get();
		if($listDb != null){
			return $listDb;
		}else{
			return array();
		}		
	}
	public function getOfficerByDoB($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id,$dob){
		$listDb = DB::table('mef_officer AS f')
				->select('p.FULL_NAME_KH','p.FULL_NAME_EN','p.EMAIL','p.PHONE_NUMBER_1','p.DATE_OF_BIRTH','status.FIRST_OFFICER_CLASS')
				->join('mef_personal_information AS p','f.Id', '=' ,'p.MEF_OFFICER_ID')
				->join('mef_service_status_information AS status','f.Id', '=' ,'status.MEF_OFFICER_ID')
				->where(DB::raw('substr(p.DATE_OF_BIRTH, 1, 4)'),$dob)
				->where(function($query) use ($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id){
					if ($mef_secretariat_id != '') {
						$query->where('status.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_department_id != '') {
						$query->where('status.CURRENT_DEPARTMENT',$mef_department_id);
					}
					if ($mef_office_id != '') {
						$query->where('status.CURRENT_OFFICE',$mef_office_id);
					}
					if ($mef_position_id != '') {
						$query->where('status.CURRENT_POSITION',$mef_position_id);
					}
					if ($class_rank_id != '') {
						$query->where('status.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->orderBy('p.FULL_NAME_KH','ASC')
				->get();
		if($listDb != null){
			return $listDb;
		}else{
			return array();
		}
	}
	/* End get detail of officer*/
	
	public function getDepartmentBySecretariatId($mef_secretariat_id){
        $arrList = DB::table('mef_department')
                    ->where('mef_secretariat_id',$mef_secretariat_id)
                    ->orderBy('Name', 'ASC')
                    ->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	public function getOfficeByDepartmentId($departmentId){
        $arrList = DB::table('mef_office')->where('mef_department_id',$departmentId)->orderBy('Id', 'DESC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	
	public function getPosition(){
        $arrList = DB::table('mef_position')->orderBy('ORDER_NUMBER', 'ASC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->NAME,
                "value" =>$row->ID
            );
        }
        return $arr;
    }
	public function getAllClassRank(){
        $arrList = DB::table('mef_class_ranks')->orderBy('Order', 'ASC')->get();
        $arr = array(array("text"=>"", "value" => ""));
        foreach($arrList as $row){
            $arr[] = array(
                'text' 	=>$row->Name,
                "value" =>$row->Id
            );
        }
        return $arr;
    }
	
	
	public function postTotalMinistry($mef_ministry_id){
		$listDb = DB::table('mef_officer')
				->select('mef_ministry.Name','mef_ministry.Id', DB::raw('COUNT(*) AS Total'))
				->join('mef_service_status_information','mef_service_status_information.MEF_OFFICER_ID','=','mef_officer.Id')
				->join('mef_ministry','mef_service_status_information.FIRST_MINISTRY','=','mef_ministry.Id')
				->groupBy('mef_service_status_information.FIRST_MINISTRY')
				->where(function($query) use ($mef_ministry_id){
					if ($mef_ministry_id != '') {
						$query->where('mef_service_status_information.FIRST_MINISTRY',$mef_ministry_id);
					}
				})				
				->get();
		$list = array();
		foreach($listDb as $row){
			$list[] = array(
				"Id"			=>$row->Id,
				"Type"			=>1,
				"displayText"  	=>$row->Name,
				"dataField"  	=>$this->constant['mefTotalOfficer'],
			);
		}
		return $list;
		
	}
	public function postTotalSecretariat($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id){
		$listDb = DB::table('mef_officer')
				->select('mef_secretariat.Name','mef_secretariat.Id', DB::raw('COUNT(*) AS Total'))
				->join('mef_service_status_information','mef_service_status_information.MEF_OFFICER_ID','=','mef_officer.Id')
				->join('mef_secretariat','mef_service_status_information.CURRENT_GENERAL_DEPARTMENT','=','mef_secretariat.Id')
				->groupBy('mef_service_status_information.CURRENT_GENERAL_DEPARTMENT')
				->where('mef_service_status_information.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id)
				->where(function($query) use ($mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id){
					if ($mef_department_id != '') {
						$query->where('mef_service_status_information.CURRENT_DEPARTMENT',$mef_department_id);
					}
					if ($mef_office_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICE',$mef_office_id);
					}
					if ($mef_position_id != '') {
						$query->where('mef_service_status_information.CURRENT_POSITION',$mef_position_id);
					}
					if ($class_rank_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->get();
		$list = array();
		foreach($listDb as $row){
			$list[] = array(
				"Id"			=>$row->Id,
				"Type"			=>2,
				"displayText"  	=>$row->Name,
				"dataField"  	=>$row->Total
			);
		}
		return $list;
	}
	public function postTotalDepartment($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id){
		$listDb = DB::table('mef_officer')
				->select('mef_department.Name','mef_department.Id', DB::raw('COUNT(*) AS Total'))
				->join('mef_service_status_information','mef_service_status_information.MEF_OFFICER_ID','=','mef_officer.Id')
				->join('mef_department','mef_service_status_information.CURRENT_DEPARTMENT','=','mef_department.Id')
				->groupBy('mef_service_status_information.CURRENT_DEPARTMENT')
				->where('mef_service_status_information.CURRENT_DEPARTMENT',$mef_department_id)
				->where(function($query) use ($mef_secretariat_id,$mef_office_id,$mef_position_id,$class_rank_id){
					if ($mef_secretariat_id != '') {
						$query->where('mef_service_status_information.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_office_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICE',$mef_office_id);
					}
					if ($mef_position_id != '') {
						$query->where('mef_service_status_information.CURRENT_POSITION',$mef_position_id);
					}
					if ($class_rank_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->get();
		$list = array();
		foreach($listDb as $row){
			$list[] = array(
				"Id"			=>$row->Id,
				"Type"			=>3,
				"displayText"  	=>$row->Name,
				"dataField"  	=>$row->Total,
			);
		}
		return $list;
	}
	public function postTotalOffice($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id){
		$listDb = DB::table('mef_officer')
				->select('mef_office.Name','mef_office.Id', DB::raw('COUNT(*) AS Total'))
				->join('mef_service_status_information','mef_service_status_information.MEF_OFFICER_ID','=','mef_officer.Id')
				->join('mef_office','mef_service_status_information.CURRENT_OFFICE','=','mef_office.Id')
				->groupBy('mef_service_status_information.CURRENT_OFFICE')
				->where('mef_service_status_information.CURRENT_OFFICE',$mef_office_id)
				->where(function($query) use ($mef_secretariat_id,$mef_department_id,$mef_position_id,$class_rank_id){
					if ($mef_secretariat_id != '') {
						$query->where('mef_service_status_information.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_department_id != '') {
						$query->where('mef_service_status_information.CURRENT_DEPARTMENT',$mef_department_id);
					}
					if ($mef_position_id != '') {
						$query->where('mef_service_status_information.CURRENT_POSITION',$mef_position_id);
					}
					if ($class_rank_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->get();
		$list = array();
		foreach($listDb as $row){
			$list[] = array(
				"Id"			=>$row->Id,
				"Type"			=>4,
				"displayText"  	=>$row->Name,
				"dataField"  	=>$row->Total,
			);
		}
		return $list;
	}
	public function postTotalPosition($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id){
		$listDb = DB::table('mef_officer')
				->select('mef_position.NAME AS Name','mef_position.ID AS Id', DB::raw('COUNT(*) AS Total'))
				->join('mef_service_status_information','mef_service_status_information.MEF_OFFICER_ID','=','mef_officer.Id')
				->join('mef_position','mef_service_status_information.CURRENT_POSITION','=','mef_position.Id')
				->groupBy('mef_service_status_information.CURRENT_POSITION')
				->where('mef_service_status_information.CURRENT_POSITION',$mef_position_id)
				->where(function($query) use ($mef_secretariat_id,$mef_department_id,$mef_office_id,$class_rank_id){
					if ($mef_secretariat_id != '') {
						$query->where('mef_service_status_information.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_department_id != '') {
						$query->where('mef_service_status_information.CURRENT_DEPARTMENT',$mef_department_id);
					}
					if ($mef_office_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICE',$mef_office_id);
					}
					if ($class_rank_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->get();
		$list = array();
		foreach($listDb as $row){
			$list[] = array(
				"Id"			=>$row->Id,
				"Type"			=>5,
				"displayText"  	=>$row->Name,
				"dataField"  	=>$row->Total,
			);
		}
		return $list;
	}
	public function postTotalClassRank($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id){
		$listDb = DB::table('mef_officer')
				->select('mef_class_ranks.Name','mef_class_ranks.Id', DB::raw('COUNT(*) AS Total'))
				->join('mef_service_status_information','mef_service_status_information.MEF_OFFICER_ID','=','mef_officer.Id')
				->join('mef_class_ranks','mef_service_status_information.CURRENT_OFFICER_CLASS','=','mef_class_ranks.Id')
				->groupBy('mef_service_status_information.CURRENT_OFFICER_CLASS')
				->where('mef_service_status_information.CURRENT_OFFICER_CLASS',$class_rank_id)
				->where(function($query) use ($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id){
					if ($mef_secretariat_id != '') {
						$query->where('mef_service_status_information.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_department_id != '') {
						$query->where('mef_service_status_information.CURRENT_DEPARTMENT',$mef_department_id);
					}
					if ($mef_office_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICE',$mef_office_id);
					}
					if ($mef_position_id != '') {
						$query->where('mef_service_status_information.CURRENT_POSITION',$mef_position_id);
					}
				})
				->get();
		$list = array();
		foreach($listDb as $row){
			$list[] = array(
				"Id"			=>$row->Id,
				"Type"			=>6,
				"displayText"  	=>$row->Name,
				"dataField"  	=>$row->Total,
			);
		}
		return $list;
	}
	public function postTotalDoB($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id,$from_dob,$to_dob){
		$listDb = DB::table('mef_officer')
				->select('mef_personal_information.DATE_OF_BIRTH AS Name',DB::raw('substr(mef_personal_information.DATE_OF_BIRTH, 1, 4) as Year'), DB::raw('COUNT(*) AS Total'))
				->join('mef_personal_information','mef_personal_information.MEF_OFFICER_ID','=','mef_officer.Id')
				->join('mef_service_status_information','mef_service_status_information.MEF_OFFICER_ID','=','mef_officer.Id')
				->groupBy('Year')
				->whereBetween('mef_personal_information.DATE_OF_BIRTH',array($from_dob,$to_dob))
				->where(function($query) use ($mef_secretariat_id,$mef_department_id,$mef_office_id,$mef_position_id,$class_rank_id){
					if ($mef_secretariat_id != '') {
						$query->where('mef_service_status_information.CURRENT_GENERAL_DEPARTMENT',$mef_secretariat_id);
					}
					if ($mef_department_id != '') {
						$query->where('mef_service_status_information.CURRENT_DEPARTMENT',$mef_department_id);
					}
					if ($mef_office_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICE',$mef_office_id);
					}
					if ($mef_position_id != '') {
						$query->where('mef_service_status_information.CURRENT_POSITION',$mef_position_id);
					}
					if ($class_rank_id != '') {
						$query->where('mef_service_status_information.CURRENT_OFFICER_CLASS',$class_rank_id);
					}
				})
				->orderBy('mef_personal_information.DATE_OF_BIRTH','ASC')
				->get();
		$list = array();
		foreach($listDb as $row){
			$id = explode('-',$row->Name);
			$list[] = array(
				"Id"			=>$id[0].$id[1].$id[2],
				"Type"			=>7,
				"displayText"  	=>date('d/m/Y',strtotime($row->Name)),
				"dataField"  	=>$row->Total,
			);
		}
		return $list;	
	}
	
	
}
?>