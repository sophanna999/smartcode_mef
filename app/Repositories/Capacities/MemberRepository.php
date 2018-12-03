<?php
namespace App\Repositories\Capacities;

use App\Repositories\Capacities\ProfileRepository;
use App\Models\BackEnd\Capacity\Member;
use App\Models\BackEnd\Officer\Officer;
use App\Models\BackEnd\Profile;
use Mail;
use DB;

class MemberRepository
{
    protected $member;
    protected $profile_repo;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Member $member,ProfileRepository $profile)
    {
        $this->member  = $member;
        $this->profile_repo  = $profile;
    }

    public function getQuery()
    {
        return $this->member;
    }

    public function count()
    {
        return $this->member->count();
    }

    public function listAll()
    {
        return $this->member->all()->pluck('name', 'id')->all();
    }
    
    public function listAllCodeWithName()
    {
        return $this->member->all()->pluck('code_with_name', 'id')->all();
    }

    public function listId()
    {
        return $this->member->all()->pluck('id')->all();
    }

    public function getAll()
    {
        return $this->member->all();
    }

    public function findOrFail($id)
    {
        $member = $this->member->find($id);

        if (! $member) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find',['attribute' => trans('member.member')])]);
        }

        return $member;
    }

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = $this->member->query()->with('profile');

        for($i = 0; $i < $filters_count; $i++)
        {
            $field_name  = isset($params['filterdatafield'.$i]) ? $params['filterdatafield'.$i] : '';
            $field_value = isset($params['filtervalue'.$i]) ? strval($params['filtervalue'.$i]) : '';
            switch($field_name){
                case 'code':
                    $query->filterByCode($field_value);
                    break;
                case 'full_name':
                    $query->filterByFullName($field_value);
                    break;
                case 'latin_name':
                    $query->filterByLatinName($field_value);
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
            $query->select('mef_members.*', \DB::raw('(select full_name from mef_profiles where mef_members.id = mef_profiles.profileable_id and mef_profiles.profileable_type = "App\Models\BackEnd\Capacity\Member") as full_name'))->orderBy('full_name', $order);
        } elseif ($sort_by === 'latin_name') {
            $query->select('mef_members.*', \DB::raw('(select latin_name from mef_profiles where mef_members.id = mef_profiles.profileable_id and mef_profiles.profileable_type = "App\Models\BackEnd\Capacity\Member") as latin_name'))->orderBy('latin_name', $order);
        } elseif ($sort_by === 'position') {
            $query->select('mef_members.*', \DB::raw('(select position from mef_profiles where mef_members.id = mef_profiles.profileable_id and mef_profiles.profileable_type = "App\Models\BackEnd\Capacity\Member") as position'))->orderBy('position', $order);
        } elseif ($sort_by === 'company') {
            $query->select('mef_members.*', \DB::raw('(select company from mef_profiles where mef_members.id = mef_profiles.profileable_id and mef_profiles.profileable_type = "App\Models\BackEnd\Capacity\Member") as company'))->orderBy('company', $order);
        } else {
            $query->orderBy($sort_by, $order);
        }

        return $query->paginate($page_length);
    }

    /**
     * Create a new member.
     *
     * @param array $params
     * @return Todo
     */

    public function create($request)
    {
        if(!request('type')){
            $officer = DB::table('v_mef_officer')->where('active',1)->where('Id',request('officer'))->whereNull('approve')->orderBy('Id', 'DESC')->first();       
            $request->request->add([
                'full_name' => $officer->full_name_kh,
                'latin_name' => $officer->full_name_en,
                'gender' => $officer->gender,
                'date_of_birth' => $officer->date_of_birth,
                'address' => $officer->current_address,
                'avatar' => $officer->avatar,
                'position' => $officer->position,
                'company' => $officer->department_name,
                // 'company' => $officer->department_name.' '.$officer->ministry_name,
                'phone_number' => $officer->phone_number_1,
                'email' => $officer->email,
            ]);
            $officer_id = $officer->Id;
        }else{
            $officer_id = Officer::firstOrCreate([
                'user_name' => request('username'),
                    'password' => bcrypt(request('password'))
                ])->Id;
        }

        $this->member->fill($request->all());

        $this->member->officer_id = $officer_id;

        $this->member->save();

        $this->member->subject()->sync(request('subjects') ? : []);

        $profile = $this->profile_repo->assignAttribute(new Profile(),$request);

        $this->member->profile()->save($profile);

        if ($request->has('type') && $request->has('send_email')) 
        {
            Mail::send('email.capacities.welcome', ['member' => $this->member,'password' => request('password')], function ($m) {    
                $m->to($this->member->email, $this->member->name)->subject('Account Created');
            });
        }

        return $this->member;
    }

    /**
     * Update given member.
     *
     * @param Member $member
     * @param array $params
     *
     * @return Member
     */
    public function update($id,$request)
    {
        $member = $this->member->findOrFail($id);

        if($member->type != $request->type)
        {
            return response()->json(['message' => trans('general.something_went_wrong')],400);
        }

        if(!$request->type){
            $officer = DB::table('v_mef_officer')->where('active',1)->where('Id',request('officer'))->whereNull('approve')->orderBy('Id', 'DESC')->first();       
            $request->request->add([
                'full_name' => $officer->full_name_kh,
                'latin_name' => $officer->full_name_en,
                'gender' => $officer->gender,
                'date_of_birth' => $officer->date_of_birth,
                'address' => $officer->current_address,
                'avatar' => $officer->avatar,
                'position' => $officer->position,
                'company' => $officer->department_name,
                // 'company' => $officer->department_name.' '.$officer->ministry_name,
                'phone_number' => $officer->phone_number_1,
                'email' => $officer->email,
            ]);
            $officer_id = $officer->Id;
        }

        if($request->type){
            $member->fill(request()->all());
        }else{
            $member->fill(request()->only('code'));
            $member->officer_id = $officer_id;
        }

        $member->save();

        $member->subject()->sync(request('subjects') ? : []);

        $profile = $this->profile_repo->assignAttribute($member->profile,$request);
        $member->profile()->save($profile);

        if(!$request->type)
            return $member;

        $credential = ['user_name' => request('username')];

        $officer = $member->officer;
        $old_username = $officer->user_name;

        $officer->user_name = request('username');

        if(request('password'))
            $officer->password = bcrypt(request('password'));

        $officer->save();

        if (request('password') || ($old_username != request('username'))) 
        {
            Mail::send('email.capacities.credential_changed', [
                'member' => $member,
                'password' => request('password') ? : trans('member.you_current_password') 
            ], function ($m) use ($member) {    
                $m->to($member->email, $member->name)->subject('Crendential Updated');
            });
        }

        return $member;
    }

    public function delete($ids)
    {
        $member = Member::whereIn('id',request('id'))->get();

        return $member->each(function($q){
                if($q->type){
                    $q->officer()->delete();
                }
                $q->profile()->delete();
                $q->delete();
            });
    }
}