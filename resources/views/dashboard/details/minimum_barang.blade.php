@extends('template.header')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold">Barang Stok Minimum</h1>
    <a href="/po/barang"><button class="btn btn-primary mb-5">Pesan ke Vendor</button></a>
</div>
<div class="text-sm breadcrumbs mb-5 text-slate-300">
    <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li>Barang Stok Minimum</li>
    </ul>
</div>
<div class="p-4 rounded shadow bg-accent">
    <table class="data-table table-zebra">
        <thead>
            <tr>
                <th>Part</th>
                <th>Nama</th>
                <th>Stok</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $item->part }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->stok }}</td>
                <td><a href="{{ url("/barang/detail/$item->part") }}"><i class="fa-solid fa-circle-info text-base hover:text-secondary"></i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p class="font-medium text-right mt-5">Jumlah Barang Stok Minimum : {{ count($data) }}</p>
</div>
@endsection
