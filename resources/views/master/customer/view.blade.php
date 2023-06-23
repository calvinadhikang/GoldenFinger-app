@extends('template/header')

@section('content')
<div class="flex items-center mb-10">
    <div class="grow m-auto">
        <div class="prose">
            <h1>Data Customer</h1>
        </div>
    </div>
</div>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full">
        <a class="btn btn-primary" href="{{url('customer/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">ID</h3></th>
                    <th class="prose"><h3 class="font-bold">Nama</h3></th>
                    <th class="prose"><h3 class="font-bold">Nomor Telp</h3></th>
                    <th class="prose"><h3 class="font-bold">Alamat</h3></th>
                    <th class="prose"><h3 class="font-bold">Jumlah Transaksi</h3></th>
                    <th class="prose"><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>1</th>
                    <th>Calvin Adhikang</th>
                    <td>0822 5732 4548</td>
                    <td>-</td>
                    <td>Rp 5.000.000 (3x)</td>
                    <td>
                        <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                    </td>
                </tr>
                <tr>
                    <th>2</th>
                    <th>Yuki</th>
                    <td>0822 5732 4548</td>
                    <td>Banjarmasin I no. 4</td>
                    <td>Rp 2.000.000 (2x)</td>
                    <td>
                        <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
@endsection