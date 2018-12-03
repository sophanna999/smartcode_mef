<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notifications = DB::select(DB::raw('SELECT 
                                        fn.Id as id,
                                        mm.image AS image_module, 
                                        vgu.avatar AS image_from, 
                                        Concat(fn.title, "", 
                                        Concat(Ifnull(vgu1.title, ""), ".", vgu1.full_name_kh)) AS 
                                        from_user_name, 
                                        fn.comment, 
                                        is_read, 
                                        module_type, 
                                        Ifnull(push_activity_id, "") 
                                        AS push_activity_id, 
                                        fn.transaction_type 
                                        -- ,get_datetime_ago(DATE_FORMAT(fn.created_date,"%Y-%m-%d %h:%i:%s")) as create_date 
                                        , 
                                        ( CASE 
                                            WHEN Timestampdiff(minute, fn.created_date, Now()) <= 0 THEN Concat( 
                                            "1 minute ago") 
                                            WHEN Timestampdiff(minute, fn.created_date, Now()) < 60 THEN Concat( 
                                                Timestampdiff(minute, fn.created_date, Now()), "", "minute ago") 
                                            WHEN Timestampdiff(hour, fn.created_date, Now()) < 24 THEN 
                                                Concat(Round(Timestampdiff(minute, fn.created_date, Now()) / 60), "", "hour ago") 
                                            WHEN Timestampdiff(day, fn.created_date, Now()) < 6 THEN 
                                                Concat(Round(Timestampdiff(hour, fn.created_date, Now()) / 24), "", "day ago") 
                                            ELSE 
                                                Date_format(fn.created_date, "%y-%m-%d %h:%i:%s") 
                                            end )                                                                         
                                            AS 
                                                    create_date 
                                            FROM   mef_notification fn 
                                                INNER JOIN v_get_unit vgu 
                                                        ON fn.from_user_id = vgu.mef_officer_id 
                                                INNER JOIN v_get_unit vgu1 
                                                        ON fn.to_user_id = vgu1.mef_officer_id 
                                                INNER JOIN mef_module mm 
                                                        ON fn.module_type = mm.id 
                                            where
                                                fn.to_user_id in ('.session('sessionGuestUser')->Id.')
                                                and fn.mef_role_id in (
                                                 select
                                                     moef_role_id as role_id
                                                 from
                                                     mef_user
                                                 where
                                                     mef_officer_id in ('.session('sessionGuestUser')->Id.'))
                                            and DATE_SUB(date_format(now(), "%Y-%m-%d"),
                                                 interval 21 day) <= date_format(fn.created_date, "%Y-%m-%d")
                                                 and module_type in (2)
                                            order by
                                                 fn.created_date desc 
                                            limit 10 offset '.(($request->page * 10) - 10).'
                                            '));
        return collect($notifications)->toJson();
    }

    public function update(Request $request,$id)
    {
        $notification = DB::table('mef_notification')->where('Id',$id)->update(['is_read' => 1]);
        return response()->json($notification);
    }

}
