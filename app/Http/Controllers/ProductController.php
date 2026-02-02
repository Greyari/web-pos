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

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(10)->withQueryString();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $categories = ['Processor', 'VGA Card', 'RAM', 'Storage', 'Motherboard', 'Power Supply', 'Casing'];
        return view('products.create', compact('suppliers', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category' => 'required|in:Processor,VGA Card,RAM,Storage,Motherboard,Power Supply,Casing',
            'description' => 'nullable|string',
            'suppliers' => 'required|array|min:1',
            'suppliers.*.supplier_id' => 'required|exists:suppliers,id',
            'suppliers.*.stock' => 'required|integer|min:0',
            'suppliers.*.harga_beli' => 'required|numeric|min:0',
            'suppliers.*.harga_jual' => 'required|numeric|min:0',
        ];

        // Add category-specific validation rules
        $rules = array_merge($rules, $this->getCategorySpecificRules($request->category));

        $validated = $request->validate($rules);

        // Create product with category-specific fields
        $productData = [
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
        ];

        // Add category-specific data
        $productData = array_merge($productData, $this->getCategorySpecificData($validated, $request->category));

        $product = Product::create($productData);

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
        $categories = ['Processor', 'VGA Card', 'RAM', 'Storage', 'Motherboard', 'Power Supply', 'Casing'];
        return view('products.edit', compact('product', 'suppliers', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category' => 'required|in:Processor,VGA Card,RAM,Storage,Motherboard,Power Supply,Casing',
            'description' => 'nullable|string',
            'suppliers' => 'required|array|min:1',
            'suppliers.*.supplier_id' => 'required|exists:suppliers,id',
            'suppliers.*.stock' => 'required|integer|min:0',
            'suppliers.*.harga_beli' => 'required|numeric|min:0',
            'suppliers.*.harga_jual' => 'required|numeric|min:0',
        ];

        // Add category-specific validation rules
        $rules = array_merge($rules, $this->getCategorySpecificRules($request->category));

        $validated = $request->validate($rules);

        // Update product with category-specific fields
        $productData = [
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
        ];

        // Add category-specific data
        $productData = array_merge($productData, $this->getCategorySpecificData($validated, $request->category));

        $product->update($productData);

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

    /**
     * Get validation rules based on category
     */
    private function getCategorySpecificRules($category)
    {
        $rules = [];

        switch ($category) {
            case 'Processor':
                $rules['socket'] = 'required|string';
                $rules['tdp'] = 'required|integer|min:0';
                break;

            case 'Motherboard':
                $rules['socket'] = 'required|string';
                $rules['chipset'] = 'required|string';
                $rules['ram_type'] = 'required|in:DDR4,DDR5';
                $rules['ram_slots'] = 'required|integer|min:1';
                $rules['max_ram_speed'] = 'required|integer|min:0';
                $rules['form_factor'] = 'nullable|in:ATX,Micro-ATX,Mini-ITX';
                break;

            case 'RAM':
                $rules['ram_generation'] = 'required|in:DDR4,DDR5';
                $rules['ram_speed'] = 'required|integer|min:0';
                $rules['ram_capacity'] = 'required|integer|min:0';
                break;

            case 'VGA Card':
                $rules['vga_power_consumption'] = 'required|integer|min:0';
                $rules['vga_power_connector'] = 'nullable|string';
                break;

            case 'Storage':
                $rules['storage_type'] = 'required|in:NVMe,SATA SSD,HDD';
                $rules['storage_interface'] = 'required|in:M.2,2.5",3.5"';
                $rules['storage_capacity'] = 'required|integer|min:0';
                break;

            case 'Power Supply':
                $rules['psu_wattage'] = 'required|integer|min:0';
                $rules['psu_efficiency'] = 'nullable|in:80+ Bronze,80+ Silver,80+ Gold,80+ Platinum,80+ Titanium';
                break;

            case 'Casing':
                $rules['form_factor'] = 'required|in:ATX,Micro-ATX,Mini-ITX';
                $rules['max_gpu_length'] = 'nullable|integer|min:0';
                $rules['max_cpu_cooler_height'] = 'nullable|integer|min:0';
                break;
        }

        return $rules;
    }

    /**
     * Get category-specific data from validated request
     */
    private function getCategorySpecificData($validated, $category)
    {
        $data = [];

        switch ($category) {
            case 'Processor':
                $data['socket'] = $validated['socket'];
                $data['tdp'] = $validated['tdp'];
                break;

            case 'Motherboard':
                $data['socket'] = $validated['socket'];
                $data['chipset'] = $validated['chipset'];
                $data['ram_type'] = $validated['ram_type'];
                $data['ram_slots'] = $validated['ram_slots'];
                $data['max_ram_speed'] = $validated['max_ram_speed'];
                $data['form_factor'] = $validated['form_factor'] ?? null;
                break;

            case 'RAM':
                $data['ram_generation'] = $validated['ram_generation'];
                $data['ram_speed'] = $validated['ram_speed'];
                $data['ram_capacity'] = $validated['ram_capacity'];
                break;

            case 'VGA Card':
                $data['vga_power_consumption'] = $validated['vga_power_consumption'];
                $data['vga_power_connector'] = $validated['vga_power_connector'] ?? null;
                break;

            case 'Storage':
                $data['storage_type'] = $validated['storage_type'];
                $data['storage_interface'] = $validated['storage_interface'];
                $data['storage_capacity'] = $validated['storage_capacity'];
                break;

            case 'Power Supply':
                $data['psu_wattage'] = $validated['psu_wattage'];
                $data['psu_efficiency'] = $validated['psu_efficiency'] ?? null;
                break;

            case 'Casing':
                $data['form_factor'] = $validated['form_factor'];
                $data['max_gpu_length'] = $validated['max_gpu_length'] ?? null;
                $data['max_cpu_cooler_height'] = $validated['max_cpu_cooler_height'] ?? null;
                break;
        }

        return $data;
    }
}
