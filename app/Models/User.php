<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    /*relationship*/

    public function accounts(){
        return $this->hasMany(Account::class);
    }
    public function budgets(){
        return $this->hasMany(Budget::class);
    }
    public function bills(){
        return $this->hasMany(Bill::class);
    }
    public function goals(){
        return $this->hasMany(Goal::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}


