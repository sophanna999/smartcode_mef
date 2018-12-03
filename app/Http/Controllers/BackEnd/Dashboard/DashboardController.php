<?php 
namespace App\Http\Controllers\BackEnd\Dashboard;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;

class DashboardController extends BackendController {

    public function __construct(){
        parent::__construct();
    }

    public function getIndex(){
        return view($this->viewFolder.'.dashboard.index')->with($this->data);
    }
}
