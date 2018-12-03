<div id="custom-modal"​​>
  <div id="overlay"> 
		
		<button type="button" class="close" ng-click="close()" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" style="padding-bottom: 10px;"></h4>
		<table class="tblModule tblSchedule tblAttend">

            <thead>
                <tr>
                    <th>ល រ</th>         
                    <th>អនុញ្ញាតដោយ</th>
                    <th>ថ្ងៃអនុញ្ញាត</th>
                    <th><label> អនុញ្ញាត </label></th>
                </tr>
            </thead>	
            <tbody>
                <tr ng-repeat="user in approveList">        	
                    <td>@{{ $index + 1}}</td>
                    <td>@{{user.FULL_NAME_KH}}</td>
                    <td>@{{user.kh_date}}</td>	                    
                    <td  ng-if="user.status==0"><label class="col-red"></label></td>
                    <td  ng-if="user.status==2"><label class="col-red"> មិនអនុញ្ញាត</label></td>
                    <td  ng-if="user.status==1"><label> អនុញ្ញាត </label></td>

                </tr>
            </tbody>

        </table>
		
  </div>
  <div id="fade"></div>
</div>
<script type="text/javascript">
    
</script>
<style type="text/css">
	.jqx-calendar-cell-weekend
    {
        color: #5583c8;
    }
</style>

