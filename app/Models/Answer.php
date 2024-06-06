<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'response_id',
        'question_id',
        'option_id',
        'option_text',
        'is_active',
        'deleted_at'
    ];
}
