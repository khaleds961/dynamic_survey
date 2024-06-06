<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'date',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($survey) {
            if ($survey->isForceDeleting()) {
                $survey->property()->forceDelete();
            } else {
                $survey->property()->delete();
            }
        });

        static::restoring(function ($survey) {
            $survey->property()->withTrashed()->whereNotNull('deleted_at')->restore();
        });
    }


    public function property()
    {
        return $this->hasOne(Property::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    // Define the many-to-many relationship with Section
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'survey_sections', 'survey_id', 'section_id')
            ->select('*', 'order_num')->orderBy('order_num', 'asc')
            ->wherePivot('is_active', 1);
    }
}
