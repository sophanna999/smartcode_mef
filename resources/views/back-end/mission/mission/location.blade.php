<table class="table table-bordered">
    <tr>
        <th width="5%" class="text-center">{{trans('trans.autoNumber')}}</th>
        <th width="55%" class="text-left">{{trans('mission.direction')}}</th>
        <th width="30%" class="text-left">
          <a href="javascript:void(0)" id="btnAddProvince"><i class="glyphicon glyphicon-plus"></i> {{trans('mission.add').trans('general.location')}}</a>
        </th>
    </tr>
    <tbody id="mission_body">
      @if(isset($miss))
        @foreach ($miss->missionProvince()->orderBy('order','asc')->get() as $p => $pro) 
          <tr id="mission_tr_{{$p}}" class="mission_tr yes">
            <td class="text-center"><label class="no_order">{{($p+1)}}</label></td>
            <td colspan="2">
              <table class="table table-bordered">
                <tr>
                  <td colspan="2">
                    <input type="hidden" id="mef_mission_location_{{isset($p)? $p: 0}}" value="{{isset($pro->province_id) ? $pro->province_id:0}}">
                    <div id="dev_mef_mission_location_{{$p}}" name="province[]"></div>
                  </td>
                  <td>
                    <a href="javascript:void(0)" onclick="romoveProvinces(this)">
                        <i class="glyphicon glyphicon-trash"></i> {{trans("general.delete").trans("general.location")}}
                    </a>
                  </td>
                </tr>
                <tbody class="org_body">
                  @foreach ($miss->missionOrganization()->get() as $o => $org)
                      @if ($pro->mission_id ==$org->mission_id && $pro->province_id ==$org->province_id)
                         <tr>
                          <td></td>
                          <td>
                            <input
                              type="text"
                              class="form-control"
                              name="organization[mission_tr_{{$p}}][]"
                              value="{{isset($org->organization_id)?$org->organization_id:''}}"
                              placeholder="ស្ថាប័ន"
                              id="">
                          </td>
                          <td><a href="javascript:void(0)" onclick="AddOrg(this)"><i class="glyphicon glyphicon-plus"></i> {{trans('mission.add')}}</a></td>
                        </tr>
                      @endif
                  @endforeach
                  @if($miss->missionOrganization()->count()==0)
                    <tr>
                      <td></td>
                      <td><input type="text" class="form-control" name="organization[mission_tr_0][]" placeholder="ស្ថាប័ន"></td>
                      <td><a href="javascript:void(0)" onclick="AddOrg(this)"><i class="glyphicon glyphicon-plus"></i> {{trans('mission.add')}}</a></td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </td>
          </tr>
        @endforeach
      @else
      <tr id="mission_tr_0" class="mission_tr yes">
        <td class="text-center"><label class="no_order">1</label></td>
        <td colspan="2">
          <table class="table table-bordered">
            <tr>
              <td colspan="2">
                <div id="dev_mef_mission_location_0" name="province[]"></div>
              </td>
              <td></td>
            </tr>
            <tbody class="org_body">
              <tr>
                <td></td>
                <td><input type="text" class="form-control" name="organization[mission_tr_0][]" placeholder="ស្ថាប័ន"></td>
                <td><a href="javascript:void(0)" onclick="AddOrg(this)"><i class="glyphicon glyphicon-plus"></i> {{trans('mission.add')}}</a></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      
      @endif
    
   </tbody>
</table>

<style>
  .table-bordered>tbody>tr>td{
    vertical-align: middle;
  }
</style>
<script type="text/javascript">
function randomOrder(){
  $('no_order').each()
}
function romoveProvinces(e){
  $($(e).parents('.mission_tr')).remove();
}
function romoveOrg(e){
  $($(e).parents('.tr_org')).remove();
}
function AddOrg(e) {  
  console.log($(e).parents('.mission_tr').attr('id'));
  var $name_org = $(e).parents('.mission_tr').attr('id');
  var $tr_org = '<tr class="tr_org">'+
                '<td></td>'+
                '<td><input type="text" class="form-control" name="organization['+$name_org+'][]" placeholder="ស្ថាប័ន"></td>'+
                '<td><a href="javascript:void(0)" onclick="romoveOrg(this)"><i class="glyphicon glyphicon-plus"></i> {{trans('general.delete')}}</a></td>'+
              '</tr>';
  $($(e).parents('.org_body')).append($tr_org);
}
$(function(){
  
  
  var $key =$('#mission_body').children().length;
  /* Create Province */
  $('#btnAddProvince').click(function() {
    // console.log($('#mission_body').children());
    var $no_order = $('#mission_body').children().length +1;
    $key = $key+1;
    var $str= '';
    $str = '<tr id="mission_tr_'+$key+'" class="mission_tr">'+
      '<td class="text-center"><label class="no_order">'+$no_order+'</label></td>'+
      '<td colspan="2">'+
        '<table class="table table-bordered">'+
          '<tr>'+
            '<td colspan="2"><div id="dev_mef_mission_location_'+$key+'" name="province[]"></div></td>'+
            '<td><a href="javascript:void(0)" onclick="romoveProvinces(this)"><i class="glyphicon glyphicon-trash"></i> {{trans("general.delete").trans("general.location")}}</a></td>'+
          '</tr>'+
          '<tbody class="org_body"><tr>'+
            '<td></td>'+
            '<td><input type="text" class="form-control" name="organization[mission_tr_'+$key+'][]" placeholder="ស្ថាប័ន"></td>'+
            '<td><a href="javascript:void(0)" onclick="AddOrg(this)"><i class="glyphicon glyphicon-plus"></i> {{trans('mission.add')}}</a></td>'+
          '</tr></tbody>'+
        '</table>'+
      '</td>'+
    '</tr>';
    $('#mission_body').append($str);

    // dev_mef_mission_type_id
    initDropDownList(jqxTheme, 500,30, '#dev_mef_mission_location_'+$key, <?php echo $list_mission_location;?>, 'text', 'value', false, '', '0', "#mef_mission_location","{{$constant['buttonSearch']}}",250);
    $('.no_order').each(function(key,index){
      $(index).text(key+1);
    });
  });

  /* inin dropdwonlist*/
  $('.mission_tr').each(function(key,index){
    initDropDownList(jqxTheme, 500,30, '#dev_mef_mission_location_'+key, <?php echo $list_mission_location;?>, 'text', 'value', false, '1', '1', "#mef_mission_location_"+key,"{{$constant['buttonSearch']}}",250);
  });

});
</script>