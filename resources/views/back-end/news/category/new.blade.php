<?php
$jqxPrefix = '_news_category';
$saveUrl = asset($constant['secretRoute'] . '/news-category/save');
$news_category = json_encode($news_category);

?>
<div class="container-fluid">
	<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>"
	      id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ajaxRequestJson" value="true"/>
		<input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
		<div class="form-group">
			<div class="col-sm-4 text-right" style="margin-top: 10px"><span class="red-star">*</span>@lang('trans.status')</div>
			<div class="col-sm-8">
				<input type="hidden" class="form-control" id="category_status" name="category_status" value="{{isset($row->category_status) ? $row->category_status:''}}">
				<div id="div_category_status"></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 text-right" style="margin-top: 10px">{{trans('users.parent')}}</div>
			<div class="col-sm-8">
				<input type="hidden" name="parent_id" id="parent_id<?php echo $jqxPrefix;?>" value="{{ isset($row->parent_id) ? $row->parent_id:0 }}">
				<div id="ddlresourses<?php echo $jqxPrefix;?>">
					<div id="ddlTreeCategory<?php echo $jqxPrefix; ?>"></div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 text-right" style="margin-top: 10px"><span class="red-star">*</span>@lang('news.category_name')</div>
			<div class="col-sm-8">
				<input class="form-control" name="name" id="name" value="{{isset($row->name) ? $row->name:''}}">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 text-right" style="margin-top: 10px"><span class="red-star">*</span>@lang('news.order_number')</div>
			<div class="col-sm-8">
				<input class="form-control" name="order_number" id="order_number" value="{{isset($row->order_number) ? $row->order_number:''}}">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 text-right">@lang('news.image')</div>
			<div class="col-sm-8">
				<?php $avatar = isset($row->icon) ? $row->icon : asset('images/default.png'); ?>
				<input type="file" value="" class="form-control" id="icon" name="icon" accept="image/*">
				<div class="wrap-avatar" id="wrap-avatar">
					<input type="hidden" name="statusRemovePicture" value="0" id="statusRemovePicture"/>
					<img class="img-user" id="img-icon"
					     src="{{$avatar == "" ? asset("images/default.png") : asset($avatar)}}" alt="">
					<?php $statusRemoveAvatar = isset($row->icon) ? $row->icon : ""; ?>
					<span class="remove-avatar {{$statusRemoveAvatar == '' ? "display-none" : ''}}">
						<i class="glyphicon glyphicon-remove"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-9 col-sm-3">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> @lang('trans.buttonSave')</button>
			</div>
		</div>
	</form>
</div>
<script>

	$(document).ready(function () {
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons, 90, 30);

		initDropDownList(jqxTheme, 330,30, '#div_category_status',<?php echo $status?>, 'text', 'value', false, '', '0', "#category_status","",100);
		$('#div_category_status').jqxDropDownList('selectItem', {{isset($row->category_status)?$row->category_status:0}});

        //Dropdown Parent
        jqxTreeDropDownList('ជ្រើសរើស',jqxTheme,330,350, '#ddlresourses<?php echo $jqxPrefix; ?>','#ddlTreeCategory<?php echo $jqxPrefix; ?>', <?php echo $news_category;?>, '#parent_id<?php echo $jqxPrefix;?>', true, true);
        if($('#Id').val() != 0){
            $('#ddlresourses<?php echo $jqxPrefix;?>').jqxDropDownButton({disabled: true });
        }


        //Form Validation
		$('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
			hintType: 'label',
			rules: [
				{input: '#name', message: ' ', action: 'blur', rule: 'required'},
                {input: '#order_number', message: ' ', action: 'blur', rule: 'required'},
                {input: '#order_number', message: ' ', action: 'blur', rule: 'number'},
				{input: '#div_category_status', message: ' ', action: 'select',
					rule: function () {
						if($("#div_category_status").val() == ""){
							return false;
						}
						return true;
					}
				}
			]
		});
		$("#icon").jqxFileUpload();
		$("#icon").change(function () {
			var input = this;
			var reader = new FileReader();
			var img = new Image();
			reader.onload = function (e) {
				img.src = e.target.result;
				$('#img-icon').attr('src', e.target.result);
				$('#statusRemovePicture').val(0);
				$('.remove-avatar').removeClass('display-none');
			};
			reader.readAsDataURL(input.files[0]);
		});
		$('.remove-avatar').click(function () {
			var defaultImage = '<?php echo asset("images/default.png"); ?>';
			$('#img-icon').attr('src', defaultImage);
			$('#statusRemovePicture').val(1);
			$('#icon').val("");
			$('.remove-avatar').addClass('display-none');
		});
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function () {
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
		});
	});
</script>