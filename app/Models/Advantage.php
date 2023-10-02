<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Advantage extends Model
{
    use HasTranslations;
    use HasFactory;
    protected $guarded = [];


    public $translatable = ['title', 'description'];
}
