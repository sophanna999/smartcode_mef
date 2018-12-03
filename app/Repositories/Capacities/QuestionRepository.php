<?php
namespace App\Repositories\Capacities;

use App\Models\BackEnd\Capacity\Question;
use App\Models\BackEnd\Department\Department;
use App\Repositories\User\UserRepository;

class QuestionRepository
{
    protected $question;
    protected $user;

    public function __construct(Question $question, UserRepository $user)
    {
        $this->question  = $question;
        $this->user  = $user;
    }

    public function getQuery()
    {
        return $this->question;
    }

    public function count()
    {
        return $this->question->count();
    }

    public function listAll()
    {
        return $this->question->all()->pluck('name', 'id')->all();
    }

    public function listId()
    {
        return $this->question->all()->pluck('id')->all();
    }

    public function getAll()
    {
        $query = $this->question->query();

        
        if(! isAdmin() ){
            $gen_departments = Department::find(session('sessionUser')->mef_department_id)->generalDepartment->department->pluck('Id')->all();
            $query->whereIn('department_id',$gen_departments);
        }

        $questions = $query->get();

        return $questions;
    }

    public function findOrFail($id)
    {
        $question = $this->question->find($id);

        if (! $question) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('question.question')]]);
        }

        return $question;
    }

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = $this->question->with('department');

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

        if(! isAdmin() )
            $query->whereDepartmentId(session('sessionUser')->mef_department_id)->orWhere('public',1);

        $query->orderBy($sort_by, $order);

        return $query->paginate($page_length);
    }

    public function create($params)
    {
        return $this->question->forceCreate($this->formatParams($params,true));
    }

    private function formatParams($params,$create = false)
    {
        $formatted = [
            'title'        => isset($params['title']) ? $params['title'] : null,
            'type' => isset($params['type']) ? $params['type'] : null,
            'department_id' => session('sessionUser')->mef_department_id ?? null,
            'option'      => isset($params['option']) ? $params['option'] : 0,
        ];

        if($create)
            $formatted['user_id'] = session('sessionUser')->id;

        return $formatted;
    }

    public function update($id,$params)
    {
        $question = $this->findOrFail($id);

        return $question->forceFill($this->formatParams($params))->save();
    }

    public function delete($ids)
    {
        return $this->question->whereIn('id', $ids)->delete();
    }

}