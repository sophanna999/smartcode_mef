<?php
namespace App\Repositories\Capacities;
use App\Models\BackEnd\Capacity\Location;
use App\Models\BackEnd\Capacity\Room;
use App\Repositories\User\UserRepository;
use App\Models\BackEnd\Department\Department;

class RoomRepository
{
    protected $room;
    protected $user;

    public function __construct(Room $room, UserRepository $user)
    {
        $this->room  = $room;
        $this->user  = $user;
    }

    public function getQuery()
    {
        return $this->room;
    }

    public function count()
    {
        return $this->room->count();
    }

    public function listAll()
    {
        return $this->room->all()->pluck('name', 'id')->all();
    }
    
    public function listAllCodeWithName()
    {
        return $this->room->all()->pluck('code_with_name', 'id')->all();
    }

    public function listId()
    {
        return $this->room->all()->pluck('id')->all();
    }

    public function getAll($location_id = null)
    {
        $query = $this->room->query();

        if($location_id){
            $query->whereLocationId($location_id)->get();
        }

        if(! isAdmin())
            $query->whereHas( 'location', function( $query){
                $query->where('department_id',session('sessionUser')->mef_department_id)->orWhere('public',1);
            })->get();

        $rooms = $query->get();

        return $rooms;
    }

    public function findOrFail($id)
    {
        $room = $this->room->with('location')->find($id);

        if (! $room) {
            throw ValidationException::withMessages(['message' => trans('general.could_not_find'),['attribute' => trans('room.room')]]);
        }

        return $room;
    }

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = $this->room->with('location','department');

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
                case 'location':
                    $query->filterByLocation($field_value);
                    break;
                default:
                    #Code...
                    break;
            }
        }

        if(! isAdmin())
            $query->whereHas( 'location', function( $query){
                $query->where('department_id',session('sessionUser')->mef_department_id)->orWhere('public',1);
            })->get();

        $query->orderBy($sort_by, $order);

        return $query->paginate($page_length);
    }

    public function create($params)
    {
        return $this->room->forceCreate($this->formatParams($params,true));
    }

    private function formatParams($params,$create = false)
    {
        $formatted = [
            'code'          => isset($params['code']) ? $params['code'] : null,
            'name'          => isset($params['name']) ? $params['name'] : null,
            'location_id'   => isset($params['location_id']) ? $params['location_id'] : null,
            'description'   => isset($params['description']) ? $params['description'] : null,
            'public'        => isset($params['public']) ? $params['public'] : 0,
        ];

        if($create)
            $formatted['user_id'] = session('sessionUser')->id;

        return $formatted;
    }

    public function update($id,$params)
    {
        $room = $this->findOrFail($id);

        return $room->forceFill($this->formatParams($params))->save();
    }

    public function delete($ids)
    {
        return $this->room->whereIn('id', $ids)->delete();
    }

}