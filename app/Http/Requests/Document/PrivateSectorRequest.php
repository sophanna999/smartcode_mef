<?php

namespace App\Http\Requests\Document;
use App\Http\Requests\Request;

class PrivateSectorRequest extends Request
{
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
        return [
            'company_name' =>'required|max:200',
            'address' =>'required|max:200',
        ];
    }
     public function attributes()
     {
         return [
           'company_name' =>trans('private_sector.company_name'),
           'address' => trans('private_sector.address')
         ];
     }
}
