@extends('template/header')

@section('content')
<div class="flex items-center mb-10">
    <div class="grow m-auto">
        <div class="prose">
            <h1>Data Karyawan</h1>
        </div>
    </div>
</div>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full">
        <a class="btn btn-primary" href="{{url('barang/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">ID</h3></th>
                    <th class="prose"><h3 class="font-bold">Nama</h3></th>
                    <th class="prose"><h3 class="font-bold">Nomor Telp</h3></th>
                    <th class="prose"><h3 class="font-bold">Role</h3></th>
                    <th class="prose"><h3 class="font-bold">Status</h3></th>
                    <th class="prose"><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>1</th>
                    <th>Calvin Adhikang</th>
                    <td>0822 5732 4548</td>
                    <td>Admin</td>
                    <td>
                        <span class="rounded-full bg-secondary py-1 px-3">
                            Aktif
                        </span>
                    </td>
                    <td>
                        <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                    </td>
                </tr>
                <tr>
                    <th>2</th>
                    <th>Yuki</th>
                    <td>0822 5732 4548</td>
                    <td>Pembelian</td>
                    <td>
                        <div class="rounded-full bg-error py-1 px-3">
                            Non-Aktif
                        </div>
                    </td>
                    <td>
                        <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
@endsection