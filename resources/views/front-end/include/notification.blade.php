<div class="blg-right">
    <div class="wrap-blg-right">
        <p class="info-announce">ការជូនដំណឹង</p>
        <div id="notification_content" class="row" style="overflow-y: scroll; height: 92vh; margin-top: 15px; padding-right: 20px;padding-left:20px"></div>
    </div>
    <img src="images/notification.png" class="clickRight" id="bell" style="cursor:pointer">
</div>

<script>
    $(document).ready(function(){
        var page = 0;
        $('#bell').click(function(){
            fetch(++page);
        });

         $('#notification_content').bind('scroll',function(e){
            var elem = $(e.currentTarget);
            if (elem[0].scrollHeight - elem.height() == elem.scrollTop())
            {
                page = page + 1;
                fetch(page);
            }
        });

        function fetch(page){
            $.ajax({
                type: 'post',
                dataType: "json",
                url: '{{url('/notification')}}',
                cache: false,
                data: {_token:'{{ csrf_token() }}',page:page},
                success: function (response, status, xhr) {
                    var html = '';
                    if(response.length){
                        for(key in response){
                            var notification = response[key];

                            switch (notification.module_type) {
                            case 2:
                                html += '<a data-id="'+notification.id+'" class="item" href="#/schedule?d='+ notification.push_activity_id +'">';
                                break;
                            
                            default:
                                html += '<a href="#" data-id="'+notification.id+'" class="item">';
                                break;
                            }
                        
                            html += '<div class="alert announcement notification_element'+ (notification.is_read? ' read' : '') +'" role="alert"">';
                                html += '';
                                    html += '<div class="row">';
                                        html += '<div class="col-md-3" style="width:20%">';
                                            html += '<div class="personal-status">';
                                                html += '<img src="{{asset('')}}'+ notification.image_from +'" style="width: 100%" alt="" class="img-responsive">';
                                            html += '</div>';
                                        html += '</div>';
                                        html += '<div class="col-md-9" style="width:80%">';
                                            html += '<h5 style="color:#fff">' + notification.from_user_name +'</h5>';
                                            html += '<p style="color:#fff;opacity:0.7;">'+ notification.comment +'</p>';
                                        html += '</div>';
                                    html += '</div>';
                                    html += '<div class="col-md-offset-3">';
                                        html += '<span style="color:#C2DFD9; font-size: 13px;"><img class="notification-module" src="{{asset("images/notification/schedule.png")}}">'+ notification.create_date +'</span>';
                                    html += '</div>';
                               
                            html += '</div></a>';
                        }
                    }else {
                        if(page == 1){
                            html += '<div class="alert alert-info alert-info-notify" id="no_item">ពុំមានដំណឹង</div>';
                        }else{
                            if($('#notification_content').find('#no_item').length <= 0){
                                if($('#notification_content').find('#out_of_item').length){
                                    $('#out_of_item').addClass('text-danger');
                                }else{
                                    html += '<div class="alert alert-info alert-info-notify" id="out_of_item">អស់ដំណឹងហើយ!</div>';
                                }
                            }
                        }
                    }
                    $('#notification_content').append(html);
                    updateNotification();
                },
                error: function (request, textStatus, errorThrown) {
                }
            });
        }
        $('#notification_content').slimscroll({
            distance : '1.5%',
            alwaysVisible: true
        });
    });

   
    function updateNotification(id){
      $('.item').click(function(){
        var id = $(this).attr('data-id');
        var item = $(this);
        $.ajax({
            type: 'post',
            dataType: "json",
            url: '{{url('/notification')}}/' + id ,
            cache: false,
            data: {_token:'{{ csrf_token() }}'},
            success: function (response, status, xhr) {
                item.find('.notification_element').addClass('read');
            },
            error: function (request, textStatus, errorThrown) {
                notification('{{ trans('general.something_went_wrong') }}','warning');
            }
        });
      });
    }

</script>




