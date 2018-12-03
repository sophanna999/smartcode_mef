<?php 
$jqxPrefix = '_officer_checkin_index';
$saveUrl = asset($constant['secretRoute'].'/officer-checkin/check-data');
?>
<div class="container-fluid">
<form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>        
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:180px;">
                <h4 style="line-height: normal;text-align: center;">សូមធ្វើការត្រួតពិនិត្យទិន្នន័យដែលបានដាក់បញ្ចូលក្នុងប្រព័ន្ធមុននិងធ្វើការបន្ថែមទិន្នន័យថ្មី <br>អរគុណ</h4>
				
            </div>
        </div>
		
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{trans('attendance.check')}}</button>
               
            </div>
        </div>
    </form>
    
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
        $('#jqxLoader').jqxLoader({ width: 150, height:120, isModal: false,text: 'ទិន្នន័យកំពុងពិនិត្យសូមធ្វើការរង់ចាំ...'});

        $("#jqx-save<?php echo $jqxPrefix;?>").click(function(){     
            $('#jqxLoader').jqxLoader('open');       
            saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}',1,function(response){
                $('#jqxLoader').jqxLoader('close');
            });
        });
    });
</script>
<style>
.jqx-loader{
    z-index:18008 !important;
}
</style>