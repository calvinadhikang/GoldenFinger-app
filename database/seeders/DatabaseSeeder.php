<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Barang;
use App\Models\BarangVendor;
use App\Models\Customer;
use App\Models\HFIFO;
use App\Models\Karyawan;
use App\Models\SharesModel;
use App\Models\Vendor;
use App\Models\VulkanisirMachine;
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
        $this->createMachine();
        $this->createCustomer();
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

        Karyawan::create([
            'nama' => 'Aldi',
            'username' => 'aldi',
            'password' => Hash::make('aldi'),
            'telp' => '081267562393',
            'role' => "Teknisi",
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
            'stok' => 20,
            'public' => true
        ]);

        HFIFO::create([
            'hpurchase_id' => 0,
            'dpurchase_id' => 0,
            'part' => 'B750R16',
            'harga_beli' => 0,
            'qty_max' => 20,
            'qty_used' => 0
        ]);

        Barang::create([
            'part' => 'B1200R24L317',
            'nama' => 'Bridgestone - Tyre 1200 R24 L317',
            'harga' => 800000,
            'batas' => 10,
            'stok' => 12,
            'public' => true
        ]);

        HFIFO::create([
            'hpurchase_id' => 0,
            'dpurchase_id' => 0,
            'part' => 'B1200R24L317',
            'harga_beli' => 0,
            'qty_max' => 12,
            'qty_used' => 0
        ]);

        Barang::create([
            'part' => 'B1200R24M840',
            'nama' => 'Bridgestone - Tyre 1200 R24 M840',
            'harga' => 1000000,
            'batas' => 10,
            'stok' => 2,
            'public' => true
        ]);

        HFIFO::create([
            'hpurchase_id' => 0,
            'dpurchase_id' => 0,
            'part' => 'B1200R24M840',
            'harga_beli' => 0,
            'qty_max' => 2,
            'qty_used' => 0
        ]);

        Barang::create([
            'part' => 'LIButyl',
            'nama' => 'Longmarch Indonesia - Butyl Inner Tube',
            'harga' => 450000,
            'batas' => 10,
            'stok' => 5,
            'public' => true
        ]);

        HFIFO::create([
            'hpurchase_id' => 0,
            'dpurchase_id' => 0,
            'part' => 'LIButyl',
            'harga_beli' => 0,
            'qty_max' => 5,
            'qty_used' => 0
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

    function createMachine(){
        VulkanisirMachine::create([
            'nama' => 'M001'
        ]);
        VulkanisirMachine::create([
            'nama' => 'M002'
        ]);
        VulkanisirMachine::create([
            'nama' => 'M003'
        ]);
    }

    function createCustomer(){
        Customer::create([
            'nama' => 'Calvin Adhikang',
            'email' => 'calvinadhikang@gmail.com',
            'alamat' => 'Jalan Nanas 4 no 404',
            'telp' => '082257324548',
            'kota' => 'Sidoarjo',
            'NPWP' => '10.250.78.900'
        ]);
        Customer::create([
            'nama' => 'Yuki Bara',
            'email' => 'yuki@gmail.com',
            'alamat' => 'Ruko Purimas A1',
            'telp' => '082255554567',
            'kota' => 'Surabaya',
            'NPWP' => '100.200.300'
        ]);
        Customer::create([
            'nama' => 'Angeline',
            'email' => 'angeline@gmail.com',
            'alamat' => 'Twin Tower Surabaya',
            'telp' => '081244789980',
            'kota' => 'Surabaya',
            'NPWP' => '-'
        ]);
    }
}
