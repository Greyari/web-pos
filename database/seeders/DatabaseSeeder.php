<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
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

        // Create Sample Products
        Product::create([
            'name' => 'Intel Core i7-13700K',
            'category' => 'Processor',
            'price' => 5500000,
            'stock' => 15,
            'description' => 'Processor Intel Gen 13'
        ]);

        Product::create([
            'name' => 'NVIDIA RTX 4070',
            'category' => 'VGA Card',
            'price' => 9500000,
            'stock' => 8,
            'description' => 'VGA Card NVIDIA RTX 4070'
        ]);

        Product::create([
            'name' => 'Corsair Vengeance 32GB DDR5',
            'category' => 'RAM',
            'price' => 2500000,
            'stock' => 20,
            'description' => 'RAM DDR5 32GB'
        ]);

        // Create Sample Customers
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
