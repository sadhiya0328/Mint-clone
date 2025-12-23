<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $fillable =[
        'user_id',
        'plaid_item_id',
        'name',
        'type',
        'balance',
    ];
    public function user(){
        //account belongs to only one user
        return $this->belongsTo(User::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
