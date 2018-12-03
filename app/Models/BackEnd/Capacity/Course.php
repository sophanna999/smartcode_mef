<?php

namespace App\Models\BackEnd\Capacity;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'mef_courses';
    protected $fillable = ['code','title','description'];

    public function survey()
    {
        return $this->hasMany('App\Models\BackEnd\Capacity\CourseSurvey');
    }

    public function subject()
    {
        return $this->belongsToMany('App\Models\BackEnd\Capacity\Subject','mef_course_subject');
    }

    public function member()
    {
        return $this->belongsToMany('App\Models\BackEnd\Capacity\Member','mef_course_member');
    }

    public function question(){
        return $this->belongsToMany('App\Models\BackEnd\Capacity\Question','mef_question_survey_template');
    }

    public function getTitleWithCodeAttribute($value)
    {
        return $this->code.' '. $this->title;
    }

    public function scopeFilterByCode($q, $code = null)
    {
        if (! $code) {
            return $q;
        }

        return $q->where('code', 'like', '%'.$code.'%');
    }

    public function scopeFilterByTitle($q, $title = null)
    {
        if (! $title) {
            return $q;
        }

        return $q->where('title', 'like', '%'.$title.'%');
    }

    public function scopeFilterByDescription($q, $description = null)
    {
        if (! $description) {
            return $q;
        }

        return $q->where('description', 'like', '%'.$description.'%');
    }
}
