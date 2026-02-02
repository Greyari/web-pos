<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PCBuild extends Model
{
    protected $table = 'pc_builds';

    protected $fillable = [
        'build_name',
        'processor_id',
        'motherboard_id',
        'ram_id',
        'vga_id',
        'storage_id',
        'psu_id',
        'casing_id',
        'total_price',
        'total_power',
        'is_compatible',
        'compatibility_notes'
    ];

    protected $casts = [
        'is_compatible' => 'boolean',
        'compatibility_notes' => 'array'
    ];

    // Relations
    public function processor()
    {
        return $this->belongsTo(Product::class, 'processor_id');
    }

    public function motherboard()
    {
        return $this->belongsTo(Product::class, 'motherboard_id');
    }

    public function ram()
    {
        return $this->belongsTo(Product::class, 'ram_id');
    }

    public function vga()
    {
        return $this->belongsTo(Product::class, 'vga_id');
    }

    public function storage()
    {
        return $this->belongsTo(Product::class, 'storage_id');
    }

    public function psu()
    {
        return $this->belongsTo(Product::class, 'psu_id');
    }

    public function casing()
    {
        return $this->belongsTo(Product::class, 'casing_id');
    }
}
