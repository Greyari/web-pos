<?php

namespace App\Services;

use App\Models\Product;

class CompatibilityChecker
{
    /**
     * Check compatibility antara komponen yang dipilih
     */
    public function checkCompatibility($components)
    {
        $issues = [];
        $warnings = [];

        $processor = $components['processor'] ?? null;
        $motherboard = $components['motherboard'] ?? null;
        $ram = $components['ram'] ?? null;
        $vga = $components['vga'] ?? null;
        $psu = $components['psu'] ?? null;
        $casing = $components['casing'] ?? null;

        // 1. Check Socket Compatibility (Processor & Motherboard)
        if ($processor && $motherboard) {
            if ($processor->socket !== $motherboard->socket) {
                $issues[] = "Socket tidak kompatibel! Processor ({$processor->socket}) tidak cocok dengan Motherboard ({$motherboard->socket})";
            }
        }

        // 2. Check RAM Compatibility
        if ($ram && $motherboard) {
            if ($ram->ram_generation !== $motherboard->ram_type) {
                $issues[] = "Tipe RAM tidak kompatibel! RAM {$ram->ram_generation} tidak cocok dengan Motherboard {$motherboard->ram_type}";
            }

            if ($ram->ram_speed > $motherboard->max_ram_speed) {
                $warnings[] = "Kecepatan RAM ({$ram->ram_speed}MHz) melebihi maksimal motherboard ({$motherboard->max_ram_speed}MHz). RAM akan berjalan di kecepatan motherboard.";
            }
        }

        // 3. Check Power Supply
        if ($psu) {
            $totalPower = $this->calculateTotalPower($components);
            $recommendedPower = ceil($totalPower * 1.2); // +20% safety margin

            if ($psu->psu_wattage < $recommendedPower) {
                $issues[] = "PSU tidak mencukupi! Total daya sistem: {$totalPower}W, direkomendasikan minimal {$recommendedPower}W, PSU Anda: {$psu->psu_wattage}W";
            } elseif ($psu->psu_wattage < ($totalPower * 1.3)) {
                $warnings[] = "PSU cukup tapi tidak ideal. Untuk performa optimal, gunakan PSU minimal " . ceil($totalPower * 1.3) . "W";
            }
        }

        // 4. Check Form Factor (Motherboard & Casing)
        if ($motherboard && $casing) {
            // Cek apakah form factor motherboard sesuai dengan casing
            $mbFormFactor = $this->getMotherboardFormFactor($motherboard->chipset);
            if ($mbFormFactor && $casing->form_factor) {
                if (!$this->isFormFactorCompatible($mbFormFactor, $casing->form_factor)) {
                    $issues[] = "Form factor tidak kompatibel! Motherboard {$mbFormFactor} tidak cocok dengan casing {$casing->form_factor}";
                }
            }
        }

        // 5. Check VGA Length (jika ada spesifikasi)
        if ($vga && $casing && $casing->max_gpu_length) {
        }

        return [
            'is_compatible' => empty($issues),
            'issues' => $issues,
            'warnings' => $warnings,
            'total_power' => $this->calculateTotalPower($components)
        ];
    }

    /**
     * Get compatible components based on selected component
     */
    public function getCompatibleComponents($selectedComponent, $category)
    {
        $query = Product::where('category', $category);

        if (!$selectedComponent) {
            return $query->get();
        }

        switch ($selectedComponent->category) {
            case 'Processor':
                return $this->getCompatibleWithProcessor($selectedComponent, $category);

            case 'Motherboard':
                return $this->getCompatibleWithMotherboard($selectedComponent, $category);

            case 'RAM':
                return $this->getCompatibleWithRAM($selectedComponent, $category);

            default:
                return $query->get();
        }
    }

    private function getCompatibleWithProcessor($processor, $targetCategory)
    {
        $query = Product::where('category', $targetCategory);

        if ($targetCategory === 'Motherboard') {
            $query->where('socket', $processor->socket);
        }

        return $query->get();
    }

    private function getCompatibleWithMotherboard($motherboard, $targetCategory)
    {
        $query = Product::where('category', $targetCategory);

        switch ($targetCategory) {
            case 'Processor':
                $query->where('socket', $motherboard->socket);
                break;

            case 'RAM':
                $query->where('ram_generation', $motherboard->ram_type)
                      ->where('ram_speed', '<=', $motherboard->max_ram_speed);
                break;

            case 'Casing':
                $mbFormFactor = $this->getMotherboardFormFactor($motherboard->chipset);
                if ($mbFormFactor) {
                    // Casing ATX bisa muat semua, Micro-ATX bisa muat Micro-ATX dan Mini-ITX
                    $query->where(function($q) use ($mbFormFactor) {
                        $q->where('form_factor', 'ATX')
                          ->orWhere('form_factor', $mbFormFactor);
                    });
                }
                break;
        }

        return $query->get();
    }

    private function getCompatibleWithRAM($ram, $targetCategory)
    {
        $query = Product::where('category', $targetCategory);

        if ($targetCategory === 'Motherboard') {
            $query->where('ram_type', $ram->ram_generation)
                  ->where('max_ram_speed', '>=', $ram->ram_speed);
        }

        return $query->get();
    }

    /**
     * Calculate total power consumption
     */
    public function calculateTotalPower($components)
    {
        $totalPower = 0;

        if (isset($components['processor']) && $components['processor']->tdp) {
            $totalPower += $components['processor']->tdp;
        }

        if (isset($components['vga']) && $components['vga']->vga_power_consumption) {
            $totalPower += $components['vga']->vga_power_consumption;
        }

        // Motherboard + RAM + Storage biasanya ~50-100W
        $totalPower += 80;

        return $totalPower;
    }

    /**
     * Get motherboard form factor from chipset
     */
    private function getMotherboardFormFactor($chipset)
    {
        return null;
    }

    /**
     * Check if form factors are compatible
     */
    private function isFormFactorCompatible($mbFormFactor, $casingFormFactor)
    {
        $compatibility = [
            'ATX' => ['ATX'],
            'Micro-ATX' => ['ATX', 'Micro-ATX'],
            'Mini-ITX' => ['ATX', 'Micro-ATX', 'Mini-ITX']
        ];

        return in_array($casingFormFactor, $compatibility[$mbFormFactor] ?? []);
    }

    /**
     * Get cheapest price for product from suppliers
     */
    public function getCheapestPrice($product)
    {
        if (!$product || !$product->suppliers) {
            return 0;
        }

        return $product->suppliers()
            ->wherePivot('stock', '>', 0)
            ->min('product_supplier.harga_jual') ?? 0;
    }
}
