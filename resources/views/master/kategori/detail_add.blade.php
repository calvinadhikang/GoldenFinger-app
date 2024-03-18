@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Barang Ke Kategori <span class="text-primary">{{ $kategori->nama }}</span></h1>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="text-right mb-5">
            <button class="btn btn-primary">Tambah</button>
        </div>
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th class="font-bold">Part</th>
                    <th class="font-bold">Nama</th>
                    <th class="font-bold">Tambah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unlisted as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox" name="barang[]" value="{{ $item->part }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</div>

<h1 class="font-bold mt-10">Barang Yang Sudah Ada Pada Kategori <span class="text-primary">{{ $kategori->nama }}</span></h1>
<div class="rounded bg-accent p-4 my-5">
    @if (count($listed) > 0)
    <table class="table-zebra w-full data-table">
        <thead>
            <tr>
                <th class="font-bold">Part</th>
                <th class="font-bold">Nama</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listed as $item)
            <tr>
                <td>{{ $item->part }}</td>
                <td>{{ $item->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="text-error font-medium">Belum ada barang yang terdaftar pada kategori</p>
    @endif
</div>

@endsection
