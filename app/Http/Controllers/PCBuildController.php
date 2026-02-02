<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PCBuild;
use App\Services\CompatibilityChecker;
use Illuminate\Http\Request;

class PCBuildController extends Controller
{
    protected $compatibilityChecker;

    public function __construct(CompatibilityChecker $compatibilityChecker)
    {
        $this->compatibilityChecker = $compatibilityChecker;
    }

    /**
     * Show simulator page
     */
    public function index()
    {
        $categories = [
            'Processor',
            'Motherboard',
            'RAM',
            'VGA Card',
            'Storage',
            'Power Supply',
            'Casing'
        ];

        // Get all products grouped by category
        $productsByCategory = [];
        foreach ($categories as $category) {
            $productsByCategory[$category] = Product::where('category', $category)
                ->with('suppliers')
                ->get();
        }

        return view('pc-build.index', compact('productsByCategory', 'categories'));
    }

    /**
     * Get compatible products based on current build
     */
    public function getCompatibleProducts(Request $request)
    {
        $category = $request->category;
        $currentBuild = $request->current_build ?? [];

        // Load selected components
        $components = [];
        foreach ($currentBuild as $key => $productId) {
            if ($productId) {
                $components[$key] = Product::find($productId);
            }
        }

        // Get compatible products for the requested category
        $products = Product::where('category', $category)
            ->with('suppliers')
            ->get();

        // Filter based on compatibility
        $compatibleProducts = $products->filter(function ($product) use ($components, $category) {
            return $this->isProductCompatible($product, $components);
        });

        // Add price information
        $compatibleProducts = $compatibleProducts->map(function ($product) {
            $cheapestPrice = $this->compatibilityChecker->getCheapestPrice($product);
            $product->cheapest_price = $cheapestPrice;
            return $product;
        });

        return response()->json([
            'products' => $compatibleProducts->values(),
            'count' => $compatibleProducts->count()
        ]);
    }

    /**
     * Check if a product is compatible with current build
     */
    private function isProductCompatible($product, $components)
    {
        // Add product to components temporarily
        $testComponents = $components;
        $categoryKey = strtolower(str_replace(' ', '_', $product->category));
        $testComponents[$categoryKey] = $product;

        // Check compatibility
        $result = $this->compatibilityChecker->checkCompatibility($testComponents);

        return $result['is_compatible'];
    }

    /**
     * Calculate build summary
     */
    public function calculateSummary(Request $request)
    {
        $build = $request->build ?? [];

        $components = [];
        $totalPrice = 0;
        $summary = [];

        foreach ($build as $category => $productId) {
            if ($productId) {
                $product = Product::with('suppliers')->find($productId);
                if ($product) {
                    $components[$category] = $product;
                    $price = $this->compatibilityChecker->getCheapestPrice($product);
                    $totalPrice += $price;

                    $summary[] = [
                        'category' => $product->category,
                        'name' => $product->name,
                        'price' => $price
                    ];
                }
            }
        }

        // Check compatibility
        $compatibility = $this->compatibilityChecker->checkCompatibility($components);

        return response()->json([
            'summary' => $summary,
            'total_price' => $totalPrice,
            'total_power' => $compatibility['total_power'],
            'is_compatible' => $compatibility['is_compatible'],
            'issues' => $compatibility['issues'],
            'warnings' => $compatibility['warnings']
        ]);
    }

    /**
     * Save build
     */
    public function saveBuild(Request $request)
    {
        $validated = $request->validate([
            'build_name' => 'required|string|max:255',
            'processor_id' => 'nullable|exists:products,id',
            'motherboard_id' => 'nullable|exists:products,id',
            'ram_id' => 'nullable|exists:products,id',
            'vga_id' => 'nullable|exists:products,id',
            'storage_id' => 'nullable|exists:products,id',
            'psu_id' => 'nullable|exists:products,id',
            'casing_id' => 'nullable|exists:products,id',
        ]);

        // Load components
        $components = [];
        foreach (['processor', 'motherboard', 'ram', 'vga', 'storage', 'psu', 'casing'] as $key) {
            if (isset($validated[$key . '_id'])) {
                $components[$key] = Product::find($validated[$key . '_id']);
            }
        }

        // Calculate totals
        $compatibility = $this->compatibilityChecker->checkCompatibility($components);

        $totalPrice = 0;
        foreach ($components as $component) {
            $totalPrice += $this->compatibilityChecker->getCheapestPrice($component);
        }

        $build = PCBuild::create([
            'build_name' => $validated['build_name'],
            'processor_id' => $validated['processor_id'] ?? null,
            'motherboard_id' => $validated['motherboard_id'] ?? null,
            'ram_id' => $validated['ram_id'] ?? null,
            'vga_id' => $validated['vga_id'] ?? null,
            'storage_id' => $validated['storage_id'] ?? null,
            'psu_id' => $validated['psu_id'] ?? null,
            'casing_id' => $validated['casing_id'] ?? null,
            'total_price' => $totalPrice,
            'total_power' => $compatibility['total_power'],
            'is_compatible' => $compatibility['is_compatible'],
            'compatibility_notes' => array_merge($compatibility['issues'], $compatibility['warnings'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Build berhasil disimpan',
            'build' => $build
        ]);
    }

    /**
     * Get saved builds
     */
    public function savedBuilds()
    {
        $builds = PCBuild::with([
            'processor', 'motherboard', 'ram', 'vga', 'storage', 'psu', 'casing'
        ])->latest()->paginate(10);

        return view('pc-build.saved', compact('builds'));
    }
}
