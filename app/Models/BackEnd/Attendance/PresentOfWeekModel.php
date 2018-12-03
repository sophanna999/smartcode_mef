<?php

namespace App\Models\BackEnd\Attendance;
use Illuminate\Support\Facades\DB;
use Config;
use App\libraries\Tool;
use Illuminate\Support\Facades\Session;
use DateTime;
use DatePeriod;
use DateInterval;
class PresentOfWeekModel{
	
	public function __construct(){
        $this->messages = Config::get('constant');
        $this->table = Config::get('table');
        $this->Tool  = new Tool();
    }
	
	public function postSearch($data){
		/* init start to date*/
		if(isset($data['full_rang_day'])){
			$date_dt =  explode(' - ',$data['full_rang_day']);
			if(sizeof($date_dt)==1){
				$date_dt = array(date("Y-m-d"),date("Y-m-d"));
			}
			$startSearch =date("Y-m-d", strtotime($date_dt[0]));		
			$endSearch =date("Y-m-d", strtotime($date_dt[1]));
			$year_dt =date("Y", strtotime($date_dt[0]));	
			// $startSearch = \DateTime::createFromFormat("Y-m-d",$startSearch,new \DateTimeZone("Asia/Phnom_Penh"));
			// $endSearch = \DateTime::createFromFormat("Y-m-d",$endSearch,new \DateTimeZone("Asia/Phnom_Penh"));
			
		}else{
			$startSearch =date("Y-m-d", strtotime($data['start_dt']));		
			$endSearch =date("Y-m-d", strtotime($data['end_dt']));
			$year_dt =date("Y", strtotime($data['start_dt']));	
		}
		$vard =round(abs(strtotime('2018-07-10 11:08:17') - strtotime('2018-07-10 09:34:39')) / 3600,2);
		// dd($vard);
		$departementId = isset($data['mef_department_id']) ? $data['mef_department_id'] : 0;
		$officeId = isset($data['mef_office_id']) ? $data['mef_office_id'] : 0;
		/* Get All Officer */
		$allOfficer = $this->getAllOfficer($departementId,$officeId);
		/* Check Special Day */
		$checkSpecailDay = $this->checkSpecailDay($departementId, $startSearch, $endSearch);
		/* Check Holiday */
		$checkedHoliday = $this->checkHoliday($startSearch, $endSearch);
		/* Check Permission Officers(Take Leave) */
		$checkedPermission = $this->checkPermission($allOfficer,$startSearch,$endSearch);
		/* Check Mission Officers */
		$checkedMission = $this->checkedMission($allOfficer,$startSearch,$endSearch);
		/* Check Officers are Full Scene on Each Day */
		$checkedSceen = $this->checkNumberOfScene($allOfficer,$startSearch,$endSearch);
		/* Check User Activity References When Officer Wanna Come Late Or Leave First */
		$activityReference = $this->userActivityReferences($checkedSceen);
		/* Check Officers Between Take Leave and Scene */
		$checked = $this->analyzeBetweenPermissionAndScene($checkedPermission,$activityReference,$checkedHoliday,$checkSpecailDay,$checkedMission);
		// dd($checked);
		return $this->permissionAndSceenOfficers($checked,$allOfficer,$year_dt,$startSearch,$endSearch,$departementId,$officeId);
	}
	
	private function permissionAndSceenOfficers($checked,$allOfficer,$year_dt,$startSearch,$endSearch,$departementId,$officeId){
		$result = array();
		$officers = array();
		foreach($allOfficer as $key => $value){
			foreach($checked as $k => $val){
				if($value->id == $k){
					$officers[$key] = $value;
					$officers[$key]->threeDays = array_slice($val,0,3);
					$officers[$key]->twoDays = array_slice($val,3,3);
				} 
			} 
		}
		$result['officers'] = $officers;
		$result['end_dt'] = $endSearch;
		$result['start_dt'] = $startSearch;
		$result['departementId'] = $departementId;
		$result['officeId'] = $officeId;
		$result['year_dt'] = $year_dt;
		return $result;
	}
	
	private function userActivityReferences($checkedSceen){
		$arraySceen = array();
		foreach($checkedSceen as $key => $value){
			foreach($value as $ke => $val){
				$arraySceen[$key][$ke]['section'] = $val['section'];
				$arraySceen[$key][$ke]['all']['sectionOne'] = $val['all']['sectionOne'];
				$arraySceen[$key][$ke]['all']['sectionTwo'] = $val['all']['sectionTwo'];
				foreach($val['all'] as $k => $v){
					if($k == 'comeLate'){
						$arraySceen[$key][$ke]['all']['comeLate']['morning'] = $this->activityReference(1,1,$v['morning'],$key,$ke);
						$arraySceen[$key][$ke]['all']['comeLate']['afternoon'] = $this->activityReference(2,1,$v['afternoon'],$key,$ke);
					}
					if($k == 'leaveFirst'){	
						$arraySceen[$key][$ke]['all']['leaveFirst']['morning'] = $this->activityReference(1,2,$v['morning'],$key,$ke);
						$arraySceen[$key][$ke]['all']['leaveFirst']['afternoon'] = $this->activityReference(2,2,$v['afternoon'],$key,$ke);
					}
				}
			}
		}
		return $arraySceen;
	}
	
	private function activityReference($section,$sceenInOut,$value,$officeId,$date){;
		$res = DB::table('mef_user_activity_references')
			   ->where(DB::raw('DATE_FORMAT(date, "%Y-%m-%d")'),$date)
			   ->where('mef_user_id',$officeId)
			   ->where('time',$sceenInOut)
			   ->where('section',$section)
			   ->first();  
		// if(!empty($res)){
		// 	if($res->is_active == 1){
		// 		return '';
		// 	} else {
		// 		return $value;
		// 	}
		// }
		return $value;
	} 
	
	private function analyzeBetweenPermissionAndScene($checkedPermission,$activityReference,$checkedHoliday,$checkSpecailDay,$checkedMission){
		$result = array();
		$emptySceen = array(
			'sectionOne' => 'អត់ច្បាប់',
			'sectionTwo' => 'អត់ច្បាប់'
		);
		$allSecton = array(
			'sectionOne' => '',
			'sectionTwo' => ''
		);
		$permissions = array(
			'sectionOne' => 'មានច្បាប់',
			'sectionTwo' => 'មានច្បាប់'
		);
		$checkedSceens = array();
		foreach($activityReference as $officerId => $officerVal){
			foreach($officerVal as $dateKey => $dateValue){
				foreach($checkSpecailDay as $k => $val){
					if(!empty($val)){
						if($val->shift == 0){
							$checkedSceens[$officerId][$k] = array('section' => 3, 'all' => array('sectionOne' => '', 'sectionTwo' => isset($officerVal[$k]['sectionTwo']) ? $officerVal[$k]['sectionTwo'] : 'អត់ច្បាប់'));;
						} else if($val->shift == 1) {
							$checkedSceens[$officerId][$k] = array('section' => 4, 'all' => array('sectionTwo' => '', 'sectionOne' => isset($officerVal[$k]['sectionOne']) ? $officerVal[$k]['sectionOne'] : 'អត់ច្បាប់'));
						} else {
							$checkedSceens[$officerId][$k] = array('section' => 0, 'all' => $allSecton);
						}
					} else {
						if($k == $dateKey){
							$checkedSceens[$officerId][$k] = $dateValue;
						}
					}
				}
			}
		}
		foreach($checkedPermission as $key => $value){
			foreach($checkedHoliday as $holKey => $holVal){
				foreach($value as $k => $val){
					if(empty($holVal)){
						if($val['section'] != 0){
							if($val['section'] == 1){
								if(isset($checkedPermission[$key][$holKey]['all']['sectionOne'])){
									if($checkedPermission[$key][$holKey]['all']['sectionOne'] == 'មានច្បាប់'){
										unset($checkedSceens[$key][$holKey]['all']['sectionOne']);
										$result[$key][$holKey]['sectionOne'] = $checkedPermission[$key][$holKey]['all']['sectionOne'];
										$result[$key][$holKey]['sectionTwo'] = isset($checkedSceens[$key][$holKey]['all']['sectionTwo']) ?  $checkedSceens[$key][$holKey]['all']['sectionTwo'] : 'អត់ច្បាប់';
										$result[$key][$holKey]['comeLate']['morning']   = '';
										$result[$key][$holKey]['leaveFirst']['morning'] = '';
									}
								} else {
									$result[$key][$holKey]['sectionOne'] = isset($checkedSceens[$key][$holKey]['all']['sectionOne']) ? $checkedSceens[$key][$holKey]['all']['sectionOne'] : 'អត់ច្បាប់';
									$result[$key][$holKey]['sectionTwo'] = isset($checkedSceens[$key][$holKey]['all']['sectionTwo']) ? $checkedSceens[$key][$holKey]['all']['sectionTwo'] : 'អត់ច្បាប់';
									$result[$key][$holKey]['comeLate']   = isset($checkedSceens[$key][$holKey]['all']) ? $checkedSceens[$key][$holKey]['all'] : array();
									$result[$key][$holKey]['leaveFirst'] = isset($checkedSceens[$key][$holKey]['all']) ? $checkedSceens[$key][$holKey]['all'] : array();
								} 
							} else if($val['section'] == 2) {
								if(isset($checkedPermission[$key][$holKey]['all']['sectionTwo'])){
									if($checkedPermission[$key][$holKey]['all']['sectionTwo'] == 'មានច្បាប់'){
										unset($checkedSceens[$key][$holKey]['all']['sectionTwo']);
										$result[$key][$holKey]['sectionTwo'] = $checkedPermission[$key][$holKey]['all']['sectionTwo'];
										$result[$key][$holKey]['comeLate']['morning']   = '';
										$result[$key][$holKey]['leaveFirst']['morning'] = '';
									}
								} else {
									$result[$key][$holKey]['sectionOne'] = isset($checkedSceens[$key][$holKey]['all']['sectionOne']) ? $checkedSceens[$key][$holKey]['all']['sectionOne'] : 'អត់ច្បាប់';
									$result[$key][$holKey]['sectionTwo'] = isset($checkedSceens[$key][$holKey]['all']['sectionTwo']) ? $checkedSceens[$key][$holKey]['all']['sectionTwo'] : 'អត់ច្បាប់';
									$result[$key][$holKey]['comeLate']   = isset($checkedSceens[$key][$holKey]['all']) ? $checkedSceens[$key][$holKey]['all'] : array();
									$result[$key][$holKey]['leaveFirst'] = isset($checkedSceens[$key][$holKey]['all']) ? $checkedSceens[$key][$holKey]['all'] : array();
								}
							} else {
								// If public holiday exist
								unset($checkedSceens[$key][$holKey]['all']);
								$checkedSceens[$key][$holKey]['all'] = isset($checkedPermission[$key][$holKey]['all']) ? $checkedPermission[$key][$holKey]['all'] : $allSecton;
								$result[$key][$holKey] = $checkedSceens[$key][$holKey]['all'];	
							}
						} else {
							$keySceen = isset($checkedSceens[$key][$holKey]['all']) ? $checkedSceens[$key][$holKey]['all'] : '';
							$keyPermission_1 = isset($checkedPermission[$key][$holKey]['all']['sectionOne']) ? $checkedPermission[$key][$holKey]['all']['sectionOne'] : '';
							$keyPermission_2 = isset($checkedPermission[$key][$holKey]['all']['sectionTwo']) ? $checkedPermission[$key][$holKey]['all']['sectionTwo'] : '';
							if($keySceen != ''){
								$result[$key][$holKey] = $checkedSceens[$key][$holKey]['all'];
							} else if($keyPermission_1 == 'មានច្បាប់' && $keyPermission_2 == 'មានច្បាប់') {
								$result[$key][$holKey] = $permissions;
							} else {
								$result[$key][$holKey] = $emptySceen;	
							}
						}							
					} else {
						$result[$key][$holKey] = array("val"=>$holVal->title,"text"=>'',"status"=>1);
					}
				}
			}
		}
		$officerMission = array();
		if(!empty($checkedMission)){
			foreach($checkedMission as $key => $val){
				foreach($result as $k => $v){
					foreach($v as $kp => $vp){
						if( $k == $val->id ){
							$officerMission[$val->id][$kp] = array(
								"sectionOne" => $val->mission,
								"sectionTwo" => $val->mission,
								"comeLate"   => array(
								    "morning"   => "",
									"afternoon" => "",
								),
								"leaveFirst"   => array(
								    "morning"   => "",
									"afternoon" => "",
								)
							);	
						} 
					}
				}
			}
		}
		$mydata = array();
		if(!empty($officerMission)){
			foreach($result as $key => $value){
				if (array_key_exists($key, $officerMission)) {
					unset($value);
				} else {
					$mydata[$key] = $value;
				}
			}
			$result = $mydata + $officerMission;
		}
		$rest = array();
		foreach($result as $key => $value){
			if($key == 62){
				$rest[$key] = $this->specailOfficer(62,$value);
			} else {
				$rest[$key] = $value;
			}
		}
		return $rest;
	}
	
	private function specailOfficer($id,$data){
		$rest = array();
		foreach($data as $key => $value){
			if(count($value) == 2 || count($value) == 4){
				$rest[$key] = array(
					"sectionOne" => "",
					"sectionTwo" => ""
				);
			} else {
				$rest[$key] = $value;
			}
		}
		return $rest;
	}
	
	private function getAllOfficer($departementId,$officeId){
		return	$list_type = DB::table('v_mef_officer as v_mef')
			->select('v_mef.Id as id','v_mef.FULL_NAME_KH as name','v_mef.orderNumber','.v_mef.position')
			->where('department_id',$departementId)
			->where('office_id',$officeId)
			// ->where('is_approve',2)
			->where('active',1)
			->whereNull('approve')
			->orderBy('position_order','orderNumber', 'desc')
			->get();
	}
	
	private function checkHoliday($startSearch,$endSearch){
		$date = $this->getDatesBetween2Dates($startSearch,$endSearch);
		$holiday = array();
		foreach($date as $key => $value){
			$data = DB::table('mef_holiday')
					   ->select('title')
					   ->where('date',$value)
					   ->get();
			if(!empty($data)){
				$holiday[$value] = $data[0];
			} else {
				$holiday[$value] = array();
			}
		}
		return $holiday;
	}
	
	private function checkSpecailDay($departementId, $startSearch, $endSearch){
		$date = $this->getDatesBetween2Dates($startSearch,$endSearch);
		$spcailDay = array();
		foreach($date as $key => $value){
			$data = DB::table('mef_specialday as spe')
				   ->leftJoin('mef_sub_specialday as sub_spe','sub_spe.specialDayId','=','spe.Id')
				   ->select('spe.shift as shift','spe.reason as reason')
				   ->where('sub_spe.departmentId',$departementId)
				   ->where('date',$value)
				   ->get();
			if(!empty($data)){
				$spcailDay[$value] = $data[0];
			} else {
				$spcailDay[$value] = array();
			}
		}
		return $spcailDay;
	}
	
	private function checkPermission($allOfficer,$startSearch,$endSearch){
		$permission = array();
		if(!empty($allOfficer)){
			$days = $this->getDatesBetween2Dates($startSearch, $endSearch);
			foreach($allOfficer as $key => $value){
				
				foreach($days as $k => $val){
					$data = DB::table('mef_take_leave as mef_t')
						->select('mef_t.*','role_type.short_attendance_type')
						->join('mef_take_leave_role_type as role_type', 'role_type.id', '=', 'mef_t.take_leave_role_type_id')
						->where('mef_t.start_dt','>=',$val)
						->where('mef_t.end_dt','<=',$val)
						->where('mef_t.officer_Id',$value->id)
						->where('mef_t.status',1)
						->get();
					if(!empty($data)){
						/* validation take leave*/
						foreach($data as $pkey => $pval){
							$val_date = date("Y/m/d", strtotime($val));
							$pval_date_st = date("Y/m/d", strtotime($pval->start_dt));
							$pval_date_end = date("Y/m/d", strtotime($pval->end_dt));
							if(($val_date >= $pval_date_st)&& $val_date <= $pval_date_end){
								
								$permission[$pval->officer_Id][$val]['section'] = $pval->section;
								if($pval->section==3){
									$permission[$pval->officer_Id][$val]['all']['sectionOne'] =  $pval->short_attendance_type;
									$permission[$pval->officer_Id][$val]['all']['sectionTwo'] =  $pval->short_attendance_type;
									
								}else{
									if($pval->section==1){
										
										$permission[$pval->officer_Id][$val]['all']['sectionOne'] = $pval->short_attendance_type;
										$permission[$pval->officer_Id][$val]['all']['sectionTwo'] = 'មានច្បាប់';
									}else{
										$permission[$pval->officer_Id][$val]['all']['sectionTwo'] = $pval->short_attendance_type;
										$permission[$pval->officer_Id][$val]['all']['sectionOne'] = 'មានច្បាប់';
									}
								}
							}
							
						}
					} else {
						$permission[$value->id][$val]['section'] = 0;
						$permission[$value->id][$val]['all']['sectionOne'] = 'អត់ច្បាប់';
						$permission[$value->id][$val]['all']['sectionTwo'] = 'អត់ច្បាប់';
					}
				}
			}
		}
		return $permission;
	}
	
	private function checkNumberOfScene($allOfficer,$startSearch,$endSearch){
		$section = array();
		$section_off = array();
		foreach($allOfficer as $key => $val){
			$sceen = DB::table('mef_user_activity')
				->select(DB::raw('DATE_FORMAT(date, "%Y-%m-%d %H:%i:%s") as date'),'state')
				->where('mef_user_id',$val->id)
				->whereBetween('date',[$startSearch,$endSearch])
				->get();
			if(!empty($sceen)){
				$section[$val->id] = $sceen;
			} else {
				$section[$val->id] = array();
			}
		}
		foreach($allOfficer as $key => $val){
			$sceen = DB::table('mef_user_attendance')
				->select(DB::raw('DATE_FORMAT(date, "%Y-%m-%d") as date')
					,'morning_checkin'
					,'morning_checkout'
					,'evening_checkin'
					,'evening_checkout'
				)
				->where('mef_user_id',$val->id)
				->whereBetween('date',[$startSearch,$endSearch])
				->get();
			if(!empty($sceen)){
				$section_off[$val->id] = $sceen;
			} else {
				$section_off[$val->id] = array();
			}
		}
		
		$allSectionSceenDay = $this->getSceneBySectionDay($section_off);
		// dd($allSectionSceenDay)
		/* Check scene is section one or section two */
		// $allSectionSceen = $this->getSceneBySection($section);
		/* Check working is enough */
		
		$checkWorkingTime = $this->checkWorkingTime($allSectionSceenDay);
		// dd($checkWorkingTime);
		/* Check is officers late or first take leave */
		return $this->getStausLateOrLeaveFirst($allSectionSceenDay,$checkWorkingTime);
	}
	private function checkIsEnoughWorkingTime($allSectionSceen){
		/* function check all of status when checkin checkout*/
		$result = array();
		foreach($allSectionSceen as $key => $value){
			foreach($value as $k => $val){
				foreach($val as $ck => $cval){
					//if($ck == "morning"){
						$morningIn  = isset($cval['In']) ? $cval['In'] : array(array());
						$morningOut = isset($cval['Out']) ? $cval['Out'] : array(array());
					//} else {
						//$morningIn  = array(array());
						//$morningOut = array(array());
					//}
					
					//if($ck == "afternoon"){
						$afternoonIn = isset($cval['In']) ? $cval['In'] : array(array());
					    $afternoonOut = isset($cval['Out']) ? $cval['Out'] : array(array());
					//} else {
						//$afternoonIn  = array(array());
						//$afternoonOut = array(array());
					//}
					//var_dump($afternoonIn);
					//if($key == 7){
						$morning = array(array_search(min($morningIn),$morningIn),array_search(max($morningOut),$morningOut));
						$afternoon = array(array_search(min($afternoonIn),$afternoonIn),array_search(max($afternoonOut),$afternoonOut));
						$result[$key][$k][$ck] = $this->caculateWorkingTime($morning,$afternoon);//var_dump($afternoon);
					//}
				}
			}
		}
		//die();
		return $result;
	}
	private function getStausLateOrLeaveFirst($allSectionSceen,$checkWorkingTimes){
		$status = array();
		foreach($allSectionSceen as $key => $value){
			foreach($value as $k =>$sections){
				/* check officer late or early */
				foreach($sections as $ck =>$section){
					if($ck == 'morning'){
						$status[$key][$k][$ck]['comeLate'] = $this->isMorningLate($section['In']);
						$status[$key][$k][$ck]['leaveFirst'] = $this->isMorningLate($section['Out']);
					} else {
						$status[$key][$k][$ck]['comeLate'] = $this->isMorningLate($section['In']);
						$status[$key][$k][$ck]['leaveFirst'] = $this->isMorningLate($section['Out']);
					}

					if($ck != "afternoon"){
						if(count($section) <= 0){
							$status[$key][$k][$ck]['section'] = 1;
							$status[$key][$k][$ck]['sign'] = 'អត់ច្បាប់';
						} else {
							$status[$key][$k][$ck]['section'] = 1;
							if($checkWorkingTimes[$key][$k][$ck] != ''){
								$status[$key][$k][$ck]['sign'] = $checkWorkingTimes[$key][$k][$ck];
							} else {
								$status[$key][$k][$ck]['sign'] = '';
							}
						}

					} else {
						if(count($section) <= 0){
							$status[$key][$k][$ck]['section'] = 2;
							$status[$key][$k][$ck]['sign'] = 'អត់ច្បាប់';
						} else {
							$status[$key][$k][$ck]['section'] = 2;
							if($checkWorkingTimes[$key][$k][$ck] != ''){
								$status[$key][$k][$ck]['sign'] = $checkWorkingTimes[$key][$k][$ck];
							} else {
								$status[$key][$k][$ck]['sign'] = '';
							}
						}
					}
				}
			}
		}
		$checkHoursAdmin = $this->checkHoursAdmin($status);
		return $this->combineTwoSectionStatus($checkHoursAdmin);
		// dd($status);
		foreach($allSectionSceen as $key => $value){
			foreach($value as $k => $val){
				foreach($val as $ck => $cval){
					if($ck == 'morning'){
						$morningIn = isset($cval['In']) ? $cval['In'] : array(array());
						$status[$key][$k][$ck]['comeLate'] = $this->isMorningLate(array_search(min($morningIn),$morningIn));
						$morningOut = isset($cval['Out']) ? $cval['Out'] : array(array());
						$status[$key][$k][$ck]['leaveFirst'] = $this->isMorningLeaveFirst(array_search(max($morningOut),$morningOut));
					} else {
						$afternoonIn = isset($cval['In']) ? $cval['In'] : array(array());
						$status[$key][$k][$ck]['comeLate'] =  $this->isAfternoonLate(array_search(min($afternoonIn),$afternoonIn));
						$afternoonOut = isset($cval['Out']) ? $cval['Out'] : array(array());
						$status[$key][$k][$ck]['leaveFirst'] = $this->isAfternoonLeaveFirst(array_search(max($afternoonOut),$afternoonOut));
					}
					if($ck != "afternoon"){
						if(count($cval) <= 0){
							$status[$key][$k][$ck]['section'] = 1;
							$status[$key][$k][$ck]['sign'] = 'អត់ច្បាប់';
						} else {
							$status[$key][$k][$ck]['section'] = 1;
							if($checkWorkingTimes[$key][$k][$ck] != ''){
								$status[$key][$k][$ck]['sign'] = $checkWorkingTimes[$key][$k][$ck];
							} else {
								$status[$key][$k][$ck]['sign'] = '';
							}
						}

					} else {
						if(count($cval) <= 0){
							$status[$key][$k][$ck]['section'] = 2;
							$status[$key][$k][$ck]['sign'] = 'អត់ច្បាប់';
						} else {
							$status[$key][$k][$ck]['section'] = 2;
							if($checkWorkingTimes[$key][$k][$ck] != ''){
								$status[$key][$k][$ck]['sign'] = $checkWorkingTimes[$key][$k][$ck];
							} else {
								$status[$key][$k][$ck]['sign'] = '';
							}
						}
					}
				}
			}
		}
		// dd($status);
		
	}
	
	private function checkHoursAdmin($data){
		$FCheckIn = '17:00:00';
		$status = array();
		foreach($data as $key => $value){
			foreach($value as $ke => $val){
				foreach($val as $k => $v){
					if($k == 'morning'){
						if(strtotime($v['comeLate']) > strtotime($FCheckIn)){
							$status[$key][$ke][$k]['comeLate'] = '';
							$status[$key][$ke][$k]['leaveFirst'] = '';
							$status[$key][$ke][$k]['sign'] = 'អត់ច្បាប់';
						} else {
							$status[$key][$ke][$k]['comeLate'] = $v['comeLate'];
							$status[$key][$ke][$k]['leaveFirst'] = $v['leaveFirst'];
							$status[$key][$ke][$k]['sign'] = $v['sign'];
						}
						$status[$key][$ke][$k]['section'] = $v['section'];
					}
					if($k == 'afternoon'){
						if(strtotime($v['comeLate']) > strtotime($FCheckIn)){
							$status[$key][$ke][$k]['comeLate'] = '';
							$status[$key][$ke][$k]['leaveFirst'] = '';
							$status[$key][$ke][$k]['sign'] = 'អត់ច្បាប់';
						} else {
							$status[$key][$ke][$k]['comeLate'] = $v['comeLate'];
							$status[$key][$ke][$k]['leaveFirst'] = $v['leaveFirst'];
							$status[$key][$ke][$k]['sign'] = $v['sign'];
						}
						$status[$key][$ke][$k]['section'] = $v['section'];
					}
				}
			}
		}
		return $status;
	}
	
	private function checkedMission($allOfficer,$startSearch,$endSearch){
		$whereInArr = array();
		if(!empty($allOfficer)){
			foreach($allOfficer as $key => $value){
			   	$whereInArr[] = $value->id;
			}
		}
		$mission = DB::table('mef_mission as mis')
				->leftJoin('mef_mission_to_officer as off','off.mef_mission_id', '=', 'mis.id')
				->select('off.mef_officer_id as id','mis.mission_objective as mission')
				->where('mis.mission_from_date','>=',$startSearch)
				->where('mis.mission_to_date','<=',$endSearch)
				->whereIn('off.mef_officer_id', $whereInArr)
				->get();
		return $mission;
	}
	
	private function combineTwoSectionStatus($status){
		$section = array();
		if(!empty($status)){
			foreach($status as $key => $value){
				foreach($value as $k => $val){
					$morning = isset($val['morning']['sign']) ? $val['morning']['sign'] : 'អត់ច្បាប់';
					$afternoon = isset($val['afternoon']['sign']) ? $val['afternoon']['sign'] : 'អត់ច្បាប់';
					$morningComeLate = isset($val['morning']['comeLate']) ? $val['morning']['comeLate'] != 0 ? $val['morning']['comeLate'] : '' : '';
					$morningLeaveFirst = isset($val['morning']['leaveFirst']) ? $val['morning']['leaveFirst'] != 0 ? $val['morning']['leaveFirst'] : '' : '';
					$afternoonComeLate = isset($val['afternoon']['ComeLate']) ? $val['afternoon']['ComeLate'] != 0 ? $val['afternoon']['ComeLate'] : '' : '';
					$afternoonLeaveFirst = isset($val['afternoon']['leaveFirst']) ? $val['afternoon']['leaveFirst'] != 0 ? $val['afternoon']['leaveFirst'] : '' : '';
					
					if(($morningComeLate != '' || $morningLeaveFirst != '' || $morning != 'អត់ច្បាប់') && ($afternoonComeLate != '' || $afternoonLeaveFirst !='' || $afternoon != 'អត់ច្បាប់')){
						$section[$key][$k]['section'] = 1.2;
					} else if($morningComeLate != '' || $morningLeaveFirst != '' || $morning != 'អត់ច្បាប់') {
						$section[$key][$k]['section'] = 1;
					} else if($afternoonComeLate != '' || $afternoonLeaveFirst !='' || $afternoon != 'អត់ច្បាប់') {
						$section[$key][$k]['section'] = 2;
					} else {
						$section[$key][$k]['section'] = 0;
					}
					
					$section[$key][$k]['all']['sectionOne'] = $morning;
					$section[$key][$k]['all']['sectionTwo'] = $afternoon;
					$section[$key][$k]['all']['comeLate']['morning']   = $morningComeLate;
					$section[$key][$k]['all']['leaveFirst']['afternoon'] = $afternoonLeaveFirst;
					$section[$key][$k]['all']['comeLate']['afternoon']   = $afternoonComeLate;
					$section[$key][$k]['all']['leaveFirst']['morning'] = $morningLeaveFirst;
				}
			}
		}
		return $section;
	}
	private function getSceneBySectionDay($section){
		$allSection = array();
		foreach($section as $key => $value){
			if(!empty($value)){
				foreach($value as $k => $val){					
					
					$allSection[$key][$val->date]['morning']['In'] = $val->morning_checkin;
					$allSection[$key][$val->date]['morning']['Out'] = $val->morning_checkout;
					$allSection[$key][$val->date]['afternoon']['In'] = $val->evening_checkin;
					$allSection[$key][$val->date]['afternoon']['Out'] = $val->evening_checkout;
				}
			} else {
				if(!empty($explodeDate)){
					$allSection[$key][$val->date]['morning'] = array();
					$allSection[$key][$val->date]['afternoon'] = array();
				}
			}
		}
		return $allSection;
	}
	private function getSceneBySection($section){
		$allSection = array();
		foreach($section as $key => $value){
			if(!empty($value)){
				foreach($value as $k => $val){
					$explodeDate = explode(' ',$val->date);
					$date = strtotime($explodeDate[1]);
					if(date('H', $date) >= "7" && date('H', $date) < "14"){
						$allSection[$key][$explodeDate[0]]['morning'][$val->state][$explodeDate[1]] = strtotime($explodeDate[1]);
					} 
					if(date('H', $date) >= "11" && date('H', $date) < "20"){
						$allSection[$key][$explodeDate[0]]['afternoon'][$val->state][$explodeDate[1]] = strtotime($explodeDate[1]);
					}
				}
			} else {
				if(!empty($explodeDate)){
					$allSection[$key][$explodeDate[0]]['morning'] = array();
					$allSection[$key][$explodeDate[0]]['afternoon'] = array();
				}
			}
		}
		return $allSection;
	}
	
	private function isMorningLate($time){
		$result = '';
		if($time !='NA'){
			$h = date('H:m:s', strtotime($time));
			if((strtotime($time) >strtotime('11:09:59')) && strtotime($time) < strtotime('13:59:59')){
				$result = '';
			} else {

				$morningWork = strtotime('08:30:59');
				$diff = $morningWork - strtotime($time);
				($diff < 0) ? $result = $time : $result = '';
			}
		}
		return $result;
	}
	
	private function isMorningLeaveFirst($time){
		$MLeave = '11:10:00';
		$inDate = explode('-',$time);
		if($inDate[0] == 12 || $inDate[0] == 13 || $inDate[0] == 14){
			$result = '';
		} else {
			$morningWork = strtotime($MLeave);
			$diff = $morningWork - strtotime($time);
			($diff > 0) ? $result = $time : $result = '';
		}
		return $result;
	}
	
	private function isAfternoonLate($time){
		$FCheckIn = '14:31:00';
		$inDate = explode('-',$time);
		if($inDate[0] == 11 || $inDate[0] == 12 || $inDate[0] == 13 || $inDate[0] == 14){
			$result = '';
		} else {
			$afternoonWork = strtotime($FCheckIn);
			$diff = $afternoonWork - strtotime($time);
			($diff < 0) ? $result = $time : $result = '';
		}
		return $result;
	}
	
	private function isAfternoonLeaveFirst($time){
		$FCheckIn = '17:00:00';
		$inDate = explode('-',$time);
		if($inDate[0] == 11 || $inDate[0] == 12 || $inDate[0] == 13 || $inDate[0] == 14){
			$result = '';
		} else {
			$afternoonWork = strtotime($FCheckIn);
			$diff = $afternoonWork - strtotime($time);
			($diff > 0) ? $result = $time : $result = '';
		}
		return $result;
	}
	private function checkWorkingTime($allSectionSceen){
		/* function check all of status when checkin checkout*/
		$result = array();
		foreach($allSectionSceen as $key => $value){
			foreach($value as $k => $sections){
				$morning= array();
				$afternoon= array();
				foreach($sections as $ks =>$section){
					if($ks=='morning'){
						if($section['In'] !='NA'){
							array_push($morning,date('H:m:s', strtotime($section['In'])));
						}else{
							array_push($morning,$section['In']);
						}
						if($section['Out'] !='NA'){
							array_push($morning,date('H:m:s', strtotime($section['Out'])));
						}else{
							array_push($morning,$section['Out']);
						}
						if(count($section) <= 0){
							$result[$key][$k][$ks]['section'] = 1;
							$result[$key][$k][$ks]['sign'] = 'អត់ច្បាប់';
						} else {
							$result[$key][$k][$ks]['section'] = 1;
						}
					}
					if($ks=='afternoon'){
						if($section['In'] !='NA'){
							array_push($afternoon,date('H:m:s', strtotime($section['In'])));
						}else{
							array_push($afternoon,$section['In']);
						}
						if($section['Out'] !='NA'){
							array_push($afternoon,date('H:m:s', strtotime($section['Out'])));
						}else{
							array_push($afternoon,$section['Out']);
						}
					}	
					
					if($ks=='morning'){
						$m_is = $this->caculateWorkingTimes($morning);
						
						if($m_is !='' && $m_is !='អត់ច្បាប់'){
							$sec = $this->checkLetterMission($key,$k);
							if($sec->time_milis !=null){	
								$result[$key][$k][$ks] = $this->checkTimeInSection($sec->time_milis+$m_is);
							}else{
								$result[$key][$k][$ks] = 'អត់ច្បាប់';
							}
						}else{
							$result[$key][$k][$ks] = $this->caculateWorkingTimes($morning);
						}
						
						// $result[$key][$k][$ks] = $m_is;					
					}
					if($ks=='afternoon'){
						$result[$key][$k][$ks] = $this->caculateWorkingTimes($afternoon);
					}	
				}
				
			}
		}
		return $result;
	}
	private function checkLetterMission($officer_id,$date){
		return $list_db = DB::table('mef_take_mission_letter')
			->selectRaw('SUM(UNIX_TIMESTAMP(end_time_24) - UNIX_TIMESTAMP(start_time_24)) as time_milis')
			->where('date_time',$date)
			->where('officer_id',$officer_id)
			->first();		
	}
	private function caculateWorkingTimes($time=array()){
		
		if(sizeof($time)>=2){	
			$sub_work_time = 0;
			if($time[1]=='NA' && $time[0]=='NA'){return 'អត់ច្បាប់';}
			if(strtotime($time[1]) > strtotime($time[0])){
				$sub_work_time =strtotime($time[1]) - strtotime($time[0]);			
			}else{
				$sub_work_time =strtotime($time[0]) - strtotime($time[1]);
			}
			$work_time= round(abs($sub_work_time) / 3600,2);	
			
			if($work_time >= 1.50){
				return '';
			} else {
				return 'អត់ច្បាប់';
				return $sub_work_time;
			}			
		}
		return 'អត់ច្បាប់';
	}
	
	private function checkTimeInSection($secon){
		if($secon>0){	
			if(round(abs($secon) / 3600,2) < 1.5){
				return 'អត់ច្បាប់';
			}
			return '';
		}
		return 'អត់ច្បាប់';
	}
	private	function getDatesBetween2Dates($startTime, $endTime) {
		$interval = new DateInterval('P1D');	
		$startTime = \DateTime::createFromFormat("Y-m-d",$startTime,new \DateTimeZone("Asia/Phnom_Penh"));
		$endTime = \DateTime::createFromFormat("Y-m-d",$endTime,new \DateTimeZone("Asia/Phnom_Penh"));
		$endTime = $endTime->modify( '+1 day' ); 	
		$daterange = new DatePeriod($startTime, $interval ,$endTime);
		$rang_date = array();
		foreach($daterange as $date){
			array_push($rang_date,$date->format("Y-m-d"));
		}
		return $rang_date;
	}
	
	private function isWeekend($date){
		$weekDay = date('w', strtotime($date));
		return ($weekDay == 0 || $weekDay == 6);
	}
	
	public function getDepartmentName($id){
		return DB::table('mef_department')->select('Name')->where('Id',$id)->get();
	}
	
	public function getOfficeName($id){
		return DB::table('mef_office')->select('Name')->where('Id',$id)->get();
	}
	
}
