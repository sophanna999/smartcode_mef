<?php

namespace App\Models\BackEnd\Capacity;

use Illuminate\Database\Eloquent\Model;

class CourseSurvey extends Model
{
    protected $table = 'mef_course_surveys';

    protected $fillable = ['name','course_id'];

    public function course(){
        return $this->belongsTo('App\Models\BackEnd\Capacity\Course');
    }

}
