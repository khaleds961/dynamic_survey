<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'question_id',
        'option_text_ar',
        'option_text_en',
        'icon',
        'order_num',
        'is_active',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($option) {
            $option->update(['is_active' => 0]);
        });
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
