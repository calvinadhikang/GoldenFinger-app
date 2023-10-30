<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Barang;
use App\Models\BarangVendor;
use App\Models\Karyawan;
use App\Models\Vendor;
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
        $this->createKaryawan();
        $this->createVendor();
        $this->createBarangVendor();
    }

    function createKaryawan(){
        Karyawan::create([
            'nama' => 'Calvin Adhikang',
            'username' => 'calvin',
            'password' => 'calvin',
            'telp' => '082257324548',
            'role' => "Admin",
            'status' => 'Aktif',
        ]);
    }

    function createBarang(){
        Barang::create([
            'part' => 'B001',
            'nama' => 'Barang Pertama',
            'harga' => 1000,
            'batas' => 10,
            'stok' => 0
        ]);

        Barang::create([
            'part' => 'B002',
            'nama' => 'Barang Kedua',
            'harga' => 2000,
            'batas' => 10,
            'stok' => 0
        ]);

        Barang::create([
            'part' => 'B003',
            'nama' => 'Barang Ketiga',
            'harga' => 3000,
            'batas' => 10,
            'stok' => 0
        ]);
    }

    function createVendor(){
        Vendor::create([
            'nama' => 'Supplier Pertama',
            'alamat' => 'JL supplier pertama, Surabaya',
            'email' => 'supp@pertama.com',
            'telp' => '123123',
        ]);
    }

    function createBarangVendor(){
        BarangVendor::create([
            'vendor_id' => 1,
            'barang_id' => 'B001',
            'harga' => 500000
        ]);
        BarangVendor::create([
            'vendor_id' => 1,
            'barang_id' => 'B002',
            'harga' => 750000
        ]);
    }
}
