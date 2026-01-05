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
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class);
    }
}
