<?php
namespace App\Repositories\Capacities;

use App\Models\BackEnd\Capacity\Training;
use App\Models\BackEnd\Capacity\Member;
use App\Models\BackEnd\Capacity\Course;

use App\Repositories\User\UserRepository;
use Illuminate\Database\QueryException;
use Mail;

class TrainingRepository
{
    protected $training;
    protected $member;
    protected $course;

    protected $user;
    public function __construct(Training $training, Member $member, Course $course, UserRepository $user)
    {
        $this->member  = $member;
        $this->user  = $user;
        $this->training  = $training;
        $this->course  = $course;
    }

    public function getQuery()
    {
        return $this->training;
    }

    public function count()
    {
        return $this->training->count();
    }

    public function listAll()
    {
        return $this->training->all()->pluck('title', 'id')->all();
    }

    public function listId()
    {
        return $this->training->all()->pluck('id')->all();
    }

    public function findOrFail($id)
    {
        $training = $this->training->with('member','user')->find($id);

        if (! $training) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('training.training')]]);
        }

        return $training;
    }

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = $this->training->with(['course','location']);

        for($i = 0; $i < $filters_count; $i++)
        {
            $field_name  = isset($params['filterdatafield'.$i]) ? $params['filterdatafield'.$i] : '';
            $field_value = isset($params['filtervalue'.$i]) ? strval($params['filtervalue'.$i]) : '';
            switch($field_name){
                case 'code':
                    $query->filterByCode($field_value);
                    break;
                case 'title':
                    $query->filterByName($field_value);
                    break;
                case 'description':
                    $query->filterByDescription($field_value);
                    break;
                default:
                    #Code...
                    break;
            }
        }
        
        $user = $this->user->findOrFail(session('sessionUser')->id);

        if(!isAdmin($user->id)){
            if($user->mef_member_id){
                $explodes = collect(explode(',',$user->mef_member_id));
                $explodes->push($user->id)->toArray();
                $query->filterByUsers($explodes);
            }else{
                $query->filterByUsers([$user->id]);
            }
        }

        $query->orderBy($sort_by, $order);

        return $query->paginate($page_length);
    }

    public function create($request)
    {
        $training = $this->training->forceCreate($this->formatParams($request,true));

        if($request->has('participants')){
            $this->assign($training->id,$request);
        }

        return $training;
    }

    public function assign($id, $request)
    {
        $training = $this->findOrFail($id);
        
        $participants = [];
        foreach($request->participants as $key => $value){
            $participants[$value] = [
                'type' => $request->type[$key]
            ];
        };

        $types = [];
        foreach($participants as $key => $value)
            $types[$value['type']][$key] =  $value;

        $syncs = [];
        foreach($types as $key => $type){
            $syncs[] = $training->member()->wherePivot('type',$key)->sync($type);
        }

        if($request->send_notification){
            foreach($syncs as $sync){
                foreach($sync as $key => $state_members){
                    if($key != 'updated'){
                        foreach($state_members as $state_member){
                            $member = $this->member->findOrfail($state_member);

                            Mail::send('email.capacities.participant_assigned', [
                                'training' => $training,
                                'member' => $member,
                                'state' => $key
                            ], function ($m) use ($member,$key) {    
                                if($key == 'detached'){
                                    $pre_subject = trans('general.removed').' - ';
                                }elseif($key == 'updated'){
                                    $pre_subject = trans('general.updated').' - ';
                                }else{
                                    $pre_subject = '';
                                }
                                
                                $m->to($member->email, $member->name)->subject($pre_subject.trans('training.assignation'));
                            });
                        }
                    }
                }
            }
            
            // foreach($request->participants as $key => $value) {
            //     $member = $this->member->findOrfail($value);
              
            //     Mail::send('email.capacities.participant_assigned', [
            //         'training' => $training,
            //         'type' => $request->type[$key],
            //         'member' => $member,
            //     ], function ($m) use ($member) {    
            //         $m->to($member->email, $member->name)->subject(trans('training.assignation'));
            //     });
            // }
        }

        return $training;
    }

    private function formatParams($request,$create = false)
    {
        $formatted = [
            'prefix'            => $request->prefix ?  : null,
            'code'              => $request->code ?  : null,
            'start_date'        => $request->start_date ?  : null,
            'end_date'          => $request->end_date ?  : null,
            'course_id'         => $request->course ?  : null,
            'location_id'       => $request->location ?  : null,
            'custom_location'   => $request->custom_location ?  : null,
            'description'       => $request->description ?  : null,
            'status'            => $request->status ?  : 1,
        ];

        if($create)
            $formatted['user_id'] = session('sessionUser')->id;

        return $formatted;
    }

    public function update($id,$params)
    {
        $training = $this->findOrFail($id);

        $training->forceFill($this->formatParams($params))->save();

        if($params->has('participants')){
            $this->assign($id,$params);
        }
        return $training;
    }

    public function deletable($ids)
    {
        $trainings = $this->training->whereIn('id',$ids)->get();

        if($trainings->count() != count($ids)){
            throw ValidationException::withMessages(['message' => trans('general.something_went_wrong')]);
        }

        return $trainings;
    }

    public function delete($ids)
    {
        $trainings = $this->deletable($ids);

        return $this->training->whereIn('id',$ids)->delete();
    }

}