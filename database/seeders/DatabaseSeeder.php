<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Barang;
use App\Models\BarangVendor;
use App\Models\Karyawan;
use App\Models\SharesModel;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('calvin'),
            'telp' => '082257324548',
            'role' => "Stakeholder",
            'status' => 'Aktif',
        ]);

        Karyawan::create([
            'nama' => 'Rina',
            'username' => 'rina',
            'password' => Hash::make('rina'),
            'telp' => '081217393280',
            'role' => "Stakeholder",
            'status' => 'Aktif',
        ]);

        Karyawan::create([
            'nama' => 'Ayau',
            'username' => 'ayau',
            'password' => Hash::make('ayau'),
            'telp' => '081330625880',
            'role' => "Stakeholder",
            'status' => 'Aktif',
        ]);

        Karyawan::create([
            'nama' => 'Nadia Zakarya',
            'username' => 'nadia',
            'password' => Hash::make('nadia'),
            'telp' => '082289722111',
            'role' => "Admin",
            'status' => 'Aktif',
        ]);

        // Create Shares
        SharesModel::create([
            'karyawan_id' => 1,
            'shares' => 0
        ]);
        SharesModel::create([
            'karyawan_id' => 2,
            'shares' => 30
        ]);
        SharesModel::create([
            'karyawan_id' => 3,
            'shares' => 70
        ]);
    }

    function createBarang(){
        Barang::create([
            'part' => 'B750R16',
            'nama' => 'Bridgestone - Tyre 750 R16',
            'harga' => 500000,
            'batas' => 10,
            'stok' => 20
        ]);

        Barang::create([
            'part' => 'B1200R24L317',
            'nama' => 'Bridgestone - Tyre 1200 R24 L317',
            'harga' => 800000,
            'batas' => 10,
            'stok' => 12
        ]);

        Barang::create([
            'part' => 'B1200R24M840',
            'nama' => 'Bridgestone - Tyre 1200 R24 M840',
            'harga' => 1000000,
            'batas' => 10,
            'stok' => 2
        ]);

        Barang::create([
            'part' => 'LIButyl',
            'nama' => 'Longmarch Indonesia - Butyl Inner Tube',
            'harga' => 450000,
            'batas' => 10,
            'stok' => 5
        ]);
    }

    function createVendor(){
        Vendor::create([
            'nama' => 'PT. Ban Indonesia Cemerlang',
            'alamat' => 'Jl Embong Malang 2 kav 45',
            'email' => 'bic@gmail.com',
            'telp' => '082244578970',
            'kota' => 'Jakarta',
            'NPWP' => '200.300.200'
        ]);

        Vendor::create([
            'nama' => 'PT. Nusa Roda Kencana',
            'alamat' => 'Jl Sukmajaya Abadi, Surabaya',
            'email' => 'adi@putra.com',
            'telp' => '082255004488',
            'kota' => 'Surabaya',
            'NPWP' => '57.800.122'
        ]);
    }

    function createBarangVendor(){
        BarangVendor::create([
            'vendor_id' => 1,
            'barang_id' => 'B750R16',
            'harga' => 350000
        ]);
        BarangVendor::create([
            'vendor_id' => 1,
            'barang_id' => 'B1200R24L317',
            'harga' => 700000
        ]);
        BarangVendor::create([
            'vendor_id' => 1,
            'barang_id' => 'B1200R24M840',
            'harga' => 750000
        ]);

        BarangVendor::create([
            'vendor_id' => 2,
            'barang_id' => 'B750R16',
            'harga' => 325000
        ]);
        BarangVendor::create([
            'vendor_id' => 2,
            'barang_id' => 'LIButyl',
            'harga' => 400000
        ]);
    }
}
