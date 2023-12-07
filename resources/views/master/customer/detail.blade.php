@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold mb-5">Detail Customer</h1>
<div class="rounded bg-accent p-4 mb-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap my-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                    <span class="label-text-alt">@error('nama') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="Nama..." class="input input-bordered w-full" value="{{ $customer->nama }}" name="nama" />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                    <span class="label-text-alt">@error('email') {{ $message }}  @enderror</span>
                </label>
                <input type="email" placeholder="...@..." class="input input-bordered w-full" value="{{ $customer->email }}" name="email" />
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                    <span class="label-text-alt">@error('alamat') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="Jalan..." class="input input-bordered w-full" value="{{ $customer->alamat }}" name="alamat"/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt">@error('telp') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="081..." class="input input-bordered w-full" value="{{ $customer->telp }}" name="telp"/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-barcode me-2"></i>NPWP</span>
                    <span class="label-text-alt">@error('NPWP') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="001.002.003" class="input input-bordered w-full" value="{{ $customer->NPWP }}" name="NPWP"/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-circle-exclamation me-2"></i>Limit Hutang</span>
                    <span class="label-text-alt">@error('limit') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="081234" class="input input-bordered w-full harga" value="{{ number_format($customer->limit) }}" name="limit"/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
<h2 class="text-xl font-semibold mb-5">Detail Transaksi</h2>
<div class="grid grid-cols-1 md:grid-cols-3 md:gap-5">
    <div class="stat bg-accent w-auto rounded">
        <div class="stat-title">Jumlah Transaksi</div>
        <div class="stat-value text-primary">{{ count($customer->invoice) }}</div>
        <div class="stat-desc">Jumlah Hutang : <span class="text-lg">{{ $countHutang }}</span></div>
    </div>
    <div class="stat bg-accent w-auto rounded">
        <div class="stat-title">Total Transaksi</div>
        <div class="stat-value">Rp <span class="text-primary">{{ format_decimal($grandTotal) }}</span></div>
        <div class="stat-desc"></div>
    </div>
    <div class="stat bg-accent w-auto rounded">
        <div class="stat-title">Total Hutang</div>
        <div class="stat-value">Rp <span class="text-primary">{{ format_decimal($hutang) }}</span></div>
        <div class="stat-desc"></div>
    </div>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="overflow-x-auto">
        <table id="table" class="table-zebra">
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
                        <td colspan="5" class="text-error text-center">Tidak ada Transaksi</td>
                    </tr>
                @else
                    @foreach ($customer->invoice as $item)
                    <tr>
                        <td>{{ $item->kode }}</td>
                        <td>Rp {{ number_format($item->total) }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td><div class="badge {{ $item->status == 1 ? 'badge-secondary' : 'badge-error' }}">{{ $item->status == 1 ? 'Lunas' : 'Belum Lunas' }}</div></td>
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
