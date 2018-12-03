<?php
namespace App\Repositories\Capacities;

use App\Models\BackEnd\Capacity\Subject;
use App\Repositories\User\UserRepository;
use App\Models\BackEnd\Department\Department;

class SubjectRepository
{
    protected $subject;
    protected $user;

    public function __construct(Subject $subject, UserRepository $user)
    {
        $this->subject  = $subject;
        $this->user  = $user;
    }

    public function getQuery()
    {
        return $this->subject;
    }

    public function count()
    {
        return $this->subject->count();
    }

    public function listAll()
    {
        return $this->subject->all()->pluck('name', 'id')->all();
    }

    public function listId()
    {
        return $this->subject->all()->pluck('id')->all();
    }

    public function getAll()
    {
        $query = $this->subject->query();

        if(! isAdmin()){
            $gen_departments = Department::find(session('sessionUser')->mef_department_id)->generalDepartment->department->pluck('Id')->all();
            $query->whereIn('department_id',$gen_departments)->orWhere('public',1);
        }

        $subjects = $query->get();

        return $subjects;
    }

    public function findOrFail($id)
    {
        $subject = $this->subject->find($id);

        if (! $subject) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('subject.subject')]]);
        }

        return $subject;
    }

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = $this->subject->with('department');

        for($i = 0; $i < $filters_count; $i++)
        {
            $field_name  = isset($params['filterdatafield'.$i]) ? $params['filterdatafield'.$i] : '';
            $field_value = isset($params['filtervalue'.$i]) ? strval($params['filtervalue'.$i]) : '';
            switch($field_name){
                case 'code':
                    $query->filterByCode($field_value);
                    break;
                case 'name':
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

        if(! isAdmin()){
            $gen_departments = Department::find(session('sessionUser')->mef_department_id)->generalDepartment->department->pluck('Id')->all();
            $query->whereIn('department_id',$gen_departments)->orWhere('public',1);
        }

        $query->orderBy($sort_by, $order);

        return $query->paginate($page_length);
    }

    public function create($params)
    {
        return $this->subject->forceCreate($this->formatParams($params,true));
    }

    private function formatParams($params,$create = false)
    {
        $formatted = [
            'code'        => isset($params['code']) ? $params['code'] : null,
            'name'        => isset($params['name']) ? $params['name'] : null,
            'description' => isset($params['description']) ? $params['description'] : null,
            'department_id' => session('sessionUser')->mef_department_id ?? null,
            'public'        => isset($params['public']) ? $params['public'] : 0,
        ];

        if($create)
            $formatted['user_id'] = session('sessionUser')->id;

        return $formatted;
    }

    public function update($id,$params)
    {
        $subject = $this->findOrFail($id);

        return $subject->forceFill($this->formatParams($params))->save();
    }

    public function delete($ids)
    {
        return $this->subject->whereIn('id', $ids)->delete();
    }

}