<?php 

function secret_route () {
    return url(config('constant.secretRoute'));
}

function generateSelect($data){
    $options = array();
    foreach($data as $key => $value)
        $options[] = ['text' => $value, 'value' => $key];

    return json_encode($options);
}

function generateSingleSelect($data,$key){
    $options = array();
    foreach($data as $value)
        $options[] = [$key => $value];

    return json_encode($options);
}

function showDate($date)
{
    if (!$date) {
        return;
    }

    $date_format = 'd/m/Y';
    return date($date_format, strtotime($date));
}

function showDateTime($date)
{
    if (!$date) {
        return;
    }

    $date_format = 'd/m/Y h:i A';
    return date($date_format, strtotime($date));
}

function prettyStatus($status){
    if($status == 0){
        return '<label class="label label-default">'.trans('general.inactive').'</label>';
    }elseif($status == 1){
        return '<label class="label label-success">'.trans('general.active').'</label>';
    }else{
        return '';
    }
}

function getAvatar($id, $size = 40){
    $user = \App\Models\BackEnd\Capacity\Member::find($id);
    $profile = $user->Profile;
    $name = $user->full_name;
    $tooltip = $name;
    if(isset($profile->avatar))
        return '<img src="/'.config('constant.upload_path.avatar').$profile->avatar.'" class="img-circle" style="width:'.$size.'px";" alt="User avatar" data-toggle="tooltip" title="'.$tooltip.'">';
    else 
        return '<p class="textAvatar" data-toggle="tooltip" title="'.$tooltip.'" data-image-size="'.$size.'">'.$user->latin_name.'</p>';
}

function getVar($name)
{
    $extentions = config('system.'.$name);

    return $extentions;
}

function isAdmin($id = null){
    if(!$id){
        $id = session('sessionUser')->id;
    }

    $user = App\Models\BackEnd\User\User::find($id);
   
    return $user->user_name == 'administrator';
}

function getUserMemberId($id = null)
{
    if(!$id){
        $id = session('sessionUser')->id;
    }

    $user = App\Models\BackEnd\User\User::find($id);

    if (! $user) {
        throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('user.user')]]);
    }

    if($user->mef_member_id){
        return collect(explode(',',$user->mef_member_id));
    }

    return collect([]);
}

function filterByUserId($query,$scope_name = null){
    if(!isAdmin(session('sessionUser')->id)){
        $users =  getUserMemberId();

        if($users){
            $users->push(session('sessionUser')->id);
        }else{
            $users = collect([session('sessionUser')->id]);
        }

        if($scope_name){
            return $query->{$scope_name}($user);
        }

        return $query->filterByUsers($users);
    }

    return false;
}