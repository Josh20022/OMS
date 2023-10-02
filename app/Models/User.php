<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setSubdomainAttribute($value)
    {
        $this->attributes['subdomain'] = strtolower($value);
    }

    public function getAvatar()
    {
        if($this->avatar) return asset("uploads/{$this->avatar}");
        return asset('assets/img/user.png');
    }

    public function getCompany()
    {
        $company = User::find($this->company);
        if($company) return $company->name;
        return "Undefined";
    }

    public function isAdmin()
    {
        $user = User::find(auth()->id());
        if($user->type == 'admin') return true;
        return false;
    }

    public function forms()
    {
        return $this->belongsToMany(Form::class);
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }

    public function children()
    {
        return $this->hasMany(User::class, 'company');
    }

    public function parents()
    {
        return $this->belongsTo(User::class, 'company');
    }

    public function formOrder()
    {
        return $this->hasOne(Order::class)->ofMany([], function ($query) {
            $query->where('type', 'form');
        });
    }

    public function documentationOrder()
    {
        return $this->hasOne(Order::class)->ofMany([], function ($query) {
            $query->where([
                ['type', 'page'],
                ['category', 'documentation']
            ]);
        });
    }

    public function documentationPages()
    {
        return $this->belongsToMany(Page::class)->where([
            ['category', 'documentation'],
            ['parent', null]
        ])->with('children');
    }

    public function registrationOrder()
    {
        return $this->hasOne(Order::class)->ofMany([], function ($query) {
            $query->where([
                ['type', 'page'],
                ['category', 'registration']
            ]);
        });
    }

    public function registrationPages()
    {
        return $this->belongsToMany(Page::class)->where([
            ['category', 'registration'],
            ['parent', null]
        ])->with('children');
    }

    public function reportOrder()
    {
        return $this->hasOne(Order::class)->ofMany([], function ($query) {
            $query->where([
                ['type', 'page'],
                ['category', 'report']
            ]);
        });
    }

    public function reportPages()
    {
        return $this->belongsToMany(Page::class)->where([
            ['category', 'report'],
            ['parent', null]
        ])->with('children');
    }
}
