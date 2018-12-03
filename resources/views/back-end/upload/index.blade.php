
<div class="file-uploader" 
    data-user-type="{{ $user_type }}"
    data-user-id="{{ $user_id }}"
    data-module="{{$module}}" 
    data-key="" 
    data-module-id="{{ isset($module_id) ? $module_id : '' }}">

    <div class="file-uploader-button" data-upload-button="{{isset($upload_button) ? $upload_button : trans('messages.upload')}}" data-max-size="{{config('system.file.max_file_size_upload')*1024*1024}}"></div>
    <span style="margin-top: 5px;" class="file-uploader-list"></span>
    @if(isset($uploads))
        <div style="margin-top: 10px;">
        @foreach($uploads as $upload)
            <p><a href="#" data-ajax="1" data-extra="&id={{$upload->id}}" data-source="/upload-temp-delete" class="click-alert-message mark-hidden"><i class="fa fa-times" style="color: red;margin-right: 10px;"></i></a> {{$upload->user_filename}}</p>
        @endforeach
        </div>
    @endif
</div>

<script>
    $(document).ready(function()
    {
        function n(t) {
            for (var e = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", a = "", n = t; n > 0; --n) a += e[Math.floor(Math.random() * e.length)];
            return a
        }
        
        $('.file-uploader').each(function() {

            var t = n(40);
            $(this).attr("id", t);
            var e = "?module=" + $(this).attr("data-module") + "&key=" + t;
            $(this).attr("data-key", t);
            var a = t + "-list";
            $(this).find(".file-uploader-list").attr("id", a), $("#" + a).attr("data-source", "/upload-list"), $("#" + a).attr("data-extra", e), $("#" + a).html("");
            var r = $(this).attr("data-module"),
                user_type = $(this).attr("data-user-type"),
                user_id = $(this).attr("data-user-id"),
                i = $(this).attr("data-module-id"),
                s = $(this).attr("data-key"),
                o = $(this).find(".file-uploader-button");
            $(o).uploadFile({
                url: "{{ secret_route() }}/upload",
                fileName: "file",
                returnType: "json",
                uploadStr: o.attr("data-upload-button"),
                maxFileSize: o.attr("data-max-size"),
                allowedTypes:"{{ implode(config('system.file.allowed_upload_file'),',') }}",
                autoSubmit: !0,
                dragDrop: !1,
                multiple: !1,
                formData: {
                    user_id: user_id,
                    user_type: user_type,
                    module: r,
                    module_id: i,
                    key: s,
                    _token: '{{ csrf_token() }}'
                },
                onSuccess: function(t, e) {
                    var uploaded_list = $("#" + a);
                    ajaxGetRequest(uploaded_list.attr("data-source") + uploaded_list.attr("data-extra")+'&user_id='+user_id+'&user_type='+user_type ,function(e){
                        uploaded_list.html(e);
                    });
                },
                onError: function(t, e, a) {
                
                }
            });
        });
    });

    $(document.body).on('click','a',function(event){
        if($(this).attr('data-ajax')){
            event.preventDefault();
            ajaxGet(this);
        }
    });

    function ajaxGet(obj){
        var postData = $(obj).attr('data-extra');
            postData += '&_token='+CSRF_TOKEN;  

        $.ajax({
            url: base_url + $(obj).attr('data-source'),
            data: postData,
            dataType: 'json',
            cache: false,
            type: 'post',
            error: function(response) {
                notification(JSON.parse(response.responseText),'warning');
            },
            success: function(response) {
                var uploaded_list = $("#" + $(obj).attr('data-refresh'));
                ajaxGetRequest(uploaded_list.attr('data-source')+uploaded_list.attr('data-extra'),function(e){
                    uploaded_list.html(e);
                });
            },
        });
    }

    
</script>