<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'survey_id',
        'logo',
        'logoFooter',
        'backgroundColor',
        'backgroundImage',
        'mainColor',
        'fontFamily',
        'wizard',
        'show_personal',
        'footer_ar',
        'footer_en',
        'deleted_at'
    ];

    public function font()
    {
        return $this->belongsTo(Font::class, 'fontFamily');
    }
}
