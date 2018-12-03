<?php

namespace App\Models\BackEnd\Capacity;

use Illuminate\Database\Eloquent\Model;

class SurveyTemplate extends Model
{
    protected $table = 'mef_survey_templates';
    protected $appends = ['number_of_question'];

    public function getNumberOfQuestionAttribute($value){
        return $this->question()->count();
    }

    public function question(){
        return $this->belongsToMany('App\Models\BackEnd\Capacity\Question','mef_question_survey_template');
    }

    public function scopeFilterByCode($q, $code = null)
    {
        if (! $code) {
            return $q;
        }

        return $q->where('code', 'like', '%'.$code.'%');
    }

    public function scopeFilterByName($q, $name = null)
    {
        if (! $name) {
            return $q;
        }

        return $q->where('name', 'like', '%'.$name.'%');
    }

    public function scopeFilterByDescription($q, $description = null)
    {
        if (! $description) {
            return $q;
        }

        return $q->where('description', 'like', '%'.$description.'%');
    }
}
