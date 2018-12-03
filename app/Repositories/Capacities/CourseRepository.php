<?php
namespace App\Repositories\Capacities;

use App\Models\BackEnd\Capacity\Course;

class CourseRepository
{
    protected $course;

    public function __construct(Course $course)
    {
        $this->course  = $course;
    }

    public function getQuery()
    {
        return $this->course->with('subject');
    }

    public function count()
    {
        return $this->course->count();
    }

    public function listAll()
    {
        return $this->course->all()->pluck('title', 'id')->all();
    }

    public function listId()
    {
        return $this->course->all()->pluck('id')->all();
    }

    public function getAll()
    {
        return $this->course->all();
    }

    public function findOrFail($id)
    {
        $course = $this->course->find($id);

        if (! $course) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('course.course')]]);
        }

        return $course;
    }

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = $this->course->with('subject');

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

        $query->orderBy($sort_by, $order);

        return $query->paginate($page_length);
    }

    public function create($params)
    {
        $course = $this->course->forceCreate($this->formatParams($params,true));
        $course->subject()->sync($params['subjects']);
        $course->member()->sync($params['members']);
        $course->question()->sync($params['question']);

         return $course;
    }

    private function formatParams($params,$create = false)
    {
        $formatted = [
            'code'          => isset($params['code']) ? $params['code'] : null,
            'title'         => isset($params['title']) ? $params['title'] : null,
            'description'   => isset($params['description']) ? $params['description'] : null,
            'status'        => isset($params['status']) ? $params['status'] : 1,
        ];

        if($create)
            $formatted['user_id'] = session('sessionUser')->id;

        return $formatted;
    }

    public function update($id,$params)
    {
        $course = $this->findOrFail($id);
        $course->forceFill($this->formatParams($params))->save();
        $course->subject()->sync($params['subjects']);
        $course->member()->sync($params['members']);
        return $course;
    }

    public function update_course_subject($id,$params)
    {
        $course = $this->findOrFail($id);
        $course->forceFill($this->formatParams($params))->save();
        $course->member()->sync($params['members']);
        return $course;
    }

    public function deletable($ids)
    {
        $courses = $this->course->whereIn('id',$ids)->get();

        if($courses->count() != count($ids)){
            throw ValidationException::withMessages(['message' => trans('general.something_went_wrong')]);
        }

        return $courses;
    }

    public function delete($ids)
    {
        $courses = $this->deletable($ids);

        return $courses->each(function($q){
            $q->subject()->detach();
            $q->delete();
        });
    }

}