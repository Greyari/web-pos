<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Processor', 'VGA Card', 'RAM', 'Storage', 'Motherboard', 'Power Supply', 'Casing']);
            $table->string('socket')->nullable(); // LGA1700, AM5, dll
            $table->integer('tdp')->nullable(); // Thermal Design Power (Watt)

            // Spesifikasi Motherboard
            $table->string('chipset')->nullable(); // Z790, B650, dll
            $table->string('ram_type')->nullable(); // DDR4, DDR5
            $table->integer('ram_slots')->nullable(); // 2, 4 slots
            $table->integer('max_ram_speed')->nullable(); // 5600, 6000 MHz

            // Spesifikasi RAM
            $table->string('ram_generation')->nullable(); // DDR4, DDR5
            $table->integer('ram_speed')->nullable(); // 3200, 5600 MHz
            $table->integer('ram_capacity')->nullable(); // 8, 16, 32 GB

            // Spesifikasi VGA Card
            $table->integer('vga_power_consumption')->nullable(); // Watt
            $table->string('vga_power_connector')->nullable(); // 8-pin, 12VHPWR

            // Spesifikasi Storage
            $table->string('storage_type')->nullable(); // NVMe, SATA SSD, HDD
            $table->string('storage_interface')->nullable(); // M.2, 2.5", 3.5"
            $table->integer('storage_capacity')->nullable(); // GB

            // Spesifikasi Power Supply
            $table->integer('psu_wattage')->nullable(); // 650, 850 W
            $table->string('psu_efficiency')->nullable(); // 80+ Bronze, Gold, Platinum

            // Spesifikasi Casing
            $table->string('form_factor')->nullable(); // ATX, Micro-ATX, Mini-ITX
            $table->integer('max_gpu_length')->nullable(); // mm
            $table->integer('max_cpu_cooler_height')->nullable(); // mm
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
