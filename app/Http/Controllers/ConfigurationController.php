<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\AuthModel;
use Session;

class ConfigurationController extends Controller
{
    protected $auth;

    public function __construct(AuthModel $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function switchs()
    {
        if(session('sessionGuestUser')){
            $guest_session = session('sessionGuestUser');
            
            $login = $this->auth->postLogin(['user_name' => $guest_session->user_name],true);
            
            Session::forget('sessionGuestUser');

            if($login){
                return redirect(secret_route().'/dashboard');
            }else{
                return redirect('/login');
            }
        }

        if(session('sessionUser')){
            $user_session = session('sessionUser');

            if(! $user_session->user_name)
            {
                return redirect()->back()->withErrors(trans('general.action_not_allowed'));
            }

            $login = $this->auth->postGuestLogin(['user_name' => ($user_session->user_name ? :'administrator') ],true);

            Session::forget('sessionUser');

            if($login){
                return redirect('/');
            }else{
                return redirect('/auth/logout');
            }
        }
        
        return redirect()->back()->withErrors(trans('general.something_went_wrong'));
    }

}
