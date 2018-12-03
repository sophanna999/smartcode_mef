<?php
namespace App\Repositories\Capacities;

use App\Models\BackEnd\Capacity\SurveyTemplate;
use App\Models\BackEnd\Department\Department;
use App\Repositories\User\UserRepository;

class SurveyTemplateRepository
{
    protected $surveyTemplate;
    protected $user;

    public function __construct(SurveyTemplate $surveyTemplate, UserRepository $user)
    {
        $this->surveyTemplate  = $surveyTemplate;
        $this->user  = $user;
    }

    public function getQuery()
    {
        return $this->surveyTemplate;
    }

    public function count()
    {
        return $this->surveyTemplate->count();
    }

    public function listAll()
    {
        return $this->surveyTemplate->all()->pluck('name', 'id')->all();
    }

    public function listId()
    {
        return $this->surveyTemplate->all()->pluck('id')->all();
    }

    public function getAll()
    {
        $query = $this->surveyTemplate->query();

        
        if(! isAdmin() ){
            $gen_departments = Department::find(session('sessionUser')->mef_department_id)->generalDepartment->department->pluck('Id')->all();
            $query->whereIn('department_id',$gen_departments);
        }

        $surveyTemplates = $query->get();

        return $surveyTemplates;
    }

    public function findOrFail($id)
    {
        $surveyTemplate = $this->surveyTemplate->with('question')->find($id);

        if (! $surveyTemplate) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('surveyTemplate.surveyTemplate')]]);
        }

        return $surveyTemplate;
    }

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = $this->surveyTemplate->with('question');

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
                    break;
            }
        }

        if(! isAdmin() )
            $query->whereDepartmentId(session('sessionUser')->mef_department_id);

        $query->orderBy($sort_by, $order);

        return $query->paginate($page_length);
    }

    public function create($params)
    {
        $create = $this->surveyTemplate->forceCreate($this->formatParams($params,true));

        if($create)
            $create->question()->sync($params['question']);

        return $create;
    }

    public function addQuestion($question){
        $this->surveyTemplate->sync($request);
    }

    private function formatParams($params,$create = false)
    {
        $formatted = [
            'code'        => isset($params['code']) ? $params['code'] : null,
            'name'        => isset($params['name']) ? $params['name'] : null,
            'description' => isset($params['description']) ? $params['description'] : null,
            'department_id' => session('sessionUser')->mef_department_id ?? null,
        ];

        if($create)
            $formatted['user_id'] = session('sessionUser')->id;

        return $formatted;
    }

    public function update($id,$params)
    {
        $survey_template = $this->findOrFail($id);

        $update = $survey_template->forceFill($this->formatParams($params))->save();

        if($update)
            $survey_template->question()->sync($params['question']);

        return $survey_template;
    }

    public function delete($ids)
    {
        return $this->surveyTemplate->whereIn('id', $ids)->delete();
    }

}