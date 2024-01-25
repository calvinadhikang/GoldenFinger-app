@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Detail Kategori</h1>
<div class="rounded bg-accent p-4 my-5">
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

<h1 class="text-xl font-medium my-5">List Barang dengan Kategori</h1>
<div class="rounded bg-accent p-4 my-5">
    <p class="text-right">Jumlah Barang dengan Kategori : {{ count($kategori->barang) }}</p>
    <div class="flex justify-end w-full mb-10 mt-2">
        <a class="btn btn-primary" href='{{ url("/kategori/detail/$kategori->id/add/barang") }}'>Tambah</a>
    </div>
    <table id="table" class="table-zebra">
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
                    <td><a href="" class="btn btn-xs btn-error">Hapus</a></td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection
