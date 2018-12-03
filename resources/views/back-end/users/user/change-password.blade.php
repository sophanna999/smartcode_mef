<?php
$jqxPrefix = '_meeting';
$saveChangePasswordUrl = asset($constant['secretRoute'].'/user/save-change-password');
?>
@extends('layout.back-end')
@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data" action="{{$saveChangePasswordUrl}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="ajaxRequestJson" value="true" />
            <div class="form-group"></div>
            @if (Session::has('flash_notification.message'))
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-5 text-center">
                        <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ Session::get('flash_notification.message') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="form-group">
                <div class="col-sm-4 text-right"><span class="red-star">*</span>{{trans('users.currentPassword')}}</div>
                <div class="col-sm-5">
                    <input type="password" class="form-control input-md" placeholder=" {{trans('users.currentPassword')}}" id="password" name="password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4  text-right"><span class="red-star">*</span>{{trans('users.newPassword')}}</div>
                <div class="col-sm-5">
                    <input type="password" class="form-control input-md" placeholder=" {{trans('users.newPassword')}}" id="password-new" name="passwordNew" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4  text-right"><span class="red-star">*</span>{{trans('users.confirmNewChangeWord')}}</div>
                <div class="col-sm-5">
                    <input type="password" class="form-control input-md" placeholder=" {{trans('users.confirmNewChangeWord')}}" id="password-confirm-new" name="passwordConfirmNew" value="">
                </div>
            </div>
            <div class="form-group text-right">
                <div class="col-xs-3 col-xs-offset-6">
                    <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('trans.buttonSave')}}</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function(){
            var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
            initialButton(buttons,100,30);
			
			 $("#password").jqxPasswordInput();
			 $("#password-new").jqxPasswordInput();
			 $("#password-confirm-new").jqxPasswordInput();
			 
            /*Form validation goes here...*/
            $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
                onSuccess: function () {
                    document.getElementById("jqx-form<?php echo $jqxPrefix;?>").submit();
                },
                rules: [
                    {input: '#password', message: '{{trans('users.currentPassword')}}', action: 'keyup blur', rule: 'required'},
                    {input: '#password-new', message: '{{trans('users.newPassword')}}', action: 'keyup blur', rule: 'required'},
                    {input: '#password-confirm-new', message: '{{trans('users.confirmNewChangeWord')}}', action: 'blur', rule: 'required'},
                    {input: '#password-confirm-new', message: '{{trans('users.notMatchNewPass_Conf')}}', action: 'keyup, focus', rule: function (input, commit) {
                        if (input.val() === $('#password-new').val()) {
                            return true;
                        }
                        return false;

                    }}
                ]
            });
            //Save action
            $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
                $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator('validate');
            });

        });
    </script>
    <style>
        .close{
            font-family: Monospace;
        }
    </style>
@endsection