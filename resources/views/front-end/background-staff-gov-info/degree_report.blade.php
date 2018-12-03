<style>
    th
    {
        text-align: center;
        font-weight: bolder;
    }
</style>
<div class="container-fluid content-popup-new">
    <center class="col-md-12 col-sm-12 col-lg-12 text-center;" style="margin-bottom: 10px; font-family: 'KHMERMEF2'; font-size: 20px">
        របាយការណ៍ស្តីពីកម្រិតសញ្ញាបត្រ<br>
        នៃអង្គភាពនាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន
    </center>
    <table class="table table-bordered table-responsive">
       <thead class="bg-info">
           <tr>
               <th>ល.រ</th>
               <th>មុខដំណែង</th>
               <th>បរិញ្ញាបត្រ</th>
               <th>អនុបណ្ឌិត</th>
               <th>បណ្ឌិត</th>
               {{--<th>សរុប</th>--}}
           </tr>
       </thead>
        <tbody>
            <?php $i=1 ?>
            @foreach($report_data as $item)
                <tr>
                    <td style="text-align: center">{{$i++}}</td>
                    <td>{{$item->position}}</td>
                    <td style="text-align: center">{{$item->bachelor}}</td>
                    <td style="text-align: center">{{$item->master}}</td>
                    <td style="text-align: center">{{$item->doctor}}</td>
                    {{--<td style="text-align: center">{{$item->bachelor + $item->master + $item->doctor}}</td>--}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>

</script>