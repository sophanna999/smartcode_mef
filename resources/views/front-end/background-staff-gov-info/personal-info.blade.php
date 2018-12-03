<div id="personal-info" class="<?php echo $blgFadeEditClass; ?>">
    <form name="personal-info-form" enctype="multipart/form-data" ng-controller="personalInfoController">
		<section class="block-1">
			{{--<h2>{{trans('personal_info.persional_info')}}</h2>--}}
			<!--
			<div id="DIV_AVATAR" class="fileUpload" ng-click="fileUploadAction();">
				<img class="img-responsive" id="imageShow" ng-src="@{{info.AVATAR}}" />
			</div>
			-->
			<div class="cropme fileUpload" id="landscape" style="width: 125px; height: auto">
				<img class="img-responsive" id="imageShow" ng-src="@{{info.AVATAR}}"/>
			</div>
			<img class="display-none" id="imageProfileCrop" />
			<!-- <p class="complete-filling"><i class="glyphicon glyphicon-ok item-click " data-id="9"> </i> បំពេញបានជោគជ័យ !!!</p> -->

      <div class="clear pt20 ws-1">
        <div class="row">
          <div class="col-md-3">
            <label>{{trans('personal_info.official_id')}}</label><br />
    				<input type="text" class="w100" ng-model="info.PERSONAL_INFORMATION" id="PERSONAL_INFORMATION" placeholder="{{trans('personal_info.official_id')}}" maxlength="10">
          </div>
          <div class="col-md-3">
            <label>{{trans('personal_info.official_id_card_of_mef')}}</label><br />
    				<input type="text" class="w100" ng-model="info.OFFICIAL_ID" id="OFFICIAL_ID"  placeholder="{{trans('personal_info.official_id_card_of_mef')}}" maxlength="4">
          </div>
          <div class="col-md-3">
            <label>{{trans('personal_info.unit_id')}}</label><br />
    				<input type="text" class="w100" ng-model="info.UNIT_CODE" id="UNIT_CODE" placeholder="{{trans('personal_info.unit_id')}}" maxlength="4">
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label><span class="col-red">*</span>{{trans('trans.title')}}</label><br/>
            <input type="hidden" id="mef_title_id" ng-model="info.TITLE_ID" value="">
            <div id="div_mef_title_id"></div>
          </div>
          <div class="col-md-3">
            <label><span class="col-red">*</span>{{trans('officer.full_name')}}</label>
    				<input type="text" class="w100" ng-model="info.FULL_NAME_KH" id="FULL_NAME_KH" placeholder="{{trans('officer.full_name')}}">
          </div>
          <div class="col-md-3">
            <label><span class="col-red">*</span>{{trans('officer.english_name')}}</label>
    				<input type="text" class="w100" ng-model="info.FULL_NAME_EN" id="FULL_NAME_EN" placeholder="{{trans('officer.english_name')}}" ng-change="info.FULL_NAME_EN=info.FULL_NAME_EN.toUpperCase();">
          </div>
        </div>
      </div>
			<div class="pt20 ws-3">
				<label><span class="col-red">*</span>{{trans('personal_info.gender')}}:</label>
				<label id="GENDER_MALE" class="pl10 warp-radio-gender"><input type="radio" name="GENDER" ng-model="info.GENDER" value="ប្រុស">{{trans('personal_info.man')}}</label>
				<label id="GENDER_FEMALE" class="pl20 warp-radio-gender"><input type="radio" name="GENDER" ng-model="info.GENDER" value="ស្រី">{{trans('personal_info.woman')}}</label>
			</div>
			<div class="pt20 ws-1 clear">
				<div class="pull-left" style="margin-top:5px;"><span class="col-red">*</span>{{trans('officer.date_of_birth')}}:</div>
				<div class="pull-left col-lg-3">
					<input type="hidden" id="DATE_OF_BIRTH" name="DATE_OF_BIRTH">
					<div id="DIV_DATE_OF_BIRTH"></div>
				</div>
				<div class="pull-left col-lg-6 col-md-12 col-xs-12">
					<label><input type="checkbox" class="Additnal_condition" id="NoMARRIED" ng-click="IsMARRIEDAction(false);">{{trans('personal_info.singal')}}</label>
					<label style="margin-left:5px;"><input class="Additnal_condition" type="checkbox" id="HaveMARRIED" ng-click="IsMARRIEDAction(true);">{{trans('personal_info.married')}}</label>
				</div>
			</div>
			<div class="clear pt20">
				<label style="margin-left:2%;"><span class="col-red">*</span>{{trans('personal_info.nationaley')}}</label>
				<input id="NATIONALITY_1" type="text" ng-model="info.NATIONALITY_1" placeholder="{{trans('personal_info.nationaley')}}">
				<label style="margin-left:2%;"><span class="col-red">*</span>ជនជាតិ</label>
				<input id="NATIONALITY_2" type="text" placeholder="ជនជាតិ" ng-model="info.NATIONALITY_2">
			</div>
			<div class="clear pt20 ws-1">
				<label><span class="col-red">*</span>{{trans('personal_info.place_of_birth')}}</label><br/>
				<input id="PLACE_OF_BIRTH" type="text" class="w100" ng-model="info.PLACE_OF_BIRTH" placeholder="{{trans('officer.place_of_birth')}}">
			</div>
			<div class="clear pt20 ws-1">
				<label>{{trans('officer.address')}}</label><br/>
				<div class="row">
					<div class="col-md-4">
						<label><span class="col-red">*</span>{{trans('trans.province')}}</label><br/>
						<input type="hidden" id="mef_province_id" ng-model="address.mef_province_id" value="">
						<div id="div_mef_province_id"></div>
					</div>
					<div class="col-md-4">
						<label><span class="col-red">*</span>{{trans('trans.district')}}</label><br/>
						<input type="hidden" id="mef_district_id" ng-model="address.mef_district_id" value="">
						<div id="div_mef_district_id"></div>
					</div>
					<div class="col-md-4">
						<label><span class="col-red">*</span>{{trans('trans.commune')}}</label><br/>
						<input type="hidden" id="mef_commune_id" ng-model="address.mef_commune_id" value="">
						<div id="div_mef_commune_id"></div>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-4">
						<label><span class="col-red">*</span>{{trans('trans.village')}}</label><br/>
						<input type="hidden" id="mef_village_id" ng-model="address.mef_village_id" value="">
						<div id="div_mef_village_id"></div>
					</div>
					<div class="col-md-4">
						<label>{{trans('trans.home_number')}}</label><br/>
						<input type="text" class="form-control" ng-model="address.house" placeholder="{{trans('trans.home_number')}}">
					</div>
					<div class="col-md-4">
						<label>{{trans('trans.street_number')}}</label><br/>
						<input type="text" class="form-control" ng-model="address.street" placeholder="{{trans('trans.street_number')}}">
					</div>
				</div>
				<!-- <input id="CURRENT_ADDRESS" type="text" class="w100" ng-model="info.CURRENT_ADDRESS" placeholder="{{trans('officer.address')}}"> -->
			</div>
			<div class="clear pt20 ws-2">
				<label><span class="col-red">*</span>{{trans('officer.email')}}</label><br/>
				<input id="EMAIL" type="email" class="w100" ng-model="info.EMAIL" placeholder="{{trans('officer.email')}}">
			</div>
			 <div class="pt20 ws-2">
				<label>{{trans('officer.phone_number')}}</label><br/>
				<input id="PHONE_NUMBER_1" type="tel" class="w50" ng-model="info.PHONE_NUMBER_1" placeholder="{{trans('officer.phone_number')}}ខ្សែទី១">
				<input type="tel" class="w50" ng-model="info.PHONE_NUMBER_2" placeholder="{{trans('officer.phone_number')}}​ខ្សែទី២">
			</div>
			<div class="clear pt20 ws-2">
				<label><span class="col-red">*</span>{{trans('personal_info.identity_card')}}</label><br/>
				<div>
					<input id="NATION_ID" type="text" class="w100" ng-model="info.NATION_ID" placeholder="{{trans('personal_info.identity_card')}}">
				</div>
			</div>
			<div class="pt20 ws-2">
				<label>{{trans('personal_info.deadline')}}</label>
				<div style="margin-top:5px;">
					<input type="hidden" id="NATION_ID_EXPIRED_DATE" name="NATION_ID_EXPIRED_DATE" value="">
					<div id="DIV_NATION_ID_EXPIRED_DATE"></div>
				</div>
			</div>
			<div class="clear pt20 ws-2">
				<label>{{trans('personal_info.passport')}}</label>
				<input type="text" class="w100" ng-model="info.PASSPORT_ID"  placeholder="{{trans('personal_info.passport')}}">
			</div>
			<div class="pt20 ws-2">
				<label>{{trans('personal_info.deadline')}}</label>
				<div style="margin-top:5px;">
					<input type="hidden" id="PASSPORT_ID_EXPIRED_DATE_VALUE" name="PASSPORT_ID_EXPIRED_DATE" value="">
					<div id="DIV_PASSPORT_ID_EXPIRED_DATE"></div>
				</div>
			</div>
			<div class="btn-save">
				<a href="javascript:void(0);" ng-click="postPersonalInfo()" class="btn btn-primary btn-edit">{{trans('trans.buttonSave')}} <i class="fa fa-save"></i> </a>
				@if($viewControllerStatus == true)
					<a href="#situation-public-info"  class="btn btn-primary btn-edit"> {{trans('trans.buttonNext')}} <i class="fa fa-arrow-right"></i></a>
				@endif
				@if($viewControllerStatus == false)
					<a href="javascript:void(0);" class="btn btn-primary btn-edit btn-close" ng-click="closeForm('FormPersonalInfoController')" dataFormId="FormPersonalInfoController">{{trans('trans.buttonclose')}}</a>
				@endif
			</div>

		</section>
	</form>
	<div id="modalCropImg">

	</div>
	<div id="listProvinceJson" class="display-none"><?php echo $listProvinceJson; ?></div>
</div>

<style>
	#landscape > img{
		width: 125px;
		height: 145px;
		border:1px solid #3333;
	}
	input[type="checkbox"]{
	  width: 20px;
	  height: 20px;

	}

	/*
		Author     : Tomaz Dragar
		Mail       : <tomaz@dragar.net>
		Homepage   : http://www.dragar.net
	*/


	#fileInput {
	  width: 0;
	  height: 0;
	  overflow: hidden;
	}

	#modal {
	  z-index: 10;
	  position: fixed;
	  top: 0px;
	  left: 0px;
	  width: 100%;
	  height: 100%;
	  background-color: #5F5F5F;
	  opacity: 0.95;
	  display: none;
	}
	#preview {
	  z-index: 11;
	  position: fixed;
	  top: 0px;
	  left: 0px;
	  display: none;
	  border: 4px solid #A5A2A2;
	  border-radius: 4px;
	  float: left;
	  font-size: 0px;
	  line-height: 0px;
	}
	#preview .buttons {
	  width: 36px;
	  position: absolute;
	  bottom: 0px;
	  right: -44px;
	}
	#preview .buttons .ok {
	  border: 4px solid #F5F5F5;
	  border-radius: 4px;
	  width: 36px;
	  height: 36px;
	  line-height: 0px;
	  font-size: 0px;
	  background-image: url({{asset('images/Ok.png')}});
	  background-repeat: no-repeat;
	}
	#preview .buttons .ok:hover { background-image: url({{asset('images/OkGreen.png')}});

	#preview .buttons .cancel {
	  margin-bottom: 4px;
	  border: 4px solid #F5F5F5;
	  border-radius: 4px;
	  width: 36px;
	  height: 36px;
	  line-height: 0px;
	  font-size: 0px;
	  background-image: url({{asset('images/Cancel.png')}});
	  background-repeat: no-repeat;
	}
	#preview .buttons .cancel:hover { background-image: url({{asset('images/CancelRed.png')}});
	h1{
	  display: block;
	  font-family: arial;
	  font-size: 35px;
	  color: #39acac;
	  margin-bottom: 20px;
	  margin-top: 20px;
	  font-weight: bold;
	}
	.simple-cropper-images{
	  width: 820px;
	  margin: 0 auto 20px;
	}
	.text{
	  font-family: arial;
	  font-size: 14px;
	  color: #4e4e4e;
	  margin-bottom: 20px;
	}
	.code{
	  font-family: arial;
	  font-size: 14px;
	  color: #4e4e4e;
	  margin-bottom: 20px;
	  background-color: #f1f1f1;
	  padding: 10px;
	}
</style>
