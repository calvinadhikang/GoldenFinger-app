@extends('template/header')

@section('content')
<h1 class="text-3xl font-bold mb-5">Detail Customer</h1>
<div class="rounded bg-accent p-4 mb-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap my-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Joko.." class="input input-bordered w-full" value="{{ $customer->nama }}" name="nama"/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Jalan..." class="input input-bordered w-full" value="{{ $customer->alamat }}" name="alamat"/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="081..." class="input input-bordered w-full" value="{{ $customer->telp }}" name="telp"/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-circle-exclamation me-2"></i>Limit Hutang</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="081..." class="input input-bordered w-full harga" value="{{ intval($customer->limit) }}" name="limit"/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
<div class="prose mt-10">
    <h2 class="text-white">Detail Transaksi</h2>
</div>
<div class="flex w-full mt-5">
    <div class="stat bg-accent w-auto me-4 rounded">
        <div class="stat-title text-white">Jumlah Transaksi</div>
        <div class="stat-value text-primary">{{ count($customer->invoice) }}</div>
        <div class="stat-desc"></div>
    </div>
    <div class="stat bg-accent w-auto me-4 rounded">
        <div class="stat-title text-white">Total Transaksi</div>
        <div class="stat-value">Rp <span class="text-primary">{{ format_decimal($grandTotal) }}</span></div>
        <div class="stat-desc"></div>
    </div>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="overflow-x-auto">
        <table id="table">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Kode</h3></th>
                    <th><h3 class="font-bold">Grand Total (Rp)</h3></th>
                    <th><h3 class="font-bold">Tanggal</h3></th>
                    <th><h3 class="font-bold">Status</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                @if (count($customer->invoice) <= 0)
                    <tr>
                        <td colspan="5">Tidak ada Transaksi</td>
                    </tr>
                @else
                    @foreach ($customer->invoice as $item)
                    <?php
                    $statusClass = "badge-error";
                    $statusText = "Belum Bayar";
                    if ($item->status == 1) {
                        $statusClass = "badge-primary";
                        $statusText = "Lunas";
                    }
                    ?>
                    <tr>
                        <td>{{ $item->kode }}</td>
                        <td>Rp {{ number_format($item->total) }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td><div class="badge {{ $statusClass }} rounded-md text-center font-medium">{{ $statusText }}</div></td>
                        <td>
                            <a href="{{ url('/invoice/detail/'.$item->id) }}">
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
