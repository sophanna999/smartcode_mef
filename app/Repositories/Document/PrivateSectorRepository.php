<?php
namespace App\Repositories\Document;
use App\Models\BackEnd\Document\PrivateSectorModel;

class PrivateSectorRepository
{
    protected $PrivateSector;

    public function __construct(PrivateSector $PrivateSector)
    {
        $this->PrivateSector  = $PrivateSector;

    }

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sortdatafield']) ? $params['sortdatafield'] : 'created_at';
        $order                 = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $page_length           = isset($params['pagesize']) ? $params['pagesize'] : config('config.pagesize');
        $filters_count         = isset($params['filterscount']) ? $params['filterscount'] : null;

        $query = $this->room->query();

        for($i = 0; $i < $filters_count; $i++)
        {
            $field_name  = isset($params['filterdatafield'.$i]) ? $params['filterdatafield'.$i] : '';
            $field_value = isset($params['filtervalue'.$i]) ? strval($params['filtervalue'.$i]) : '';
            switch($field_name){
                case 'company_name':
                    $query->filterByCode($field_value);
                    break;
                case 'address':
                    $query->filterByName($field_value);
                    break;

                default:
                    #Code...
                    break;
            }
        }

        $query->orderBy($sort_by, $order);

        return $query->paginate($page_length);
    }

}