<?php
$jqxPrefix = '_news';
$saveUrl = asset($constant['secretRoute'] . '/news/save');
$getSecreateByMinistryId = asset($constant['secretRoute'] . '/office/get-secretary-by-ministry-id');
$getDepartmentBySecretariat = asset($constant['secretRoute'] . '/office/get-department-by-secretariat-id');
?>
<div class="container-fluid">
	<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>"
	      id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true"/>
		<input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}"><br>
		<div class="row">
			<div class="col-sm-3">
			
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3 text-right"><span class="red-star">*</span>@lang('news.news_category')</div>
			<div class="col-sm-9">
				<input type="hidden" class="form-control" id="news_category" name="news_category" value="{{isset($row->mef_meeting_type_id) ? $row->mef_meeting_type_id:''}}">
				<div id="div_news_category" ></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3 text-right"><span class="red-star">*</span>@lang('news.news_tag')</div>
			<div class="col-sm-9">
				<input type="hidden" class="form-control" id="news_tag" name="news_tag" value="{{isset($row->mef_news_tag_id) ? $row->mef_news_tag_id:''}}">
				<div id="div_news_tag" name="news_tag"></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3 text-right"><span class="red-star">*</span>@lang('news.title')</div>
			<div class="col-sm-9">
				<input class="form-control" name="title" id="title" value="{{isset($row->title) ? $row->title:''}}">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-3 text-right"><span class="red-star">*</span>@lang('news.short_description')</div>
			<div class="col-sm-9">
				<input class="form-control" name="short_description" id="short_description" value="{{isset($row->short_description) ? $row->short_description:''}}">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-3 text-right">@lang('news.url')</div>
			<div class="col-sm-9">
				<input class="form-control" name="url" id="url" value="{{isset($row->url) ? $row->url:''}}">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-3 text-right"><span class="red-star">*</span>@lang('news.long_description')</div>
			<div class="col-sm-9">
				<textarea class="form-control" id="long_description" name="long_description">{{isset($row->long_description) ? $row->long_description:''}}</textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3 text-right">@lang('news.icon')</div>
			<div class="col-sm-9">
				<?php $avatar = isset($row->image) ? $row->image : asset('images/default.png'); ?>
				<input type="file" value="" class="form-control" id="image" name="image" accept="image/*">
				<div class="red-star" style="padding-top:5px">{{trans('news.image_size')}}​ 520X310</div>
				<div class="wrap-avatar" id="wrap-avatar">
					<input type="hidden" name="statusRemovePicture" value="0" id="statusRemovePicture"/>
					<img class="img-user" id="img-user" src="{{$avatar == "" ? asset("images/default.png") : asset($avatar)}}" alt="">
					<?php $statusRemoveAvatar = isset($row->image) ? $row->image : ""; ?>
					<span class="remove-avatar {{$statusRemoveAvatar == '' ? "display-none" : ''}}"><i class="glyphicon glyphicon-remove"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3 text-right"> </div>
			<div class="col-sm-9">
				<input type="hidden" id="is_mef_news" name="is_mef_news"
				       value="{{isset($row->is_mef_news) ? $row->is_mef_news:0}}">
				<div id="is_mef_news-checkbox">@lang('news.is_mef_news')</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3 text-right"> </div>
			<div class="col-sm-9">
				<input type="hidden" id="latest_news" name="latest_news"
				       value="{{isset($row->latest_news) ? $row->latest_news:0}}">
				<div id="latest_news-checkbox">@lang('news.latest_news')</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3 text-right"> </div>
			<div class="col-sm-9">
				<input type="hidden" id="is_publish" name="is_publish"
				       value="{{isset($row->is_publish) ? $row->is_publish:0}}">
				<div id="is_publish-checkbox"> @lang('news.is_publish')</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-10 col-sm-2">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> @lang('trans.buttonSave')</button>
			</div>
		</div>
	</form>
</div>
<style>
	.cke_dialog{
		z-index: 999999 !important;
		border: 1px solid rgba(105, 105, 105, 0.43) !important;
	}
	.textarea-required {
		border: 1px solid red !important;
	}
</style>
<script>

	$(document).ready(function () {
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
		initialButton(buttons, 90, 30);

		CKEDITOR.replace('long_description', {
			filebrowserImageBrowseUrl: '{{asset('/laravel-filemanager?type=Images')}}',
			filebrowserImageUploadUrl: '{{asset('/laravel-filemanager/upload?type=Images')}}&_token={{csrf_token()}}',
			filebrowserBrowseUrl: '{{asset('/laravel-filemanager?type=Files')}}',
			filebrowserUploadUrl: '{{asset('laravel-filemanager/upload?type=Files')}}&_token={{csrf_token()}}'
		});

		var isMefNews = $('#is_mef_news').val() == 1 ? true : false;
		$("#is_mef_news-checkbox").jqxCheckBox({theme: jqxTheme, width: 120, height: 25, checked: isMefNews});
		$('#is_mef_news-checkbox').on('change', function (event) {
		event.args.checked == true ? $('#is_mef_news').val(1) : $('#is_mef_news').val(0);
		});
		// is publish checkbox
		var isActive = $('#is_publish').val() == 1 ? true : false;
		$("#is_publish-checkbox").jqxCheckBox({theme: jqxTheme, width: 120, height: 25, checked: isActive});
		$('#is_publish-checkbox').on('change', function (event) {
			event.args.checked == true ? $('#is_publish').val(1) : $('#is_publish').val(0);
		});
		// is publish latest_news
		var isLatestNews = $('#latest_news').val() == 1 ? true : false;
		$("#latest_news-checkbox").jqxCheckBox({theme: jqxTheme, width: 120, height: 25, checked: isLatestNews});
		$('#latest_news-checkbox').on('change', function (event) {
			event.args.checked == true ? $('#latest_news').val(1) : $('#latest_news').val(0);
		});

		// news category select box

		initDropDownList(jqxTheme, "100%",30, '#div_news_category', <?php echo $list_news_category?>, 'text', 'value', false, '', '0', "#news_category","",200);
		$('#div_news_category').jqxDropDownList('selectItem', "{{isset($row->mef_news_category_id)?$row->mef_news_category_id:''}}");

		initDropDownList(jqxTheme, "100%",30, '#div_news_tag', <?php echo $list_news_tag?>, 'text', 'value', false, '', '0', "#news_tag","",200);
		$('#div_news_tag').jqxDropDownList('selectItem', "{{isset($row->mef_news_tag_id) ? $row->mef_news_tag_id:''}}");
		// multi select box news tag


		// form validate
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
			hintType: 'label',
			rules: [
				{
					input: '#title', message: ' ', action: 'blur', rule: 'required'
				},
				{
					input: '#short_description', message: ' ', action: 'blur', rule: 'required'
				},
				{
					input: '#long_description', message: ' ', action: 'blur',
					rule: function () {
						var textarea = CKEDITOR.instances.long_description.getData();
						$('#long_description').val(textarea);
						if(textarea.trim() == ""){
							$('#long_description').siblings().addClass('textarea-required');
							CKEDITOR.instances['long_description'].updateElement();
							return false;
						}
						$('#long_description').siblings().removeClass('textarea-required');
						return true;
					}
				},
				{input: '#div_news_category', message: ' ', action: 'select',
					rule: function () {
						if($("#div_news_category").val() == ""){
							return false;
						}
						return true;
					}
				},
				{input: '#div_news_tag', message: ' ', action: 'select',
					rule: function () {
						if($("#div_news_tag").val() == ""){
							return false;
						}
						return true;
					}
				},
			]
		});
		//end

		// images upload
		$("#image").jqxFileUpload();
		$("#image").change(function () {
			var input = this;
			var reader = new FileReader();
			var img = new Image();
			reader.onload = function (e) {
				img.src = e.target.result;
				$('#img-user').attr('src', e.target.result);
				$('#statusRemovePicture').val(0);
				$('.remove-avatar').removeClass('display-none');
			};
			reader.readAsDataURL(input.files[0]);
		});
		$('.remove-avatar').click(function () {
			var defaultImage = '<?php echo asset("images/default.png"); ?>';
			$('#img-user').attr('src', defaultImage);
			$('#statusRemovePicture').val(1);
			$('#image').val("");
			$('.remove-avatar').addClass('display-none');
		});
		// end

		$("#jqx-save<?php echo $jqxPrefix;?>").click(function () {
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
		});
	});
</script>