<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Material;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Bgroup',
            'email' => 'admin@bgroup.id',
            'password' => \bcrypt('rahasia')
        ]);

        for ($i=1; $i <= 3; $i++) {
            Material::create([
                'item' => "hosting $i",
                'price' => 1500000,
                'due_date' => '2024-05-02',
                'material' => 'hosting',
                'billing_cycle' => 'per 1 tahun'
            ]);
        }
        for ($i=1; $i <= 3; $i++) {
            Material::create([
                'item' => "domain $i",
                'price' => 1500000,
                'due_date' => '2024-05-02',
                'material' => 'domain',
                'billing_cycle' => 'per 1 tahun'
            ]);
        }
        for ($i=1; $i <= 3; $i++) {
            Material::create([
                'item' => "ssl $i",
                'price' => 1500000,
                'due_date' => '2024-05-02',
                'material' => 'ssl',
                'billing_cycle' => 'per 1 tahun'
            ]);
        }
    }
}
