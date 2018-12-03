<?php

namespace App\Http\Controllers\BackEnd\OutsideStaff;
use App\Http\Controllers\BackendController;
use App\Models\BackEnd\OutSideStaff\OutsideStaff;
use Illuminate\Http\Request;
use App\Models\BackEnd\Profile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Requests\StoreOutsideStaff;
use Illuminate\Support\Facades\Config;

class OutsideStaffController extends BackEndController
{
    protected $module = 'back-end.outside-staff';

    protected $request;
    protected $repository;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->messages = Config::get('constant');
        $this->request = $request;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd('123');

        return view($this->module.'.index')->with($this->data);
    }

    public function lists()
    {
        $outsideStaffs = $this->paginate($this->request->all());

        return $outsideStaffs;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->module.'.new',compact('subjects','officers'))->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOutsideStaff $request)
    {
//        dd($request->all());
        if($request->Id){
            $this->update($request);
            return response()->json(['message' => trans('member.insert_success')]);
        }else{
            $this->add($request->all());
            return response()->json(['message' => trans('member.insert_success')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $this->data['row'] = OutsideStaff::find($request->Id);
        return view($this->module.'.new')->with($this->data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $listId = isset($request['Id']) ? $request['Id'] : '';
         $this->deleteMultiple($listId);
        return array("code" => 1, "message" => $this->messages['success']);
    }

    protected function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = OutsideStaff::with('profile');

        for($i = 0; $i < $filters_count; $i++)
        {
            $field_name  = isset($params['filterdatafield'.$i]) ? $params['filterdatafield'.$i] : '';
            $field_value = isset($params['filtervalue'.$i]) ? strval($params['filtervalue'.$i]) : '';
            switch($field_name){
                case 'full_name':
                    $query->filterByFirstName($field_value);
                    break;
                case 'latin_name':
                    $query->filterByKhmerName($field_value);
                    break;
                case 'phone_number':
                    $query->filterByPhoneNumber($field_value);
                    break;
                case 'email':
                    $query->filterByEmail($field_value);
                    break;
                default:
                    #Code...
                    break;
            }
        }

        if ($sort_by === 'full_name') {
            $query->select('mef_outside_staffs.*', \DB::raw('(select full_name from mef_profiles where mef_outside_staffs.id = mef_profiles.profileable_id and mef_profiles.profileable_type = "App\Models\BackEnd\Ability\Member") as full_name'))->orderBy('full_name', $order);
        } elseif ($sort_by === 'latin_name') {
            $query->select('mef_outside_staffs.*', \DB::raw('(select latin_name from mef_profiles where mef_outside_staffs.id = mef_profiles.profileable_id and mef_profiles.profileable_type = "App\Models\BackEnd\Ability\Member") as latin_name'))->orderBy('latin_name', $order);
        } else {
            $query->orderBy($sort_by, $order);
        }

        return $query->paginate($page_length);
    }

    protected function add($params)
    {
        $avatar = request()->file('avatar_file');
        if ($avatar!=null) $avatar_path = $this->uploadAndResize($avatar);
            $params['avatar'] = $avatar_path;
        $params['date_of_birth'] = date('Y-m-d', strtotime($params['date_of_birth']));
        $outsideStaff = OutsideStaff::create($params);
        $outsideStaff->save();
        $outsideStaff->profile()->save(New Profile($params));

        return $outsideStaff;
    }

    protected function update($request)
    {
        $outsideStaff = OutsideStaff::find($request->Id);
        $inputProfile = $request->only(['first_name','last_name','latin_name','gender','date_of_birth','address','position','company']);

        $inputProfile['date_of_birth'] = date('Y-m-d', strtotime($request->date_of_birth));
        $inputOutsideStaff = $request->only(['nationality', 'education', 'phone_number', 'email', 'company_tel', 'company_email', 'company_address', 'company_website', 'status']);

        if (!empty($outsideStaff)){
            $avatar = request()->file('avatar_file');
            if ($avatar!=null){
                $avatar_path = $this->uploadAndResize($avatar);
                if ($outsideStaff->profile->avatar != "") {
                    if (Storage::disk('public')->exists($outsideStaff->profile->avatar)){
                        Storage::disk('public')->delete($outsideStaff->profile->avatar);
                    }
                }
                $inputProfile['avatar'] = $avatar_path;
            }
        }
        // dd($inputProfile);


        //update child
        $outsideStaff->profile()->update($inputProfile);
        //update parent
        $outsideStaff->update($inputOutsideStaff);
        return $outsideStaff;
    }

    protected  function deleteMultiple($ids)
    {
        return OutsideStaff::whereIn('id', $ids)->delete();
    }

    private function uploadAndResize($image, $size=250)
    {
        $uploadPath = 'files/profile';
        try
        {
            $extension 		= 	$image->getClientOriginalExtension();
            $imageRealPath 	= 	$image->getRealPath();
            $random_name = $this->data['tool']->mt_rand_str(5, '0123456789');
            $thumbName = time() . "_" . $random_name .".". $extension;

            $img = Image::make($imageRealPath); // use this if you want facade style code
            $img->resize(intval($size), null, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(public_path($uploadPath). '/'. $thumbName);
            return $uploadPath.'/'.$img->basename;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

}
