<?php
$jqxPrefix = '_user';
$resetPasswordUrl = asset($constant['secretRoute'].'/user/ajax-save-reset-password');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data" action="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($Id) ? $Id:0}}">
        <div class="form-group"></div>

        <div class="form-group">
            <div class="col-sm-4 text-right"><span class="red-star">*</span>{{trans('users.newPassword')}}</div>
            <div class="col-sm-8">
                <input type="password" class="form-control input-md" placeholder="{{trans('users.newPassword')}}" id="password" name="password">
            </div>
        </div>
       
        <div class="form-group text-right">
            <div class="col-xs-6 col-xs-offset-6">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('users.changePassword')}}</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,130,35);
         $("#password").jqxPasswordInput();
         
        /*Form validation goes here...*/
        $('#jqx-form<?php echo $jqxPrefix;?>').jqxValidator({
            rules: [
                {input: '#password', message: 'សូមបញ្ចូលពាក្យសម្ងាត់', action: 'keyup blur', rule: 'required'}
            ]
        });
        //Save action
        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
            saveJqxItem('{{$jqxPrefix}}', '{{$resetPasswordUrl}}', '{{ csrf_token() }}');
        });

    });
</script>