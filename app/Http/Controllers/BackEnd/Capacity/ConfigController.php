<?php

namespace App\Http\Controllers\BackEnd\Capacity;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\BackendController;

class ConfigController extends BackEndController
{
    public function index()
    {
        
        return view('back-end.capacity.config.index')->with($this->data);
    }
}
