<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function data()
    {
        return $this->hasMany(Data::class)->orderBy('id', 'desc');
    }

    public function getStatusIcon()
    {
        $status = $this->data;
        if($status) return "<i class='fas fa-check text-success text-lg'></i>";
        return "<i class='fas fa-ban text-danger text-lg'></i>";
    }

    public function getPublishIcon()
    {
        $publish = $this->publish;
        if($publish) return "<i class='fas fa-check text-success text-lg'></i>";
        return "<i class='fas fa-ban text-danger text-lg'></i>";
    }
}


