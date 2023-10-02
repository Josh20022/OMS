<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Text extends Model
{
    use HasTranslations;
    use HasFactory;
    protected $guarded = [];


    public $translatable = ['intro', 'slider', 'oms_title', 'oms', 'method_title', 'method_subtitle', 'mission_title', 'mission', 'iso', 'about', 'details'];
}
