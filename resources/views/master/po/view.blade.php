@extends('template/header')

@section('content')
<h1 class="text-3xl font-bold mb-5">Data Purchase Order</h1>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full">
        <a class="btn btn-primary" href="{{url('po/barang')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto mt-5">
        <table id="table" class="table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Kode</h3></th>
                    <th><h3 class="font-bold">Vendor</h3></th>
                    <th><h3 class="font-bold">Nomor Telp</h3></th>
                    <th><h3 class="font-bold">Grand Total (Rp)</h3></th>
                    <th><h3 class="font-bold">Jatuh Tempo</h3></th>
                    <th><h3 class="font-bold">Status Pesanan</h3></th>
                    <th><h3 class="font-bold">Status Pembayaran</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                @if (count($data) > 0)
                    @foreach ($data as $item)
                        <?php
                            $class_pesanan = "badge-error";
                            $text_pesanan = "On Process";

                            $class_pembayaran = "badge-error";
                            $text_pembayaran = "Belum Bayar";

                            if ($item->status_pesanan == 1) {
                                $class_pesanan = "badge-secondary";
                                $text_pesanan = "Selesai";
                            }

                            if ($item->status_pembayaran == 1) {
                                $class_pembayaran = "badge-secondary";
                                $text_pembayaran = "Selesai";
                            }
                        ?>

                        <tr>
                            <th>{{ $item->kode }}</th>
                            <td>{{ $item->vendor->nama }}</td>
                            <td>{{ $item->vendor->telp }}</td>
                            <td>Rp {{ format_decimal($item->grand_total) }}</td>
                            <td>{{ $item->jatuh_tempo }}</td>
                            <td><span class="badge {{ $class_pesanan }}">{{ $text_pesanan }}</span></td>
                            <td><span class="badge {{ $class_pembayaran }}">{{ $text_pembayaran }}</span></td>
                            <td>
                                <a href="{{ url("po/detail/$item->id") }}">
                                    <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <th class="text-error text-lg text-center" colspan="7">Tidak ada data...</th>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
