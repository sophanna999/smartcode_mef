<?php
$jqxPrefix = '_officer';
$resetPasswordUrl = asset($constant['secretRoute'].'/officer/save-reset-password');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data" action="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="ajaxRequestJson" value="true" />
        <input type="hidden" id="Id" name="Id" value="{{isset($id) ? $id:0}}">

        <div class="form-group">
            <div class="col-sm-4 text-right padding-top5"><span class="red-star">*</span>{{trans('users.user')}}</div>
            <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="" value="{{isset($user_name) ? $user_name:''}}" readonly>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 text-right padding-top5"><span class="red-star">*</span>{{trans('users.newPassword')}}</div>
            <div class="col-sm-8">
                <input type="password" class="form-control" placeholder="{{trans('users.newPassword')}}" id="password" name="password">
            </div>
        </div>
       
        <div class="form-group">
            <div class="col-xs-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-pencil"></span> {{trans('users.changePassword')}}</button>
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