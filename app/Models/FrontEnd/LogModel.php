<?php

namespace App\Models\FrontEnd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LogModel{
	
	public function __construct()
    {
		$this->userGuestSession = session('sessionGuestUser');
		$this->mefOfficerObj = DB::table('mef_officer')->where('Id',$this->userGuestSession->Id)->first();
    }
	public function __construct1($editId=null)
	{
		$this->userGuestSession = session('sessionGuestUser');
		$this->mefOfficerObj = DB::table('mef_officer')->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)->first();
	}
	// Version 2
	public function officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle,$familyId=null,$editId=null){
		if($familyId == null){
			$whereFiled = 'MEF_OFFICER_ID';
			$whereId = empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id;
		}else{
			$whereFiled = 'FAMILY_STATUS_ID';
			$whereId = $familyId;
		}
		$this->mefOfficerObj = DB::table('mef_officer')->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)->first();
		if($this->mefOfficerObj->is_register >= 2){
			if($isMultipleRow == 0){
				$dataTableObj = DB::table($table)->where($whereFiled, $whereId)->first();
				if($dataTableObj != null){
					if(count($newFieldArray) > 0){
						$dataArray = array(
							"mef_officer_id" => empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id,
							"mef_form_title" => $mefFormTitle,
							"mef_form_number" => $formNumber,
							"last_modified_date" => date('Y-m-d H:i:s', time())
						);
						$affected = DB::table('mef_officer_history')
									->insert($dataArray);
						if($this->mefOfficerObj->is_register == 2){
							$array = array(
								"is_register" => 3,
								"is_visited" => 0
							);
							//dd($array);
							$updateMefOfficer = DB::table('mef_officer')
												->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)
												->update($array);
						}			
						return 1;
					}else{
						return 0;
					}
				}
				else{
					return 0;
				}
			}else{
				$dataTableObj = DB::table($table)->where($whereFiled, $whereId)->OrderBy('ID', 'asc')->get();
				if(count($newFieldArray) == count($dataTableObj)){
					if(count($newFieldArray) > 0){
						$dataArray = array(
							"mef_officer_id" => empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id,
							"mef_form_title" => $mefFormTitle,
							"mef_form_number" => $formNumber,
							"last_modified_date" => date('Y-m-d H:i:s', time())
						);
						$affected = DB::table('mef_officer_history')
									->insert($dataArray);
						if($this->mefOfficerObj->is_register == 2){
							$array = array(
								"is_register" => 3,
								"is_visited" => 0
							);
							//dd($array);
							$updateMefOfficer = DB::table('mef_officer')
												->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)
												->update($array);
						}			
						return 1;
					}else{
						return 0;
					}
				}else{
					$dataArray = array(
							"mef_officer_id" => empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id,
							"mef_form_title" => $mefFormTitle,
							"mef_form_number" => $formNumber,
							"last_modified_date" => date('Y-m-d H:i:s', time())
						);
					$affected = DB::table('mef_officer_history')
								->insert($dataArray);
					if($this->mefOfficerObj->is_register == 2){
						$array = array(
							"is_register" => 3,
							"is_visited" => 0
						);
						//dd($array);
						$updateMefOfficer = DB::table('mef_officer')
											->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)
											->update($array);
					}			
					return 1;
				}
			}			
		}else{
			return 0;
		}
	}

	// Version 2
//	public function officerHistory($formNumber,$table,$newFieldArray,$isMultipleRow,$mefFormTitle,$familyId=null,$editId=null){
//		if($familyId == null){
//			$whereFiled = 'MEF_OFFICER_ID';
//			$whereId = empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id;
//		}else{
//			$whereFiled = 'FAMILY_STATUS_ID';
//			$whereId = $familyId;
//		}
//		$this->mefOfficerObj = DB::table('mef_officer')->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)->first();
//		if($this->mefOfficerObj->is_register >= 2){
//			if($isMultipleRow == 0){
//				$dataTableObj = DB::table($table)->where($whereFiled, $whereId)->first();
//				if($dataTableObj != null){
//					$dataHistoryArray = array();
//					foreach($newFieldArray as $key=>$val){
//						if($dataTableObj->{$key} != $val){
//							$dataHistoryArray[]	=	array(
//								"mef_officer_id" => empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id,
//								"mef_table_name" => $table,
//								"mef_field_name" => $key,
//								"mef_field_value" => $dataTableObj->{$key}
//							);
//						}
//					}
//					if(count($dataHistoryArray) > 0){
//						$dataArray = array(
//							"mef_officer_id" => empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id,
//							"mef_form_title" => $mefFormTitle,
//							"mef_form_number" => $formNumber,
//							"last_modified_date" => date('Y-m-d H:i:s', time())
//						);
//						$affected = DB::table('mef_officer_history')
//							->insert($dataArray);
//
//						if($this->mefOfficerObj->is_register == 2){
//							$array = array(
//								"is_register" => 3,
//								"is_visited" => 0
//							);
//							//dd($array);
//							$updateMefOfficer = DB::table('mef_officer')
//								->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)
//								->update($array);
//						}
//						return 1;
//					}else{
//						return 0;
//					}
//				}
//				else{
//					return 0;
//				}
//			}else{
//				$dataTableObj = DB::table($table)->where($whereFiled, $whereId)->OrderBy('ID', 'asc')->get();
//				if(count($newFieldArray) == count($dataTableObj)){
//					$dataHistoryArray = array();
//					foreach($newFieldArray as $key=>$val){
//						foreach($val as $key1=>$val1){
//							if($dataTableObj[$key]->{$key1} != $val1){
//								$dataHistoryArray[]	=	array(
//									"mef_officer_id" => empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id,
//									"mef_table_name" => $table,
//									"mef_field_name" => $key1,
//									"mef_field_value" => $dataTableObj[$key]->{$key1}
//								);
//							}
//						}
//					}
//					if(count($dataHistoryArray) > 0){
//						$dataArray = array(
//							"mef_officer_id" => empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id,
//							"mef_form_title" => $mefFormTitle,
//							"mef_form_number" => $formNumber,
//							"last_modified_date" => date('Y-m-d H:i:s', time())
//						);
//						$affected = DB::table('mef_officer_history')
//							->insert($dataArray);
//						if($this->mefOfficerObj->is_register == 2){
//							$array = array(
//								"is_register" => 3,
//								"is_visited" => 0
//							);
//							//dd($array);
//							$updateMefOfficer = DB::table('mef_officer')
//								->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)
//								->update($array);
//						}
//						return 1;
//					}else{
//						return 0;
//					}
//				}else{
//					$dataArray = array(
//						"mef_officer_id" => empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id,
//						"mef_form_title" => $mefFormTitle,
//						"mef_form_number" => $formNumber,
//						"last_modified_date" => date('Y-m-d H:i:s', time())
//					);
//					$affected = DB::table('mef_officer_history')
//						->insert($dataArray);
//					if($this->mefOfficerObj->is_register == 2){
//						$array = array(
//							"is_register" => 3,
//							"is_visited" => 0
//						);
//						//dd($array);
//						$updateMefOfficer = DB::table('mef_officer')
//							->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)
//							->update($array);
//					}
//					return 1;
//				}
//			}
//		}else{
//			return 0;
//		}
//	}


	// Version 1
	public function officerHistory_Backup($table,$newFieldArray,$editId=null){
		if($this->mefOfficerObj->is_register >= 2){
			$dataTableObj = DB::table($table)->where('MEF_OFFICER_ID', empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)->first();
			if($dataTableObj != null){
				$dataHistoryArray = array();
				foreach($newFieldArray as $key=>$val){
					if($dataTableObj->{$key} != $val){
						$dataHistoryArray[]	=	array(
							"mef_officer_id" => empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id,
							"mef_table_name" => $table,
							"mef_field_name" => $key,
							"mef_field_value" => $dataTableObj->{$key}
						);
					}
				}
				if(count($dataHistoryArray) > 0){
					$affected = DB::table('mef_officer_history')
								->insert($dataHistoryArray);
					if($this->mefOfficerObj->is_register == 2){
						$array = array(
							"is_register" => 3,
							"is_visited" => 0
						);
						$updateMefOfficer = DB::table('mef_officer')
											->where('Id',empty($this->userGuestSession->Id) ? $editId : $this->userGuestSession->Id)
											->update($array);		
					}			
					return 1;
				}else{
					return 0;
				}
			}
			else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	/*
	public function officerHistoryMultipleRow($table,$newFieldArrayMutilpleRow){
		$dataTableObjMultipleRow = DB::table($table)->where('MEF_OFFICER_ID', $this->userGuestSession->Id)->get();
		var_dump($dataTableObjMultipleRow);
		var_dump($newFieldArrayMutilpleRow);
		if($this->mefOfficerObj->is_register >= 2){
			
		}else{
			return 0;
		}
	}
	*/
	
	public function updateMefOfficerIsRegister($isRegister,$editId=null){
		$firstMefOfficer 	= DB::table('mef_officer')
								->where('Id',$editId)
								->first();
		$is_register_db 	= 	$firstMefOfficer->is_register;
		$array = array(
			"is_register" => $isRegister
		);
		if($is_register_db == 2 || $is_register_db == 3){
			if($isRegister == 0){
				$array = array(
					"is_register" => 3
				);
			}
		}
		$updateMefOfficer = DB::table('mef_officer')
							->where('Id',$editId)
							->update($array);
		return "success";
	}
	
}
?>