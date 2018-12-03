<div style="overflow-x:auto;">
  <table class="table table-hover">
        <tr class="active">
          <th>Form</th>
          <th>{{trans('officer.form_name')}}</th>
          <th>{{trans('officer.last_date_edit')}}</th>
        </tr>
    @foreach($rows as $index=>$value)
    <?php
		$last_modified_date = date('d/m/Y h:i:s A',strtotime($value->last_modified_date));
	?>	
    <tr>
      <td>{{$tool->dayFormat($value->mef_form_number)}}</td>
      <td>{{$value->mef_form_title}}</td>
      <td>{{$last_modified_date}}</td>
    </tr>
    @endforeach
    @if(empty($rows))
    	<tr>
        	<td colspan="3" style="color:#E83437; font-weight:bold;font-family:'KHMERMEF1';font-size:14px"> {{trans('officer.no_action_edit_form')}}</td>
        </tr>
    @endif
  </table>
</div>