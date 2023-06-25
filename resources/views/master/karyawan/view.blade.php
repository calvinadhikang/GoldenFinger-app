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
        <a class="btn btn-primary" href="{{url('karyawan/add')}}">Tambah</a>
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
            @if (count($data) <= 0)
                <tr>
                    <th class="text-error text-lg">Tidak ada data...</th>
                </tr>
            @else
                @foreach ($data as $item)
                <?php
                $role = "Admin";
                if ($item->role == 1) {
                    $role = "Pembelian";
                } else {
                    $role = "Penjualan";
                }

                if ($item->status) {
                    $statusColor = "badge-primary";
                    $status = "Aktif";
                }else{
                    $statusColor = "badge-error";
                    $status = "Non-Aktif";
                }

                ?>
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->telp }}</td>
                        <td>{{ $role }}</td>
                        <td><span class="badge {{ $statusColor }}">{{ $status }}</span></td>
                        <td>
                            <a href="{{ url("karyawan/detail/$item->id") }}">
                                <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
