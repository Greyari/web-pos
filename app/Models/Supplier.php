<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama_supplier',
        'alamat'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('stock', 'harga_beli', 'harga_jual')
            ->withTimestamps();
    }
}
