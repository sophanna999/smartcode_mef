<div id="family-situation" class="<?php echo $blgFadeEditClass; ?>" ng-controller="familySituationController">
<form name="family-situation">
{{--	<h2>{{trans('officer.family_situation')}}</h2><br>--}}
	<div class="row">
		<div class="block-6">
			<img src="images/help.png" title="" class="help">
		</div>
	</div>

    <div class="form-group">
    	<div class="tblSection">
		<div class="row"><h3>{{trans('family_situation.parent_info')}}</h3></div>
		<div class="row" style="margin-top:10px;">
		    <div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label><span class="col-red">*</span>{{trans('officer.father_name_kh')}}</label></div>
			<div class="col-lg-3 col-sm-3 col-xs-3">
			   <input type="text" placeholder="{{trans('officer.father_name_kh')}}" id="fatherNameKh" class="w100 parentNameKh" ng-model="family.FATHER_NAME_KH">
			</div>
			<div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label><span class="col-red">*</span>{{trans('officer.father_name_en')}}</label></div>
			<div class="col-lg-3 col-sm-3 col-xs-3">
			   <input type="text" placeholder="{{trans('officer.father_name_en')}}" id="fatherNameEn" class="w100 parentNameEn" ng-model="family.FATHER_NAME_EN">
			</div>
			<div class="col-lg-2 col-sm-2 col-xs-2" style="margin-top:5px;">
			   <label><input type="radio" name="fLive" id="fatherDie" ng-model="family.FATHER_LIVE"​​​ class="parentStatus" value="ស្លាប់" ng-click="fatherStatusIsDied();">{{trans('family_situation.dei')}}</label>
			   <label style="margin-left:5px;"><input type="radio" name="fLive" id="fatherLive" ng-model="family.FATHER_LIVE" class="parentStatus" value="រស់" ng-click="fatherStatusIsLived();">{{trans('family_situation.alive')}}</label>
			</div>
		</div>
		<div class="row" style="margin-top: 5px;">
			<div class="col-lg-2 col-sm-2 col-xs-3" style="margin-top: 15px;"><label><span class="col-red">*</span>{{trans('officer.date_of_birth')}}</label></div>
			<div class="col-lg-3 col-sm-3 col-xs-2">
			   <input type="hidden" id="father-date-value" value="">
			    <div id="fatherBD"></div>
			</div>
			<div class="col-lg-1 col-sm-1" style="margin-top: 10px;"><label><span class="col-red">*</span>{{trans('personal_info.nationaley')}}</label></div>
			<div class="col-lg-3 col-lg-offset-1 col-sm-3 col-xs-3">
			   <input type="text" placeholder="១." id="fatherNationality" class="w100 parentNationality" ng-model="family.FATHER_NATIONALITY_1">
			</div>
			<div class="col-lg-2 col-sm-2 col-xs-2">
			   <input type="text" placeholder="២." id="fatherNationality_2" class="w100 parentNationality" ng_model="family.FATHER_NATIONALITY_2">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label><span id="fatherDied" class="col-red">*</span>{{trans('officer.address')}}</label></div>
			<div class="col-log-10 col-sm-10 col-xs-10">
			   <input type="text" placeholder="{{trans('officer.address')}}" id="fatherAddress" class="w100 parentAddress" ng-model="family.FATHER_ADDRESS">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label><span id="fatherWorking" class="col-red">*</span>{{trans('officer.father_job')}}</label></div>
			<div class="col-lg-3 col-sm-3 col-xs-10">
			   <input type="text" placeholder="{{trans('officer.father_job')}}" id="fatherCareer" class="w100 parentCareer" ng-model="family.FATHER_JOB">
			</div>
			<div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label>{{trans('officer.appreciate_unit')}}</label></div>
			<div class="col-lg-5 col-sm-4 col-xs-10">
			   <input type="text" id="f_unit" placeholder="{{trans('officer.appreciate_unit')}}" class="w100 parentProcurement" ng-model="family.FATHER_UNIT">
			</div>
		</div>
		<hr>
		<div class="row">
			 <div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label><span class="col-red">*</span>{{trans('family_situation.mother_name_kh')}}</label></div>
			<div class="col-lg-3 col-sm-3 col-xs-3">
			   <input type="text" placeholder="{{trans('family_situation.mother_name_kh')}}" id="motherNameKh" class="w100 parentNameKh" ng-model="family.MOTHER_NAME_KH">
			</div>
			<div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label><span class="col-red">*</span>{{trans('family_situation.mother_name_en')}}</label></div>
			<div class="col-lg-3 col-sm-3 col-xs-3">
			   <input type="text" placeholder="{{trans('family_situation.mother_name_en')}}" id="motherNameEn" class="w100 parentNameEn" ng-model="family.MOTHER_NAME_EN">
			</div>
			<div class="col-lg-2 col-sm-2 col-xs-2" style="margin-top:5px;">
			   <label><input type="radio" name="mLive" id="motherDie" ng-model="family.MOTHER_LIVE" class="parentStatus" value="ស្លាប់" ng-click="motherStatusIsDied();">{{trans('family_situation.dei')}}</label>
			   <label style="margin-left:5px;"><input type="radio" name="mLive" id="motherLive" ng-model="family.MOTHER_LIVE" class="parentStatus" value="រស់" ng-click="motherStatusIsLived();">{{trans('family_situation.alive')}}</label>
			</div>
		</div>
		<div class="row" style="margin-top: 5px;">
			<div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label><span class="col-red">*</span>{{trans('officer.date_of_birth')}}</label></div>
			<div class="col-lg-3 col-sm-3 col-xs-3">
			    <input type="hidden" id="mother-date-value" value="">
			    <div id="motherBD"></div>
			</div>
			<div class="col-lg-1 col-sm-1" style="margin-top: 10px;"><label><span class="col-red">*</span>{{trans('personal_info.nationaley')}}</label></div>
			<div class="col-lg-3 col-sm-3 col-lg-offset-1 col-xs-3">
			   <input type="text" id="motherNationality" class="w100 parentNationality" placeholder="១." ng-model="family.	MOTHER_NATIONALITY_1">
			</div>
			<div class="col-lg-2 col-sm-2 col-xs-2">
			   <input type="text" id="motherNationality_2" class="w100 parentNationality" placeholder="២." ng-model="family.MOTHER_NATIONALITY_2">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label><span id="motherDied" class="col-red">*</span>{{trans('officer.address')}}</label></div>
			<div class="col-lg-10 col-sm-10 col-xs-10">
			   <input type="text" id="motherAddress" class="w100 parentAddress" placeholder="{{trans('officer.address')}}" ng-model="family.MOTHER_ADDRESS">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label><span id="motherWorking" class="col-red">*</span>{{trans('family_situation.mother_name_job')}}</label></div>
			<div class="col-lg-3 col-sm-3 col-xs-10">
			   <input type="text" id="motherCareer" class="w100 parentCareer" placeholder="មុខរបរ" ng-model="family.MOTHER_JOB">
			</div>
			<div class="col-lg-2 col-sm-2" style="margin-top: 15px;"><label>{{trans('officer.appreciate_unit')}}</label></div>
			<div class="col-lg-5 col-sm-5 col-xs-10">
			   <input type="text" id="m_unit" class="w100 parentProcurement" placeholder="{{trans('officer.appreciate_unit')}}" class="w100" ng-model="family.MOTHER_UNIT">
			</div>
		</div>

		<div class="row"><h3>{{trans('family_situation.sibling_info')}}</h3></div>
		<table class="table table-bordered">
			<thead>
			  <tr>
				<th class="text-center">{{trans('trans.autoNumber')}}</th>
				<th class="text-center">{{trans('officer.full_name')}}</th>
				<th class="text-center">{{trans('officer.english_name')}}</th>
				<th class="text-center">{{trans('personal_info.gender')}}</th>
				<th class="text-center">{{trans('officer.date_of_birth')}}</th>
				<th class="text-center">{{trans('family_situation.job')}} ({{trans('officer.working_place')}})</th>
				<th></th>
			  </tr>
			</thead>
			<tbody>
				<tr ng-repeat="(key, value) in family_sib">
					<td class="text-center">@{{dayFormat(key + 1)}}</td>
					<td class="text-center">
						<input type="text" id="siblingNameKh_@{{key}}" class="w100" placeholder="{{trans('officer.full_name')}} និងនាម">
					</td>
					<td class="text-center">
						<input type="text" id="siblingNameEn_@{{key}}" class="w100" placeholder="{{trans('officer.english_name')}}"></td>
					<td class="text-center">
						<label><input type="radio" id="siblingFemal_@{{key}}" name="sibGender_@{{key}}" value="ស្រី">{{trans('personal_info.woman')}}</label>
						<label style="margin-left:5px;"><input type="radio" id="siblingMal_@{{key}}" name="sibGender_@{{key}}" value="ប្រុស">{{trans('personal_info.man')}}</label>
					</td>
					<td>
						<input type="hidden" id="sibling-date-value_@{{key}}" value="">
						<div id="siblingBD_@{{key}}" class="text-center"></div>
					</td>
					<td class="text-center">
						<input type="text" id="siblingCareer_@{{key}}" placeholder="{{trans('family_situation.job')}} ({{trans('officer.working_place')}})" class="w100">
					</td>
					<td class="text-center">
						<button type="button" ng-if="key != 0" ng-click="removeMoreFamilySibling(key)">
							<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
						</button>
					</td>
				</tr>
				<tr>
					<td colspan="6" class="text-right">
						<label>{{trans('family_situation.more_sibling_info')}}</label>
					</td>
					<td class="text-center">
						<button type="button" ng-click="addMoreFamilySibling()">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="row row-fam">
		    <div class="pull-left col-xs-6"><h3>{{trans('family_situation.sp_family')}}</h3></div>
			<div class="pull-right col-xs-6 text-right" style="margin-top:10px;">
			    <label><input type="checkbox" id="spNonMarried" class="spFamily" ng-model="spFamily.nonMarried" value="005">{{trans('personal_info.singal')}}</label>
				<label style="margin-left:5px;"><input type="checkbox" id="spMarried" class="spFamily" ng-model="spFamily.married" value="006">{{trans('personal_info.married')}}</label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2" style="margin-top: 15px;"><span id="federationNameKh" class="col-red display-none">*</span>{{trans('family_situation.name_of_spouse')}}</div>
			<div class="col-sm-3">
				<input type="text" placeholder="{{trans('family_situation.name_of_spouse')}}" id="spNameKh" class="w100" ng-model="family.SPOUSE_NAME_KH">
			</div>
			<div class="col-sm-2" style="margin-top:5px;"><label><span id="federationNameEn" class="col-red display-none">*</span>{{trans('officer.father_name_en')}}</label></div>
			<div class="col-sm-3 col-xs-3">
			   <input type="text" placeholder="{{trans('officer.father_name_en')}}" id="spNameEn" class="w100" ng-model="family.SPOUSE_NAME_EN">
			</div>
			<div class="col-sm-2 col-xs-2" style="margin-top:5px;">
			   <label><input type="radio" name="spLive" id="spStatusDie" class="spStatus" ng-model="family.SPOUSE_LIVE" value="ស្លាប់" ng-click="spouseDied();">{{trans('family_situation.dei')}}</label>
			   <label style="margin-left:5px;"><input type="radio" name="spLive" id="spStatusLive" class="spStatus" ng-model="family.SPOUSE_LIVE" value="រស់" ng-click="spouselived();">{{trans('family_situation.alive')}}</label>
		    </div>
		</div>
		<div class="row" style="margin-top: 5px;">
			<div class="col-sm-2" style="margin-top: 15px;"><label><span id="federationDOB" class="col-red display-none">*</span>{{trans('officer.date_of_birth')}}</label></div>
			<div class="col-sm-3 col-xs-3">
			    <input type="hidden" id="federation-date-value" value="">
			    <div id="federationBD"></div>
			</div>
			<div class="col-lg-1 col-sm-1" style="margin-top: 10px;"><label><span id="federationNationality" class="col-red display-none">*</span>{{trans('personal_info.nationaley')}}</label></div>
			<div class="col-lg-3 col-lg-offset-1 col-sm-3 col-xs-3">
			   <input type="text" class="w100 spNationality" id="spNationality" placeholder="១."  ng-model="family.SPOUSE_NATIONALITY_1">
			</div>
			<div class="col-sm-2 col-xs-2">
			   <input type="text" class="w100 spNationality" id="spNationality_2" placeholder="២." ng-model="family.SPOUSE_NATIONALITY_2">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2" style="margin-top:15px;"><label><span id="federationPOB" class="col-red display-none">*</span>{{trans('personal_info.place_of_birth')}}</label></div>
			<div class="col-sm-10 col-xs-10">
			   <input type="text"​ placeholder="{{trans('personal_info.place_of_birth')}}" id="spAddress" class="w100" ng-model="family.SPOUSE_POB">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2" style="margin-top:10px;"><label><span id="federationJOB" class="col-red display-none">*</span>{{trans('family_situation.job')}}</label></div>
			<div class="col-sm-3 col-xs-3">
			   <input type="text" placeholder="{{trans('family_situation.job')}}" id="spCareer" class="w100"​ ng-model="family.SPOUSE_JOB">
			</div>
			<div class="col-sm-1" style="margin-top:5px;"><label>{{trans('officer.working_place')}}</label></div>
			<div class="col-sm-3 col-xs-3">
			   <input type="text" placeholder="{{trans('officer.working_place')}}" id="spProcurement" class="w100" ng-model="family.SPOUSE_UNIT">
			</div>
			<div class="col-sm-1 no-space" style="margin-top:5px;"><label>{{trans('family_situation.spornsor')}} </label></div>
			<div class="col-sm-2 col-xs-2" style="margin-top:5px;">
			   <label><input type="radio" name="spornsor" id="spouseSponsor" class="isSpornsor" ng-model="family.SPOUSE_SPONSOR" value="មាន">{{trans('family_situation.have')}}</label>
			   <label style="margin-left:5px;"><input type="radio" name="spornsor" class="isSpornsor" ng-model="family.SPOUSE_SPONSOR" value="គ្មាន">{{trans('family_situation.not_have')}}</label>
		    </div>
		</div>
		<div class="row">
			<div class="col-lg-2 col-sm-2" style="margin-top:5px;"><label>{{trans('officer.phone_number')}}</label></div>
			<div class="col-lg-4 col-sm-3 col-xs-12" style="margin-top:5px;">
			   <input type="text" class="w100 spNumber" placeholder="១." ng-model="family_p_1.SPOUSE_PHONE_NUMBER">
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12" style="margin-top:5px;">
			   <input type="text" class="w100 spNumber" placeholder="២." ng-model="family_p_2.SPOUSE_PHONE_NUMBER">
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12" style="margin-top:5px;">
			   <input type="text" class="w100 spNumber" placeholder="៣." ng-model="family_p_3.SPOUSE_PHONE_NUMBER">
			</div>
		</div>
		<div style="padding-top:20px;"></div>
		<div class="row row-fam">
		    <div class="pull-left col-xs-6"><h3>{{trans('family_situation.child_info')}}</h3></div>
			<div class="pull-right col-xs-6 text-right" style="margin-top:10px;">
			    <label><input type="checkbox" id="fChildrenIdExist" class="fChildren" ng-model="children.exist" value="007" ng-click="enableChildrenTextFields();">{{trans('family_situation.have_child')}}</label>
				<label style="margin-left:5px;"><input type="checkbox" id="fChildrenIdNon" class="fChildren" ng-model="children.non" value="008" ng-click="disableChildrenTextFields()">{{trans('family_situation.dont_have_child')}}</label>
			</div>
		</div>
		<table class="table table-bordered">
			<thead>
			  <tr>
				<th class="text-center">{{trans('trans.autoNumber')}}</th>
				<th class="text-center"><span id="nameKh-red" class="col-red">*</span>{{trans('officer.full_name')}}</label></div>
			<div class="col-sm-3 col-xs-3"></th>
				<th class="text-center"><span id="nameEn-red" class="col-red">*</span>{{trans('officer.english_name')}}</th>
				<th class="text-center"><span id="gender-red" class="col-red">*</span>{{trans('personal_info.gender')}}</th>
				<th class="text-center"><span id="dob-red" class="col-red">*</span>{{trans('officer.date_of_birth')}}</th>
				<th class="text-center"><span id="career-red" class="col-red">*</span>{{trans('family_situation.job')}}</th>
				<th class="text-center" colspan="2"><span id="spornsor-red" class="col-red">*</span>{{trans('family_situation.spornsor')}}</th>

			  </tr>
			</thead>
			<tbody>
			  <tr ng-repeat="(key, value) in family_c">
				<td class="text-center">@{{dayFormat(key + 1)}}</td>
				<td class="text-center">
					<input type="text" placeholder="{{trans('officer.full_name')}}" id="childrenNameKh_@{{key}}" class="w100 childrenNameKh">
				</td>
				<td class="text-center">
					<input type="text" placeholder="{{trans('officer.english_name')}}" id="childrenNameEn_@{{key}}" class="w100 childrenNameEn">
				</td>
				<td class="text-center">
					<label><input type="radio" id="childrenFemal_@{{key}}" name="cGender_@{{key}}" value="ស្រី">{{trans('personal_info.woman')}}</label>
				    <label style="margin-left:5px;"><input type="radio" id="childrenMal_@{{key}}" name="cGender_@{{key}}" value="ប្រុស">{{trans('personal_info.man')}}</label>
				</td>
				<td class="text-center">
					<input type="hidden" id="children-date-value_@{{key}}">
			        <div id="childrenBD_@{{key}}"></div>
				</td>
				<td class="text-center">
					<input type="text" placeholder="{{trans('family_situation.job')}}" id="childrenCareer_@{{key}}" class="w100 childrenCareer">
				</td>
				<td class="text-center">
					<label><input type="radio" id="childrenExistSpornsor_@{{key}}" name="cSponsor_@{{key}}" value="មាន">{{trans('family_situation.have')}}</label>
				    <label style="margin-left:5px;"><input type="radio" id="childrenNoneSpornsor_@{{key}}" name="cSponsor_@{{key}}" value="គ្មាន">{{trans('family_situation.not_have')}}</label>
				</td>
				<td class="text-center">
					<button ng-if="key != 0" type="button" ng-click="removeMoreFamilyChildren(key)">
						<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
					</button>
				</td>
			  </tr>
			  <tr>
				<td colspan="7" class="text-right">
					<label>{{trans('family_situation.more_child_info')}}</label>
				</td>
				<td class="text-center">
					<button type="button" id="button-add" ng-click="addMoreFamilyChildren()">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</button>
				</td>
			  </tr>
			</tbody>
		</table>
		<div class="modal-confirm modal fade" id="ModalConfirm_sib" role="dialog">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-body">
				<h4>{{$constant['AreYouSure']}}</h4>
			  </div>
			  <div class="modal-footer">
				<button id="btnRemoveWorkHistory_sib" ng-click="removeMoreFamilySibling()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">{{$constant['Cancel']}}</button>
			  </div>
			</div>
		  </div>
		</div>

		<div class="modal-confirm modal fade" id="ModalConfirm_c" role="dialog">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-body">
				<h4>{{$constant['AreYouSure']}}</h4>
			  </div>
			  <div class="modal-footer">
				<button id="btnRemoveWorkHistory_c" ng-click="removeMoreFamilyChildren()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">{{$constant['Cancel']}}</button>
			  </div>
			</div>
		  </div>
		</div>

		</div>
		<div class="row" style="margin-left: 0px;">
			<div class="btn-save ">
				@if($viewControllerStatus == true)
                	<a href="#ability-foreign-language"  class="btn btn-primary btn-edit"><i class="fa fa-arrow-left"></i> {{trans('trans.buttonPrev')}}</a>
				@endif
				<button type="button" class="btn btn-primary btn-edit" ng-click="saveFamilySituation(url)">{{trans('trans.buttonSave')}} <i class="fa fa-save"></i></button>
				@if($viewControllerStatus == false)
					<a href="javascript:void(0);" class="btn btn-primary btn-edit btn-close" ng-click="closeForm('FormFamilySituation')" dataFormId="FormFamilySituation"><i class="fa fa-close"></i> {{trans('trans.buttonclose')}} </a>
				@endif
			</div>
			<div class="pull-right group-btn-right">
				@if($viewControllerStatus == true)
					<a href="javascript:void(0);" title="SUBMIT"><button type="button" class="btn btn-primary btn-edit" ng-click="submitToAdmin()"><i class="fa fa-file-code-o"></i> {{trans('family_situation.submit')}}</button></a>
				@endif
				{{--@if($viewControllerStatus == true)--}}
					{{--<a href="{{asset('background-staff-gov-info/reassured')}}" target="_blank"><button type="button" id="btn-forwoard" class="btn btn-primary btn-edit" ng-click="saveFamilySituation(url)"><i class="fa fa-print"></i> {{trans('family_situation.print')}}</button></a>--}}
				{{--@endif--}}
			</div>
		</div>
	</div>
</form>
</div>

<script>
	// Help hover
	$( ".block-6 .help" ).tooltip({ content: '<img src="images/8.png"  class="tooltip-img" />' });
	$('input.fChildren').on('change', function() {
		$('input.fChildren').not(this).prop('checked', false);
	});
</script>

<style>
	.no-space{
		margin-left : 0px !important;
		padding-left : 0px !important;
	}
	.no-right{
		margin-right : 0px !important;
		padding-right : 0px !important;
	}
	input[type="checkbox"]{
	  width: 20px;
	  height: 20px;

	}
</style>