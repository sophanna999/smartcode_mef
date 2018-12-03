<?php 
$jqxPrefix = '_officer_checkin';
$saveUrl = asset($constant['secretRoute'].'/officer-checkin/save');
?>

<div class="container-fluid">
    <form class="form-horizontal" role="form" method="post" name="jqx-form<?php echo $jqxPrefix;?>" id="jqx-form<?php echo $jqxPrefix;?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:10px;"></div>
        
		<div class="form-group">
            <div class="col-sm-12" style="padding-bottom:15px;">
                <label><span class="red-star">*</span> {{trans('attendance.select_fingure_data')}}</label>
				<input type="file" name="pholiday[]" id="pholiday" multiple class="form-control">
            </div>
        </div>
		
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="jqx-save<?php echo $jqxPrefix;?>" type="button"><span class="glyphicon glyphicon-check"></span> {{$constant['buttonSave']}}</button>
            </div>
        </div>
    </form>
    <div class="table-responsive hide" id="tbl">
        <table class="table">
            
        </table>
    </div>
</div>

<style type="text/css">
    .jqx-combobox-content-disabled{
        color: #000 !important;;
    }
    .hide{
        /*display: none;*/
    }
</style>
<script>
    $(document).ready(function(){
		var buttons = ['jqx-save<?php echo $jqxPrefix;?>'];
        initialButton(buttons,90,30);
		/* Save action */
		$("#jqx-save<?php echo $jqxPrefix;?>").click(function(){
			
			saveJqxItem('{{$jqxPrefix}}', '{{$saveUrl}}', '{{ csrf_token() }}',function(respone){
				console.log(respone.data);
                if(respone.code==2){
                    // $.each(respone.data,function(key,value){
                    //     $.each(value,function(k,v){

                    //     });
                    // }).
                    var $html='';
                    $.each( respone.data, function( key, value ) {
                        if(key=='valid'){
                            $html += '<tr class="bg-primary">';
                            $html += '<td colspan="3">{{$constant["file-error"]}}</td>';
                            $html += '</tr>';
                            $html += '<tr>';
                            $html += '<td >លរ</td>';
                            $html += '<td>ឈ្មោះ file</td>';
                            $html += '<td>កាលបរិច្ឆទ</td>';
                            $html += '</tr>';
                        }
                        if(key=='invalid'){
                            $html += '<tr class="bg-danger">';
                            $html += '<td colspan="3">{{$constant["file-sucess"]}}</td>';
                            $html += '</tr>';
                            $html += '<tr>';
                            $html += '<td >លរ</td>';
                            $html += '<td>ឈ្មោះ file</td>';
                            $html += '<td>កាលបរិច្ឆទ</td>';
                            $html += '</tr>';
                        }

                        $.each(value, function( k, c ) {
                            $html += '<tr>';
                            $html += '<td >'+(k+1)+'</td>';
                            $html += '<td>'+c.filename+'</td>';
                            $html += '<td>'+c.date+'</td>';
                            $html += '</tr>';
                        });
                    });
                    $('.table').html($html);
                    $('#tbl').removeClass('hide');
                }
			});

		});


        $("#pholiday").jqxFileUpload();
	});
</script>