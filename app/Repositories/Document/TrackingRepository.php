<?php
namespace App\Repositories\Document;
use App\Models\BackEnd\Document\Tracking;
use App\Models\BackEnd\Document\Setting;
use App\Models\BackEnd\Document\Source;
class TrackingRepository extends BaseRepository
{
    protected $model;
    public function __construct(Tracking $Tracking,Source $Source)
    {
        $this->model = $Tracking;
        $this->source = $Source;
    }
	public function create($params)
    {
        return $this->model->forceCreate($this->formatParams($params,true));
    }
	private function formatParams($params,$create = false)
    {
        $formatted = [
            'source'        => isset($params['source']) ? $params['source'] : null,
            'sender'        => isset($params['sender']) ? $params['sender'] : null,
            'contact_number' => isset($params['contact_number']) ? $params['contact_number'] : null,
            'objective' => isset($params['objective']) ? $params['objective'] : null,
            'flow' => isset($params['flow']) ? $params['flow'] : null,
            'letter_in_serial' => isset($params['letter_in_serial']) ? $params['letter_in_serial'] : null,
            'is_urgent' => isset($params['is_urgent']) ? $params['is_urgent'] : null,
            'is_secret' => isset($params['is_secret']) ? $params['is_secret'] : null,
            'category' => isset($params['category']) ? $params['category'] : null,
            'refernece_number' => isset($params['refernece_number']) ? $params['refernece_number'] : null,
            'privacy' => isset($params['privacy']) ? $params['privacy'] : null,
            'receiver' => isset($params['receiver']) ? $params['receiver'] : null,
            'admin_serial_in' => isset($params['admin_serial_in']) ? $params['admin_serial_in'] : null,
            'admin_in_date' => isset($params['admin_in_date']) ? $params['admin_in_date'] : null
        ];

        if($create)
            $formatted['created_by'] = session('sessionUser')->id;
        return $formatted;
    }
    
    public function listAll()
    {
        return $this->model->with(['source','flow'])->get();
    }
    public function source(){
        return $this->source->get();
    }
}