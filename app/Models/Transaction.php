<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable=[ //fillable is a property that allows the transaction to fill the data in the database
        'account_id',
        'category_id',
        'description',
        'amount',
        'date'
    ];
        protected $casts = [ //casts is a property that allows the transaction to cast the data in the database
        'date' => 'datetime'
    ];

    public function account() 
    {
        return $this->belongsTo(Account::class); //belongsTo is a relationship that allows the transaction to belong to an account
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

