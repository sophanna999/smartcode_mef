<?php

namespace App\Http\Requests\Capacities;

use App\Http\Requests\Request;
use App\Repositories\Capacities\LocationRepository;

class RoomRequest extends Request
{
    protected $location;
    protected $default_location;

    public function __construct(LocationRepository $location)
    {
        $this->location = $location;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->request->get('location')){
            $location = $this->location->findOrFail($this->request->get('location'));
            $this->detault_location = $location->name;
        }

        return [
            'code' => 'unique:mef_rooms,code'.($this->route() ? ','. $this->route('id') : '' ).'|max:10',
            'name' => 'required|max:255',
            'location' => 'required|exists:mef_locations,id',
        ];
    }

    public function attributes()
    {
        return [
            'code' => trans('room.code'),
            'name' => trans('room.name'),
            'location' => trans('location.location'),
        ];
    }

}
