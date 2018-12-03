<div id="ability-foreign" class="<?php echo $blgFadeEditClass; ?>" ng-controller="abilityLanguageController">
	<form name="ability-foreign">
{{--		<h2>{{trans('officer.ability_foreign_language')}}</h2><br>--}}
	<div class="row">
		<div class="block-6">
			<img src="images/help.png" title="" class="help">
		</div>
	</div>
	<div class="container-fluid no-space">
		<div class="table-responsive">
			<div class="tblSection">
			  <table class="table table-bordered">
				<thead>
				  <tr>
					<th class="text-title text-center">{{trans('trans.autoNumber')}}</th>
					<th class="text-title text-center">{{trans('officer.language')}}</th>
					<th class="text-title text-center">{{trans('officer.read')}}</th>
					<th class="text-title text-center">{{trans('officer.write')}}</th>
					<th class="text-title text-center">{{trans('officer.speak')}}</th>
					<th class="text-title text-center">{{trans('officer.listen')}}</th>
					<th class="text-title text-center"></th>
				  </tr>
				</thead>
				<tbody>
				  <tr ng-repeat="(key, value) in AbilityForeignLanguage">
					<td class="text-center">@{{dayFormat(key + 1)}}</td>
					<td class="text-center">
						<input type="hidden" id="language_@{{key}}" class="w100" name="language_@{{key}}" value="">
						<div id="div_language_@{{key}}"></div>
					</td>
					<td class="text-center">
						<input type="hidden" id="readingLevel_@{{key}}" name="readingLevel_@{{key}}" value="">
						<div id="div_reading_level_@{{key}}"></div>
					</td>
					<td class="text-center">
						<input type="hidden" id="writingLevel_@{{key}}" name="writingLevel_@{{key}}" value="">
						<div id="div_writing_level_@{{key}}"></div>
					</td>
					<td class="text-center">
						<input type="hidden" id="speakingLevel_@{{key}}" name="speakingLevel_@{{key}}" value="">
						<div id="div_speaking_level_@{{key}}"></div>
					</td>
					<td class="text-center">
						<input type="hidden" id="listeningLevel_@{{key}}" name="listeningLevel_@{{key}}" value="">
						<div id="div_listening_level_@{{key}}"></div>
					</td>
					<td class="text-center">
						<button ng-if="key >= 1" type="button" ng-click="removeAbilityLanguage(key)">
							<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
						</button>
					</td>
				  </tr>
				  <tr>
					<td colspan="6" class="text-right">
						<label>{{trans('ability_language.more_ability_foreign_language')}}</label>
					</td>
					<td class="text-center">
						<button type="button" ng-click="addMoreAbilityLanguage()">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					</td>
				   </tr>
				</tbody>
			  </table>
			</div> 
			<div class="modal-confirm modal fade" id="ModalConfirmAbilityLanguage" role="dialog">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-body">
					<h4>{{$constant['AreYouSure']}}</h4>
				  </div>
				  <div class="modal-footer">
					<button id="btnRemoveWorkHistory" ng-click="removeAbilityLanguage()" type="button" class="btn btn-primary btn-confrim-ok">{{$constant['Ok']}}</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">{{$constant['Cancel']}}</button>
				  </div>
				</div>
			  </div>
			</div>
		</div>
	</div>
		<div class="row" style="margin-left: 0px;">
			<div class="btn-save">
				@if($viewControllerStatus == true)
					<a href="#general-knowledge"  class="btn btn-primary btn-edit"><i class="fa fa-arrow-left"></i> {{trans('trans.buttonPrev')}}</a>
				@endif
				<button type="button" class="btn btn-primary btn-edit" ng-click="saveAbilityLanguage(url)">{{trans('trans.buttonSave')}} <i class="fa fa-save"></i></button>
				@if($viewControllerStatus == true)
					<a href="#family-situations"  class="btn btn-primary btn-edit">{{trans('trans.buttonNext')}} <i class="fa fa-arrow-right"></i></a>
					
				@endif
				@if($viewControllerStatus == false)
					<a href="javascript:void(0);" class="btn btn-primary btn-edit btn-close" ng-click="closeForm('FormAbilityForeign')" dataFormId="FormAbilityForeign">{{trans('trans.buttonclose')}}</a>
				@endif
			</div>
		</div>
	</form>
</div>
<div id="listTypeQualificationsJson" class="display-none"><?php echo json_encode($listTypeQualifications);?></div>
<div id="listWritingJson" class="display-none"><?php echo json_encode($listTypeQualifications);?></div>
<div id="listSpeakingJson" class="display-none"><?php echo json_encode($listTypeQualifications);?></div>
<div id="listListeningJson" class="display-none"><?php echo json_encode($listTypeQualifications);?></div>
<div id="listlanguageJson" class="display-none"><?php echo json_encode($listLanguage);?></div>

<script>
	// Help hover
	$( ".block-6 .help" ).tooltip({ content: '<img src="images/7.png"  class="tooltip-img" />' });
</script>

<style>
    .no-space{
		margin-left : 0px !important;
		padding-left : 0px !important;
	}
	.text-title{
		//font-size: 16px;
		//color: #8c8a8a;
		margin-bottom: 0px;
	}
	.btn-summit,.btn-next:hover{
		cursor:pointer
	}
</style>
