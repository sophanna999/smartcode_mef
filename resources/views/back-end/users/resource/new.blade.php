<?php
$jqxPrefix = '_resource';
$saveUrl = asset($constant['secretRoute'].'/resource/save');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="Id" name="Id" value="{{$Id}}">
        <input type="hidden" id="status" name="status" value="0">
        <input type="hidden" name="ajaxRequestJson" value="true" />
        <div class="form-group">
            <div class="col-sm-2 text-right">{{trans('users.parent')}}</div>
            <div class="col-sm-10">
				<input type="hidden" name="parent_id" id="parent_id<?php echo $jqxPrefix;?>" value="{{ isset($authentication->parent_id) ? $authentication->parent_id:0 }}">
                <div id="ddlresourses<?php echo $jqxPrefix;?>">
                    <div id="ddlTreeCategory<?php echo $jqxPrefix; ?>"></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 text-right"><span class="red-star">*</span>{{trans('users.customControllers')}}</div>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="{{trans('users.customControllers')}}" id="url" name="url" value="{{ isset($authentication->url) ? $authentication->url : '' }}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 text-right"><span class="red-star">*</span>{{trans('users.resources')}}</div>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="{{trans('users.resources')}}" id="name" name="name" value="{{ isset($authentication->name) ? $authentication->name:''}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 text-right"><span class="red-star">*</span>{{trans('news.order')}}</div>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="{{trans('news.order')}}" id="order" name="order" value="{{ isset($authentication->order) ? $authentication->order : '' }}">
            </div>
        </div>
       <div class="form-group">
            <div class="col-sm-2 text-right">{{trans('trans.description')}}</div>
            <div class="col-sm-10">
                <textarea class="form-control" rows="3" placeholder="{{trans('trans.description')}}" id="description" name="description">{{ isset($authentication->description) ? $authentication->description:''}}</textarea>
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-2 text-right">{{trans('news.image')}} </div>
            <div class="col-sm-10">
                <?php $icon = isset($authentication->icon) ? $authentication->icon : asset('icon/notepad.png'); ?>
                <input type="file" value="" class="form-control" id="my-avatar" name="icon"  accept="image/*">
                <div class="wrap-avatar" id="wrap-avatar">
                    <img class="" id="img-user" src="{{$icon == "" ? asset("icon/notepad.png") : asset($icon)}}" alt="" width="16" height="16">
					<span class="red-star">(16 x 16)px</span>
                </div>
            </div>
        </div>
		
		<div class="form-group">
            <div class="col-sm-offset-2 col-sm-2">
				<input type="hidden" id="active" name="active" value="{{isset($authentication->active) ? $authentication->active:1}}">
               <div id="active-checkbox"> {{trans('trans.active')}}</div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-10 col-sm-2">
				<button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
		
		//Dropdown parent
        jqxTreeDropDownList('ជ្រើសរើស',jqxTheme,705,350, '#ddlresourses<?php echo $jqxPrefix; ?>','#ddlTreeCategory<?php echo $jqxPrefix; ?>', <?php echo json_encode($listAuthentication);?>, '#parent_id<?php echo $jqxPrefix;?>', true, true);
		if($('#Id').val() != 0){
           $('#ddlresourses<?php echo $jqxPrefix;?>').jqxDropDownButton({disabled: true });
        }
		
		/* Save action */
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });
		
		/* Active */
		var isActive = $('#active').val() == 1 ? true:false;
		$("#active-checkbox").jqxCheckBox({ theme:jqxTheme ,width: 120, height: 25, checked: isActive});
		$('#active-checkbox').on('change', function (event) {
			event.args.checked == true ? $('#active').val(1):$('#active').val(0);
		});
		
		/* Icon */
		$("#my-avatar").jqxFileUpload();
        $("#my-avatar").change(function () {
            var input = this;
            var reader = new FileReader();
            var img = new Image();
            reader.onload = function (e) {
                img.src = e.target.result;
                $('#img-user').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        });
    });
</script>