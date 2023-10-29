@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat Purchase Order</h1>
</div>
<ul class="mt-5 steps w-full">
    <li class="step step-primary"><a href="/po/barang" class="hover:underline">Pilih Barang</a></li>
    <li class="step step-primary text-primary font-medium">Pilih Vendor</li>
    <li class="step">Konfirmasi</li>
</ul>
<div class="mb-5 mt-10">
    <h2 class="font-bold text-3xl">Pilih Vendor</h2>
    <p>Pilih Vendor dengan harga yang paling sesuai</p>
    <p class="italic">*harga ditentukan dari harga tawaran masing2 vendor</p>
</div>
<div class="rounded bg-accent p-4 my-5">
    <p class="mb-5 font-semibold text-primary">Total : {{ count($vendor) }} Vendor Tersedia</p>
    <div class="overflow-x-auto mb-5">
        <table id="table">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Nomor Telepon</h3></th>
                    <th><h3 class="font-bold">Harga Tawaran Vendor</h3></th>
                    <th><h3 class="font-bold">Pilih Vendor</h3></th>
                </tr>
            </thead>
            <tbody>
                @if (count($vendor) > 0)
                    @foreach ($vendor as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->telp }}</td>
                            <td class="hover:text-lg hover:font-semibold">Rp {{ number_format($item->total) }}</td>
                            <td>
                                <form action="" method="post">
                                    @csrf
                                    <button class="btn btn-sm btn-primary" value="{{ $item->id }}" name="vendor">Pilih !</button>
                                    <input type="hidden" name="total" value="{{ $item->total }}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-error hover:underline"><a href="/po/barang">Tidak ada Vendor yang dapat mensupply pilihan barang. Klik untuk kembali</a></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
