<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
//This model belongs to one Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
