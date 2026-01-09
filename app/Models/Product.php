<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier')
            ->withPivot('id', 'stock', 'harga_beli', 'harga_jual')
            ->withTimestamps();
    }

    // Helper untuk hitung total stock dari semua supplier
    public function getTotalStockAttribute()
    {
        return $this->suppliers()->sum('product_supplier.stock');
    }
}
