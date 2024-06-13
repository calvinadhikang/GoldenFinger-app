@extends('template/header')

@section('content')
<div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Data Barang</h1>
    <a class="btn btn-primary" href="{{url('barang/add')}}">Tambah</a>
</div>
<div role="tablist" class="tabs tabs-boxed w-fit mt-5 bg-accent font-semibold mb-5">
    <a role="tab" href="/barang" class="tab {{ $type == 'all' ? 'tab-active' : '' }}"">Barang Aktif</a>
    <a role="tab" href="/barang?type=deleted" class="tab {{ $type == 'deleted' ? 'tab-active' : '' }}">Barang Terhapus</a>
</div>
<div class="rounded-2xl bg-accent p-4 w-full">
    <div class="overflow-x-auto">
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Part Number</h3></th>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Harga Jual</h3></th>
                    <th><h3 class="font-bold">Stok</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            @if (count($data) <= 0)
                <tr>
                    <th class="text-error text-lg" colspan="5">Tidak ada data...</th>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->part }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>Rp {{ number_format($item->harga) }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <a href="{{ url("barang/detail/$item->part") }}">
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
