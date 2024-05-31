<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'section_id',
        'question_text',
        'question_type',
        'order_num',
        'is_active',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($question) {
            foreach ($question->options as $option) {
                $option->delete(); // This will trigger the deleting event on Option
            }
        });

        static::deleted(function ($question) {
            $question->update(['is_active' => 0]);
        });
    }

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }
}
