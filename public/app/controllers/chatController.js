
app.controller("chatController", function ($scope,$interval,$filter,$http,$rootScope) {

    $scope.getSituationPublicInfoByUserId = function (callback) {
        loadingWaiting();
        var editId = $('#indexEdit').val();
        var dataDefault	=	[{}];
        $scope.Guest	=  dataDefault;
        $http({
            method: 'post',
            url: baseUrl + 'chat',
            dataType: "json",
            data: {'editId': editId, "_token": _token}
        }).success(function (response) {
            callback(response);
        });
    }

    $scope.getSituationPublicInfoByUserId(function (response) {
        var data = response.main;
        console.log(response);
        $scope.framework = response.framework;
        $scope.frameworkFree = response.frameworkFree;


        var Office = response.office;
        var location = response.location;
        var leader = response.leader;
        var meetingType = response.meetingType;

        initDropDownList(jqxTheme, '100%', 30, '#div_mef_office_id', Office, 'text', 'value', false, '', '0', "#mef_office_id", "ស្វែងរក", 250);
        $("#div_mef_office_id").bind('select',function(event){
            mefMeetingAtendeeJoin($(this).val(),true);
        });

        initDropDownList(jqxTheme, '100%', 30, '#div_meeting_location', location, 'text', 'value', false, '', '0', "#meeting_location", "ស្វែងរក", 250);
        $("#div_meeting_location").bind('select',function(event){
            var meetingDate = $("#div_meeting_date").val();
            var meetingTime = $("#div_meeting_time").val();
            mefCheckLocation($(this).val(),meetingDate,meetingTime);
        });

        initDropDownList(jqxTheme, '100%', 30, '#div_mef_meeting_leader_id', leader, 'text', 'value', false, '', '0', "#mef_meeting_leader_id", "ស្វែងរក", 250);

        initDropDownList(jqxTheme, '100%', 30, '#div_mef_meeting_type_id', meetingType, 'text', 'value', false, '', '0', "#mef_meeting_type_id", "ស្វែងរក", 250);

        endLoadingWaiting();
    });

    mefMeetingAtendeeJoin($("#mef_office_id").val(),false);

    function mefMeetingAtendeeJoin(officeId,status_clear_select){
        var source = {
            type: 'post',
            datatype: 'json',
            url: baseUrl + 'schedule/officer-for-join',
            data: {'officeId': officeId, "_token": _token}
        };
        var dataAdapter = new $.jqx.dataAdapter(source,{
            beforeLoadComplete: function (records) {
                // if(status_clear_select == false){
                // 	getSelectedItems();
                // }
            }
        });

        $("#div_mef_meeting_atendee_join").jqxComboBox({
            source: dataAdapter,
            multiSelect: true,
            theme: jqxTheme,
            width: '100%',
            // width: 803,
            height: 35,
            displayMember: "displayMember",
            valueMember : "valueMember",
            placeHolder: " ស្វែងរក",
            enableBrowserBoundsDetection:true,
            autoComplete:true,
            searchMode:'contains',
            dropDownHeight:450,
            animationType: 'none'
        });
        /* jqxComboBox on focus action */
        $('#div_mef_meeting_atendee_join input').on('focus', function (event) {
            $("#div_mef_meeting_atendee_join").jqxComboBox('open');
        });
    }

    function mefCheckLocation(locationId,meetingDate,meetingTime){

        // alert(locationId);
        $.ajax({
            type: "POST",
            url: baseUrl + 'chat',
            data:{'officeId': locationId, 'meetingDate': meetingDate,'meetingTime': meetingTime,"_token": _token},
            success: function (response) {
                var obj = JSON.parse(response);
                console.log(obj);

                console.log(obj.code);
                if(obj.code == 1){
                    // alert(1);
                    $("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});

                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({position: positionNotify,template: "error" });
                    $('#jqx-notification').html(obj.message);
                    $("#jqx-notification").jqxNotification("open");

                    $("#jqx-save").attr("disabled",true);
                }else {
                    $("#jqx-save").attr("disabled",false);
                }
            },
        })

    }



    function getSelectedItems(){
        var str_join = '{{}}';
        // console.log(str_join);
        if(str_join != ''){
            var res_join = str_join.split(',');
            setTimeout(function(){
                $.each(res_join, function( index, value ) {
                    $("#div_mef_meeting_atendee_join").jqxComboBox('selectItem', value);
                });
            }, 100);
        }
    }

    var meetingDate = $('#meeting_date').val() != null ? $('#meeting_date').val() : null;
    getJqxCalendar('div_meeting_date', 'meeting_date', 200, 30, 'កាលបរិច្ឆេទ', meetingDate);
    $("#div_meeting_date").on('change',function(event){
        var meetingTime = $("#div_meeting_time").val();
        var locationId = $("#div_meeting_location").val();
        mefCheckLocation(locationId,$(this).val(),meetingTime);
    });

    setTimeout(function () {
        // var meetingDate = $('#meeting_date').val() != null ? $('#meeting_date').val():null;
        $('#div_meeting_time').jqxDateTimeInput({
            width: 86,
            height: 30,
            formatString: 't',
            animationType: 'fade',
            showTimeButton: true,
            showCalendarButton: false
        });
        $("#div_meeting_time").on('change',function(event){
            var meetingDate = $("#div_meeting_date").val();
            var locationId = $("#div_meeting_location").val();
            mefCheckLocation(locationId,meetingDate,$(this).val());
        });


        $('#div_mef_meeting_atendee_join input').on('focus', function (event) {
            $("#div_mef_meeting_atendee_join").jqxComboBox('open');
        });

        var isActive = $('#is_invite_guest').val() == 1 ? true : false;

        $("#is_invite_guest_checkbox").jqxCheckBox({theme: jqxTheme, width: 120, height: 25, checked: isActive});
        $('#is_invite_guest_checkbox').on('change', function (event) {
            event.args.checked == true ? $('#is_invite_guest').val(1) : $('#is_invite_guest').val(0);
            if (event.args.checked == true) {
                $("#warp_outside_participant").css("background", "#fff");
                $('#btn_more_outside').prop("disabled", false);
                // $("#guest_description").prop('disabled', false);
                var sub_more = '<div class="sub_more guest">' +
                    '<div class="col-md-5"><input type="text" class="form-control guest_name" placeholder="ឈ្មោះ"  id="guest_name_0" ng-model="guest_name"></div>' +
                    '<div class="col-md-5"><input type="email" class="form-control guest_email" placeholder="អ៊ីម៉ែល" id="guest_email_0" ng-model="guest_email[]"></div>' +
                    '</div>';
                $("#warp_outside_participant_content").append(sub_more);
            } else {
                $("#warp_outside_participant").css("background", "#eee");
                $('#btn_more_outside').prop("disabled", true);
                // $("#guest_description").prop('disabled', true);
                $("#warp_outside_participant_content").html("");
            }
        });

        if (isActive == true) {
            $("#warp_outside_participant").css("background", "#fff");
            $('#btn_more_outside').prop("disabled", false);
        } else {
            $("#warp_outside_participant").css("background", "#eee");
            $('#btn_more_outside').prop("disabled", true);
        }

        $scope.saveMeeting = function(url){
            var count = 0;
            if($("#meeting_date").val() == ''){
                $("#div_meeting_date").addClass("jqx-validator-error-element");
                count = count + 1;
            }else{
                $("#div_meeting_date").removeClass("jqx-validator-error-element");
            }

            if($('input[name=mef_meeting_atendee_join]').val() == ""){
                $("#div_mef_meeting_atendee_join").addClass("jqx-validator-error-element");
                count = count + 1;
            }else{
                $("#div_mef_meeting_atendee_join").removeClass("jqx-validator-error-element");
            }

            if($("#div_meeting_location").val() == ""){
                $("#div_meeting_location").addClass("jqx-validator-error-element");
                count = count + 1;
            }else{
                $("#div_meeting_location").removeClass("jqx-validator-error-element");
            }

            if($("#meeting_objective").val() == ""){
                $("#meeting_objective").addClass("jqx-validator-error-element");
                count = count + 1;
            }else{
                $("#meeting_objective").removeClass("jqx-validator-error-element");
            }

            if($("#div_mef_meeting_leader_id").val() == ""){
                $("#div_mef_meeting_leader_id").addClass("jqx-validator-error-element");
                count = count + 1;
            }else{
                $("#div_mef_meeting_leader_id").removeClass("jqx-validator-error-element");
            }

            if($("#div_mef_meeting_type_id").val() == ""){
                $("#div_mef_meeting_type_id").addClass("jqx-validator-error-element");
                count = count + 1;
            }else{
                $("#div_mef_meeting_type_id").removeClass("jqx-validator-error-element");
            }

            if(count > 0){
                $scope.notificationValidation();
                return;
            }
            var meetingDate = {
                'meeting_date': $("#meeting_date").val(),
                'meeting_time' : $("#div_meeting_time").val(),
                'meeting_location_id' : $("#div_meeting_location").val(),
                'meeting_objective' : $("#meeting_objective").val(),
                'mef_meeting_leader_id' : $("#div_mef_meeting_leader_id").val(),
                'mef_meeting_type_id' : $("#div_mef_meeting_type_id").val(),
                'is_invite_guest' : $("#is_invite_guest").val()
            };

            var mef_meeting_atendee_join = $('input[name=mef_meeting_atendee_join]').val();
            var arrMeetingAtendenJoin = mef_meeting_atendee_join.split(",");
            var guestName=[];
            var guestEmail=[];
            $( ".guest" ).each(function( index ) {
                guestName.push($("#guest_name_" + index).val());
                guestEmail.push($("#guest_email_" + index).val());
            });


            var data = meetingDate;

            $http({
                method: 'post',
                url: baseUrl+'chat',
                dataType: "json",
                data:{"data":data,"arrMeetingAtendenJoin":arrMeetingAtendenJoin,"guestName":guestName,"guestEmail":guestEmail}
            }).success(function(response) {
                $("#div_meeting_date").jqxDateTimeInput({ value: null });
                $("#div_mef_office_id").jqxDropDownList('clearSelection', true);
                $("#div_mef_office_id").jqxDropDownList({placeHolder: ''});

                $("#div_meeting_location").jqxDropDownList('clearSelection', true);
                $("#div_meeting_location").jqxDropDownList({placeHolder: ''});

                $("#div_mef_meeting_atendee_join").jqxComboBox('clearSelection', true);
                $("#meeting_objective").val('')

                $("#div_mef_meeting_leader_id").jqxDropDownList('clearSelection', true);
                $("#div_mef_meeting_leader_id").jqxDropDownList({placeHolder: ''});

                $("#div_mef_meeting_type_id").jqxDropDownList('clearSelection', true);
                $("#div_mef_meeting_type_id").jqxDropDownList({placeHolder: ''});

                $("#is_invite_guest_checkbox").jqxCheckBox({checked: false});

                $("#jqx-notification").jqxNotification({animationCloseDelay:2000,autoCloseDelay:8000});
                if(response.code == 2){

                    $("#jqx-notification").jqxNotification();
                    $('#jqx-notification').jqxNotification({position: positionNotify,template: "success" });
                    $('#jqx-notification').html(response.message);
                    $("#jqx-notification").jqxNotification("open");
                }
            });
        };

        $interval(function () {
            $rootScope.angularDate = $filter('date')(new Date(), 'yyyy-MM-dd');
            $rootScope.angularHrs = $filter('date')(new Date(), 'HH:mm');
        }, 2000);
        $interval(function () {
            //300000 milliseconds = 300 seconds = 5 minutes
            //60000 milliseconds = 60 seconds = 1 minute
            window.location.reload();
        }, 60 * 60000);
    });
});