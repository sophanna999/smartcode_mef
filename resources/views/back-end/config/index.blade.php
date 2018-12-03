<?php
$jqxPrefix = '_config';
$saveUrl = asset($constant['secretRoute'].'/config/save');
?>
@extends('layout.back-end')
@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data" action="{{$saveUrl}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="ajaxRequestJson" value="true" />
            <input type="hidden" name="Id" id="Id" value="{{isset($row->id) ? $row->id:''}}" />
            <div class="clearfix">&nbsp;</div>
            <div class="form-group">
                <div class="col-sm-4 text-right">{{$constant['configHeader']}}</div>
                <div class="col-sm-5">
                    <input type="text" class="form-control input-lg" placeholder="{{$constant['configHeader']}}" id="header" name="header" value="{{isset($row->header) ? $row->header:''}}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 text-right">{{$constant['institudeNameKH']}}</div>
                <div class="col-sm-5">
                    <input type="text" class="form-control input-lg" placeholder="{{$constant['institudeNameKH']}}" id="InstitutionName_KH" name="InstitutionName_KH" value="{{isset($row->InstitutionName_KH) ? $row->InstitutionName_KH:''}}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 text-right">{{$constant['institudeNameEN']}}</div>
                <div class="col-sm-5">
                    <input type="text" class="form-control input-lg" placeholder="{{$constant['institudeNameEN']}}" id="InstitutionName_EN" name="InstitutionName_EN" value="{{isset($row->InstitutionName_EN) ? $row->InstitutionName_EN:''}}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4  text-right">{{$constant['configLogo']}}</div>
                <div class="col-sm-5">
                    <?php $avatar = isset($row->avatar) ? $row->avatar : asset('images/default.png'); ?>
                    <input type="file" value="" class="form-control" id="my-avatar" name="avatar" accept="image/*">
                    <div><span class="red-star">(70 x 70)px</span></div>
                    <div class="wrap-avatar" id="wrap-avatar">
                        <input type="hidden" name="statusRemovePicture" value="0" id="statusRemovePicture" />
                        <img class="img-user" id="img-user" src="{{$avatar == "" ? asset("images/default.png") : asset($avatar)}}" alt="">
                        <?php $statusRemoveAvatar = isset($row->avatar) ? $row->avatar : ""; ?>
                        <span class="remove-avatar {{$statusRemoveAvatar == '' ? "display-none" : ''}}"><i class="glyphicon glyphicon-remove"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-group display-none">
                <div class="col-sm-4  text-right">{{$constant['configFooter']}}</div>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="{{$constant['configFooter']}}" id="footer" name="footer" value="{{isset($row->footer) ? $row->footer:''}}">
                </div>
            </div>

            <div class="form-group text-right">
                <div class="col-xs-3 col-xs-offset-6">
                    <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function(){
            var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
            initialButton(buttons,80,30);

            /************** LOGO **************/
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
                var defaultImage = '<?php echo asset("images/default.png"); ?>';
                $('#img-user').attr('src', defaultImage);
                $('#statusRemovePicture').val(1);
                $('#my-avatar').val("");
                $('.remove-avatar').addClass('display-none');
            });
            /************** END LOGO *************/

            //Save action
            $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
                document.getElementById("jqx-form<?php echo $jqxPrefix;?>").submit();
            });

        });
    </script>
@endsection