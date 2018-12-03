<?php

namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;

class SummaryAllFormModel{

	public function __construct()
    {
        $this->userGuestSession = session('sessionGuestUser');
		/* Menglay: USER HAS or HASN'T SESSION */
		if($this->userGuestSession == null){
			$this->userGuestSession = session('sessionGuestUserUpdate');
		}
        $this->Tool = new Tool();
    }
	
	public function getOfficerById($officer_id){
		$array = array(
			'full_name_kh'				=>'',
			'position'					=>'',
			'department_name'			=>'',
			'general_department_name'	=>'',
			'avatar'					=>''
		);
		$row = DB::table('v_mef_officer')
                ->where('Id', $officer_id)
                ->select('full_name_kh','position','department_name','general_department_name','avatar')
                ->first();
		if(count($row) > 0){
			$array = $row;
		}
		return (object)$array;
	}
	public function getPersonalInfoByOfficerId($officer_id){
        $array = array(
			'FULL_NAME_KH'			=>'',
			'PERSONAL_INFORMATION'	=>'',
			'OFFICIAL_ID'			=>'',
			'UNIT_CODE'				=>'',
			'EMAIL'					=>''
		);
		$row = DB::table('mef_personal_information')
                ->where('MEF_OFFICER_ID', $officer_id)
                ->select('FULL_NAME_KH','PERSONAL_INFORMATION','OFFICIAL_ID','UNIT_CODE','EMAIL')
                ->first();
		if(count($row) > 0){
			$array = $row;
		}
		return (object)$array;
	}
    public function getServiceStatusInfoByOfficerId($officer_id){
        $array = array(
            'CURRENT_OFFICER_CLASS'     =>'',
            'CURRENT_POSITION'          =>'',
            'CURRENT_GENERAL_DEPARTMENT'=>'',
            'CURRENT_DEPARTMENT'        =>'',
            'CURRENT_MINISTRY'          =>''
        );
        $row = DB::table('mef_service_status_information AS state')
                ->join('mef_ministry AS m','m.Id','=','state.FIRST_MINISTRY')
                ->leftjoin('mef_position AS pos','pos.ID','=','state.CURRENT_POSITION')
                ->leftJoin('mef_class_ranks AS cl','cl.Id','=','state.CURRENT_OFFICER_CLASS')
                ->leftjoin('mef_department AS dep','dep.Id','=','state.CURRENT_DEPARTMENT')
                ->leftjoin('mef_secretariat AS sec','sec.Id','=','state.CURRENT_GENERAL_DEPARTMENT')
                ->where('MEF_OFFICER_ID', $officer_id)
                ->select('cl.Name AS CURRENT_OFFICER_CLASS',
                    'pos.NAME AS CURRENT_POSITION',
                    'sec.Name AS CURRENT_GENERAL_DEPARTMENT',
                    'dep.Name AS CURRENT_DEPARTMENT',
                    'm.Name AS CURRENT_MINISTRY'
                )
                ->first();
        if(count($row) > 0){
            $array = $row;
        }
        return (object)$array;
    }
    public function getWorkHistoryByOfficerId($officer_id){
        $array = array();
        $userData = DB::table('mef_work_history')
                    ->where('MEF_OFFICER_ID', $officer_id)
                    ->select(
                        'DEPARTMENT AS MINISTRY',
                        'INSTITUTION',
                        'POSITION',
                        'POSITION_EQUAL_TO',
                        DB::raw("DATE_FORMAT(START_WORKING_DATE, '%d-%m-%Y') as START_WORKING_DATE"),
                        DB::raw("DATE_FORMAT(END_WORKING_DATE, '%d-%m-%Y') as END_WORKING_DATE")
                    )
                    ->orderBy('ID', 'ASC')
                    ->get();
        if(count($userData) > 0){
            $array = $userData[0];
        }
        return (object)$array;
    }

    public function getAwardSanctionByOfficerId($officer_id,$award_type){
        $array = array(
			'AWARD_NUMBER'				=>'',
			'AWARD_REQUEST_DEPARTMENT'	=>'',
			'AWARD_DESCRIPTION'			=>'',
			'AWARD_KIND'				=>'',
			'AWARD_DATE'				=>''
		);
        $row = DB::table('mef_appreciation_awards AS aw')
                ->join('mef_ministry AS m','m.Id','=','aw.AWARD_REQUEST_DEPARTMENT')
                ->where('aw.MEF_OFFICER_ID', $officer_id)
                ->where('aw.AWARD_TYPE',$award_type)
                ->select(
                    'aw.AWARD_NUMBER',
                    'm.Name AS AWARD_REQUEST_DEPARTMENT',
                    'aw.AWARD_DESCRIPTION',
                    'aw.AWARD_KIND',
                    DB::raw("DATE_FORMAT(aw.AWARD_DATE, '%d-%m-%Y') as AWARD_DATE")
                )
                ->orderBy('aw.ID', 'ASC')
                ->get();
        if (count($row) > 0){
            $array = $row[0];
        }
        return (object)$array;
    }
	
	public function getGeneralQualificationByOfficerId($officer_id,$type){
		$array = array(
			'LEVEL'				=>'',
			'PLACE'				=>'',
			'Q_START_DATE'		=>'',
			'Q_END_DATE'		=>''
		);
		$row = DB::table('mef_general_qualifications AS g')
                ->join('mef_degree AS d','d.Id','=','g.LEVEL')
                ->where('g.MEF_OFFICER_ID', $officer_id)
                ->where('g.Q_TYPE',$type)
                ->select(
                    'd.Name AS LEVEL',
                    'g.PLACE',
                    DB::raw("DATE_FORMAT(g.Q_START_DATE, '%d-%m-%Y') as Q_START_DATE"),
					DB::raw("DATE_FORMAT(g.Q_END_DATE, '%d-%m-%Y') as Q_END_DATE")
                )
                ->first();
        if (count($row) > 0){
            $array = $row;
        }
        return (object)$array;
		
	}
	public function getFamilySituationByOfficerId($officer_id){
		$array = array(
			'FATHER_NAME_KH'	=>'',
			'FATHER_NAME_EN'	=>'',
			'FATHER_JOB'		=>'',
			'FATHER_ADDRESS'	=>'',
			'FATHER_DOB'		=>''
		);
        $row = DB::table('mef_family_status')
                    ->where('MEF_OFFICER_ID', $officer_id)
                    ->select(
                        'FATHER_NAME_KH',
                        'FATHER_NAME_EN',
						'FATHER_JOB',
                        'FATHER_ADDRESS',
                        DB::raw("DATE_FORMAT(FATHER_DOB, '%d-%m-%Y') as FATHER_DOB")
                    )
                    ->first();
        if(count($row) > 0){
            $array = $row;
        }
        return (object)$array;
	}
	public function getAbilityForiegnLanguageByOfficerId($officer_id){
		$array = array(
			'LANGUAGE'	=>'',
			'RED'		=>'',
			'WRITE'		=>'',
			'SPEAK'		=>'',
			'LISTEN'	=>''	
		);
		$row = DB::table('v_foreign_language')
                    ->where('MEF_OFFICER_ID', $officer_id)
					->select(
                        'LANGUAGES AS LANGUAGE',
                        'READED AS RED',
						'WRITES AS WRITE',
                        'SPEAKS AS SPEAK',
                        'LISTENTS AS LISTEN'
                    )
					->orderBy('ID','ASC')
                    ->get();
        if(count($row) > 0){
            $array = $row[0];
        }
		return (object)$array;
	}

    public function getDepartmentList(){
        $arr = array(array('text'=>trans('trans.none'),'value'=>'0'));
        $obj =  DB::table('mef_department')
            ->select(
                'Id AS value',
                'Name AS text')
            ->orderBy('Name','ASC')
            ->get();
        return array_merge($arr,$obj);
    }

    function getDegreeReport($mef_ministry_id,$mef_secretariat_id,$department_id,$mef_office_id){
	    $data = DB::select(DB::raw("CALL r_p_degree($mef_ministry_id,$mef_secretariat_id,$department_id,$mef_office_id)"));
	    return $data;
    }

    function getGenderReport($mef_ministry_id,$mef_secretariat_id,$department_id,$mef_office_id){
        $data = DB::select(DB::raw("CALL r_p_gender($mef_ministry_id,$mef_secretariat_id,$department_id,$mef_office_id)"));
        return $data;
    }

    function getOfficerReportDetail($mef_ministry_id,$mef_secretariat_id,$department_id,$mef_office_id,$start_date,$end_date,$officerDateIn)
    {
        $data = DB::select(DB::raw("CALL r_p_degree_between($mef_ministry_id,$mef_secretariat_id,$department_id,$mef_office_id,$start_date,$end_date,$officerDateIn)"));
        return $data;
    }
}
?>