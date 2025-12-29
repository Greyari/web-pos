<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PcBuilderController extends Controller
{
    public function index()
    {
        $components = [
            'processors' => Product::where('category', 'Processor')->where('stock', '>', 0)->get(),
            'vgas' => Product::where('category', 'VGA Card')->where('stock', '>', 0)->get(),
            'rams' => Product::where('category', 'RAM')->where('stock', '>', 0)->get(),
            'storages' => Product::where('category', 'Storage')->where('stock', '>', 0)->get(),
            'motherboards' => Product::where('category', 'Motherboard')->where('stock', '>', 0)->get(),
            'psus' => Product::where('category', 'Power Supply')->where('stock', '>', 0)->get(),
            'casings' => Product::where('category', 'Casing')->where('stock', '>', 0)->get(),
        ];

        return view('pc-builder.index', compact('components'));
    }
}
