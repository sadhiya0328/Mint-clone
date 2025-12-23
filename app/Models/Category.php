<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable=[
        'name'
    ];
    //One category → many transactions
   //One category → many budgets
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    public function budgets(){
        return $this->hasMany(Budget::class);
    }
}

