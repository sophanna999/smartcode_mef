<?php
$jqxPrefix = '_tags';
$saveUrl = asset($constant['secretRoute'].'/tags/save');
?>
<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($row->Id) ? $row->Id:0}}">
        <div class="form-group">
            <div class="col-sm-4 text-right" style="margin-top: 10px"><span class="red-star">*</span>@lang('news.user_mood')</div>
            <div class="col-sm-8">
                <input type="hidden" class="form-control" id="user_mood" name="user_mood" value="{{isset($row->user_mood) ? $row->user_mood:''}}">
                <div id="div_user_mood"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 text-right"><span class="red-star">*</span>{{trans('news.tagName')}}</div>
            <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="{{trans('news.tagName')}}" id="name" name="name"  value="{{isset($row->name) ? $row->name:''}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 text-right"><span class="red-star">*</span>{{trans('news.order')}}</div>
            <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="{{trans('news.order')}}" id="order_number" name="order_number" value="{{ isset($row->order_number) ? $row->order_number : '' }}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 text-right">{{trans('news.avatar')}}</div>
            <div class="col-sm-8">
                <?php $avatar = isset($row->icon) ? $row->icon : asset('images/default.png'); ?>
                <input type="file" value="" class="form-control" id="my-avatar" name="icon" accept="image/*">
                <div class="red-star" style="padding-top:5px">{{trans('news.image_size')}}​ 32X32</div>
                <div class="wrap-avatar" id="wrap-avatar">
                    <input type="hidden" name="statusRemovePicture" value="0" id="statusRemovePicture" />
                    <img class="img-user" id="img-user" src="{{$avatar == "" ? asset("images/default.png") : asset($avatar)}}" alt="">
                    <?php $statusRemoveAvatar = isset($row->icon) ? $row->icon : ""; ?>
                    <span class="remove-avatar {{$statusRemoveAvatar == '' ? "display-none" : ''}}"><i class="glyphicon glyphicon-remove"></i></span>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-9 col-sm-3">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
            </div>
        </div>
    </form>
</div>
<script>

    $(document).ready(function(){
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);


        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            hintType:'label',
            rules: [
                {input: '#name', message: ' ', action: 'blur', rule: 'required'},
                {input: '#order_number', message: ' ', action: 'blur', rule: 'required'},
                {input: '#order_number', message: ' ', action: 'blur', rule: 'number'}
            ]
        });

	    initDropDownList(jqxTheme, 293,34, '#div_user_mood',<?php echo $user_mood?>, 'text', 'value', false, '', '0', "#user_mood","",135);
	    $('#div_user_mood').jqxDropDownList('selectItem', {{isset($row->user_mood)?$row->user_mood:0}});

        /* Save Action Button */
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}');
        });

        $("#my-avatar").jqxFileUpload();
        $("#my-avatar").change(function () {
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

        $('.remove-avatar').click(function(){
            var defautImage = '<?php echo asset("images/default.png"); ?>';
            $('#img-user').attr('src', defautImage);
            $('#statusRemovePicture').val(1);
            $('#my-avatar').val("");
            $('.remove-avatar').addClass('display-none');
        });

    });
</script>