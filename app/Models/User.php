<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = ['name', 'email', 'password']; //fillable is a property that allows the user to fill the data in the database

    protected $hidden = ['password'];

    /*relationship*/

    public function accounts(){
        return $this->hasMany(Account::class); //hasMany is a relationship that allows the user to have many accounts
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

    public function getJWTIdentifier() //JWTIdentifier is a method that returns the user id
    { //getKey is a method that returns the key of the user id
        return $this->getKey();
    }

    public function getJWTCustomClaims() //getJWTCustomClaims is a method that returns the custom claims of the user
    {
        return []; //
    }

}


