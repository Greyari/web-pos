<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'description'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
