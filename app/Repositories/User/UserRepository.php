<?php
namespace App\Repositories\User;

use App\Models\BackEnd\User\User;

class UserRepository
{
    protected $user;


    public function __construct(User $user)
    {
        $this->user  = $user;
 
    }

    public function getQuery()
    {
        return $this->user;
    }

    public function count()
    {
        return $this->user->count();
    }

    public function listAll()
    {
        return $this->user->all()->pluck('name', 'id')->all();
    }

    public function listId()
    {
        return $this->user->all()->pluck('id')->all();
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function findOrFail($id)
    {
        $user = $this->user->find($id);

        if (! $user) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('user.user')]]);
        }

        return $user;
    }

    public function findByMemberId($id = null)
    {
        if(!$id){
            $id = session('sessionUser')->id;
        }

        $user = $this->user->find($id);

        if (! $user) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('user.user')]]);
        }

        if($user->mef_member_id){
            return collect(explode(',',$user->mef_member_id));
        }

        return collect([]);
    }

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = $this->user->query();

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

        $query->orderBy($sort_by, $order);

        return $query->paginate($page_length);
    }

    public function create($params)
    {
        return $this->user->forceCreate($this->formatParams($params,true));
    }

    private function formatParams($params,$create = false)
    {
        $formatted = [
            'code'        => isset($params['code']) ? $params['code'] : null,
            'name'        => isset($params['name']) ? $params['name'] : null,
            'description' => isset($params['description']) ? $params['description'] : null
        ];

        if($create)
            $formatted['user_id'] = session('sessionUser')->id;

        return $formatted;
    }

    public function update($id,$params)
    {
        $user = $this->findOrFail($id);

        return $user->forceFill($this->formatParams($params))->save();
    }

    public function delete($ids)
    {
        return $this->user->whereIn('id', $ids)->delete();
    }

}