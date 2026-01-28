<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('suppliers');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(10)->withQueryString();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('products.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Processor,VGA Card,RAM,Storage,Motherboard,Power Supply,Casing',
            'description' => 'nullable|string',

            // Validasi untuk suppliers (array)
            'suppliers' => 'required|array|min:1',
            'suppliers.*.supplier_id' => 'required|exists:suppliers,id',
            'suppliers.*.stock' => 'required|integer|min:0',
            'suppliers.*.harga_beli' => 'required|numeric|min:0',
            'suppliers.*.harga_jual' => 'required|numeric|min:0',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
        ]);

        // Attach suppliers dengan data pivot
        foreach ($validated['suppliers'] as $supplierData) {
            $product->suppliers()->attach($supplierData['supplier_id'], [
                'stock' => $supplierData['stock'],
                'harga_beli' => $supplierData['harga_beli'],
                'harga_jual' => $supplierData['harga_jual'],
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $product->load('suppliers');
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Processor,VGA Card,RAM,Storage,Motherboard,Power Supply,Casing',
            'description' => 'nullable|string',

            'suppliers' => 'required|array|min:1',
            'suppliers.*.supplier_id' => 'required|exists:suppliers,id',
            'suppliers.*.stock' => 'required|integer|min:0',
            'suppliers.*.harga_beli' => 'required|numeric|min:0',
            'suppliers.*.harga_jual' => 'required|numeric|min:0',
        ]);

        $product->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
        ]);

        // Sync suppliers dengan data baru
        $syncData = [];
        foreach ($validated['suppliers'] as $supplierData) {
            $syncData[$supplierData['supplier_id']] = [
                'stock' => $supplierData['stock'],
                'harga_beli' => $supplierData['harga_beli'],
                'harga_jual' => $supplierData['harga_jual'],
            ];
        }
        $product->suppliers()->sync($syncData);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    public function reportProduct()
    {
        return view('laporan-product.index');
    }
}
