@extends('template/header')

@section('content')
<div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Data Purchase Order</h1>
    <a class="btn btn-primary" href="{{url('po/barang')}}">Tambah</a>
</div>
<div role="tablist" class="tabs tabs-boxed w-fit mt-5 bg-accent font-semibold">
    <a role="tab" href="/po" class="tab {{ $type == 'all' ? 'tab-active' : '' }}"">Purchase Order Aktif</a>
    <a role="tab" href="/po?type=deleted" class="tab {{ $type == 'deleted' ? 'tab-active' : '' }}">Purchase Order Terhapus</a>
</div>
<div class="rounded-2xl bg-accent p-4 w-full mt-2">
    <div class="overflow-x-auto mt-5">
        <table class="table-zebra data-table">
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

                            if ($item->recieved_at) {
                                $class_pesanan = "badge-secondary";
                                $text_pesanan = "Selesai";
                            }

                            if ($item->paid_at) {
                                $class_pembayaran = "badge-secondary";
                                $text_pembayaran = "Selesai";
                            }
                        ?>

                        <tr>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->vendor->nama }}</td>
                            <td>{{ $item->vendor->telp }}</td>
                            <td>Rp {{ format_decimal($item->grand_total) }}</td>
                            <td>{{ date_format(new DateTime($item->jatuh_tempo), 'd M Y') }}</td>
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
