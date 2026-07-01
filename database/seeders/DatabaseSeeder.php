<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $defaultCategories = [
            ['name' => 'Makanan', 'type' => 'expense', 'description' => 'Pembelian makanan dan minuman sehari-hari.'],
            ['name' => 'Transportasi', 'type' => 'expense', 'description' => 'Biaya transportasi seperti bensin, angkutan umum, dan tol.'],
            ['name' => 'Belanja', 'type' => 'expense', 'description' => 'Pembelian barang kebutuhan rumah tangga dan pribadi.'],
            ['name' => 'Gaji', 'type' => 'income', 'description' => 'Pendapatan gaji pokok dan tunjangan.'],
            ['name' => 'Investasi', 'type' => 'income', 'description' => 'Pendapatan dari hasil investasi dan passive income.'],
        ];

        foreach ($defaultCategories as $cat) {
            $user->categories()->create($cat);
        }
    }
}
