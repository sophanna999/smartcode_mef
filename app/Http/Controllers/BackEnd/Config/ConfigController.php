<?php 
namespace App\Http\Controllers\BackEnd\Config;
use App\Http\Controllers\BackendController;
use ClassPreloader\Config;
use Illuminate\Http\Request;
use App\Models\BackEnd\Config\ConfigModel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
class ConfigController extends BackendController {

    public function __construct(){
        parent::__construct();
        $this->config = new ConfigModel();
    }
    public function getIndex(){
        $this->data['row'] = $this->config->getDataByRowId();
        return view($this->viewFolder.'.config.index')->with($this->data);
    }
    public function postSave(Request $request){
        return $this->config->postSave($request->all());
    }
}
