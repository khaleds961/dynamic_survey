<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title_en',
        'title_ar',
        'description_en',
        'description_ar'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($section) {
            foreach ($section->questions as $question) {
                $question->delete(); // This will trigger the deleting event on Question
            }
        });

    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    // Define the many-to-many relationship with Survey
    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_sections', 'section_id', 'survey_id');
    }

    // Scope to include sections related to a specific survey ID
    public function scopeIncludeSurvey($query, $surveyId)
    {
        return $query->whereHas('surveys', function ($query) use ($surveyId) {
            $query->where('survey_id', $surveyId);
        })->withPivot('order_num');
    }

    // Scope to exclude sections related to a specific survey ID
    public function scopeExcludeSurvey($query, $surveyId)
    {
        return $query->whereDoesntHave('surveys', function ($query) use ($surveyId) {
            $query->where('survey_id', $surveyId);
        });
    }
}
