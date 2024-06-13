@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Detail Kategori</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/kategori">Data Kategori</a></li>
        <li>Detail Kategori</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 mb-5">
    <form method="POST">
        @csrf
        <input type="hidden" value="{{ $kategori->id }}" name="id">
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Ban Luar..." class="input input-bordered w-full" name="nama" value="{{ $kategori->nama }}" required/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>

<div class="flex items-center justify-between">
    <h1 class="text-lg font-medium">List Barang dengan Kategori</h1>
    <a class="btn btn-primary" href='{{ url("/kategori/detail/$kategori->id/add/barang") }}'>Tambah</a>
</div>
<p class="text-sm  ">Jumlah Barang : {{ count($kategori->barang) }}</p>
<div class="rounded bg-accent p-4 my-5">
    <table class="data-table table-zebra">
        <thead>
            <tr>
                <th class="font-bold">Kode Barang</th>
                <th class="font-bold">Nama Barang</th>
                <th class="font-bold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (count($kategori->barang) <= 0)
                <tr>
                    <th colspan="3" class="text-lg text-error">Tidak ada data...</th>
                </tr>
            @else
                @foreach ($kategori->barang as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        <form method="POST" action="{{ url("/kategori/detail/$kategori->id/remove") }}">
                            @csrf
                            <button class="btn btn-xs btn-error" name="barang" value="{{ $item->part }}">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<h1 class="text-error text-lg font-semibold">Hapus Kategori</h1>
<div class="bg-accent p-4 rounded mt-5">
    <p class="text-error">Untuk menghapus kategori, masukan password !</p>
    <form method="POST" action="{{ url("/kategori/detail/$kategori->id/delete") }}" class="flex items-center gap-x-2 mt-2">
        @csrf
        <input type="password" class="input input-error" placeholder="password.." name="password">
        <button class="btn btn-error">Hapus Kategori</button>
    </form>
</div>
@endsection
