<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Command;

class SeedDefaultCategories extends Command
{
    protected $signature = 'categories:seed';

    protected $description = 'Tambahkan 5 kategori default untuk semua user yang belum punya kategori';

    public function handle()
    {
        $defaultCategories = [
            ['name' => 'Makanan', 'type' => 'expense', 'description' => 'Pembelian makanan dan minuman sehari-hari.'],
            ['name' => 'Transportasi', 'type' => 'expense', 'description' => 'Biaya transportasi seperti bensin, angkutan umum, dan tol.'],
            ['name' => 'Belanja', 'type' => 'expense', 'description' => 'Pembelian barang kebutuhan rumah tangga dan pribadi.'],
            ['name' => 'Gaji', 'type' => 'income', 'description' => 'Pendapatan gaji pokok dan tunjangan.'],
            ['name' => 'Investasi', 'type' => 'income', 'description' => 'Pendapatan dari hasil investasi dan passive income.'],
        ];

        $users = User::whereDoesntHave('categories')->get();

        if ($users->isEmpty()) {
            $this->info('Semua user sudah memiliki kategori.');
            return;
        }

        foreach ($users as $user) {
            foreach ($defaultCategories as $cat) {
                $user->categories()->create($cat);
            }
            $this->info("Kategori default ditambahkan untuk user: {$user->email}");
        }

        $this->info('Selesai. ' . $users->count() . ' user diproses.');
    }
}
