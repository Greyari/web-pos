<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ======================
        // USERS
        // ======================
        User::create([
            'name' => 'Kasir User',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'kasir'
        ]);

        User::create([
            'name' => 'Owner User',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'owner'
        ]);

        // ======================
        // SUPPLIERS
        // ======================
        $supplier1 = Supplier::create([
            'nama_supplier' => 'PT Sumber Teknologi',
            'alamat' => 'Jakarta'
        ]);

        $supplier2 = Supplier::create([
            'nama_supplier' => 'CV Mega Komputer',
            'alamat' => 'Surabaya'
        ]);

        // ======================
        // PRODUCTS
        // ======================
        $cpu = Product::create([
            'name' => 'Intel Core i7-13700K',
            'category' => 'Processor',
        ]);

        $vga = Product::create([
            'name' => 'NVIDIA RTX 4070',
            'category' => 'VGA Card',
        ]);

        $ram = Product::create([
            'name' => 'Corsair Vengeance 32GB DDR5',
            'category' => 'RAM',
        ]);

        // ======================
        // PRODUCT ↔ SUPPLIER (PIVOT)
        // ======================
        $cpu->suppliers()->attach($supplier1->id, [
            'stock' => 10,
            'harga_beli' => 5000000,
            'harga_jual' => 5500000,
        ]);

        $cpu->suppliers()->attach($supplier2->id, [
            'stock' => 5,
            'harga_beli' => 4900000,
            'harga_jual' => 5400000,
        ]);

        $vga->suppliers()->attach($supplier1->id, [
            'stock' => 6,
            'harga_beli' => 9000000,
            'harga_jual' => 9500000,
        ]);

        $ram->suppliers()->attach($supplier2->id, [
            'stock' => 20,
            'harga_beli' => 2200000,
            'harga_jual' => 2500000,
        ]);

        // ======================
        // CUSTOMERS
        // ======================
        Customer::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@email.com',
            'phone' => '081234567890',
            'address' => 'Jakarta Selatan'
        ]);

        Customer::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@email.com',
            'phone' => '081234567891',
            'address' => 'Bandung'
        ]);
    }
}
