<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->createBarang();

    }

    function createBarang(){
        $b = Barang::create([
            'part' => 'B001',
            'nama' => 'Barang Pertama',
            'harga' => 1000,
            'batas' => 10,
            'stok' => 0
        ]);

        $b = Barang::create([
            'part' => 'B002',
            'nama' => 'Barang Kedua',
            'harga' => 2000,
            'batas' => 10,
            'stok' => 0
        ]);

        $b = Barang::create([
            'part' => 'B003',
            'nama' => 'Barang Ketiga',
            'harga' => 3000,
            'batas' => 10,
            'stok' => 0
        ]);
    }
}
