<?php

namespace App\Http\Controllers\FrontEnd\Chat;
use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Session;
use App\libraries\Tool;

class ChatController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->tool = new Tool();
        if ($this->userGuestSession != null) {
            $this->officer_id = intval($this->userGuestSession->Id);
        }
    }

    public function getIndex()
    {
        return view($this->viewFolder . '.chat.index')->with($this->data);
    }
}