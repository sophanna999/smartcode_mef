<?php 

namespace App\Http\Controllers\BackEnd\Document;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\BackEnd\Document\Setting;
use App\Repositories\Document\SettingRepository;
use App\Repositories\Document\TrackingRepository;

class TrackingController extends BackendController {
    protected $setting;    
    public function __construct(SettingRepository $setting,TrackingRepository $tracking){
        parent::__construct();
        $this->userSession = session('sessionUser');
        $this->setting = $setting;
        $this->repository = $tracking;
    }

    public function getIndex(){ 
        #return  $this->repository->source();
        $tr = $this->repository->listAll();
      
       # return response()->json($tr);
        return view($this->viewFolder.'.document.tracking.index')->with($this->data);
    }
    public function lists(){     
        return  $this->repository->listAll();
        
    }
    public function postNew(Request $request){
        $source =  $this->setting->Source()->pluck('value_kh','id')->toJson();
        $flow =  $this->setting->flow()->pluck('value_kh','id')->toJson();
        $category =  $this->setting->category()->pluck('value_kh','id')->toJson();
        $privacy =  $this->setting->privacy()->pluck('value_kh','id')->toJson();        
        return view($this->viewFolder.'.document.tracking.new',compact('source','flow','category','privacy'))->with($this->data);
    }
    public function store(Request $request)
    {     
        $this->repository->create($request->all());
        return response()->json(['message' => trans('general.success_insert',['attribute' => trans('document.document')])]);
    }
    public function getSetting(){
        $setting =  $this->setting->all();
       
        $aa = array();
        return view($this->viewFolder.'.document.tracking.setting',compact('setting','aa'))->with($this->data);
    }
    public function postSetting(Request $requst){
        return $this->setting->all();
    }



}
