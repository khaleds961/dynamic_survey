<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveySection extends Model
{
    use HasFactory;
    protected $fillable = [
        'survey_id',
        'section_id',
        'order_num',
        'is_active',
        'deleted_at'
    ];
}
