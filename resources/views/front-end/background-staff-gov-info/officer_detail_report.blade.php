<style>
    th
    {
        text-align: center;
        font-weight: bolder;
    }
</style>
<div class="container-fluid content-popup-new">
    <center class="col-md-12 col-sm-12 col-lg-12 text-center;" style="margin-bottom: 10px; font-family: 'KHMERMEF2'; font-size: 20px">
        របាយការណ៍មន្រ្តីរាជការលម្អិត<br>
        នៃអង្គភាពនាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន
    </center>
    <table class="table table-bordered table-responsive table-hover">
       <thead class="bg-info">
           <tr>
               <th>ល.រ</th>
               <th>គោត្តនាម-នាម</th>
               <th>មុខតំណែង</th>
               <th>ថ្ងៃកំណើត</th>
               <th>ថ្ងៃចូល​</th>
               <th>បណ្ឌិត</th>
               <th>អនុបណ្ឌិត</th>
               <th>បរិញ្ញាបត្រ</th>


           </tr>
       </thead>

        <tbody>


            <?php $i=1 ?>
            @foreach($report_data as $item)
                <tr>
                    <td style="text-align: center">{{$i++}}</td>
                    <td>{{$item->FULL_NAME_KH}}</td>
                    <td>{{$item->mef_position_name}}</td>
                    <td style="text-align: center">{{$item->dob}}</td>
                    <td style="text-align: center">{{$item->start_work}}</td>
                    <td style="text-align: center">{{$item->doctor}}</td>
                    <td style="text-align: center">{{$item->master}}</td>
                    <td style="text-align: center">{{$item->bachelor}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>

</script>