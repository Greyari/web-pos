<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pc_builds', function (Blueprint $table) {
            $table->id();
            $table->string('build_name')->nullable();

            // Foreign keys untuk setiap komponen
            $table->foreignId('processor_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('motherboard_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('ram_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('vga_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('storage_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('psu_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('casing_id')->nullable()->constrained('products')->onDelete('set null');

            // Summary data
            $table->decimal('total_price', 15, 2)->default(0);
            $table->integer('total_power')->default(0); // Total TDP dalam Watt
            $table->boolean('is_compatible')->default(true);
            $table->json('compatibility_notes')->nullable(); // Array pesan kompatibilitas

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pc_builds');
    }
};
