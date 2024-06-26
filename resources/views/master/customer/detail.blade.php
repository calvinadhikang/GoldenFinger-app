@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Detail Customer</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/customer">Data Customer</a></li>
        <li>Detail Customer</li>
    </ul>
</div>
<div class="rounded-2xl bg-accent p-4 mb-5">
    <form method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-5">
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                    <span class="label-text-alt">@error('nama') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="Nama..." class="input w-full" value="{{ $customer->nama }}" name="nama" />
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                    <span class="label-text-alt">@error('email') {{ $message }}  @enderror</span>
                </label>
                <input type="email" placeholder="...@..." class="input w-full" value="{{ $customer->email }}" name="email" />
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                    <span class="label-text-alt">@error('alamat') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="Jalan..." class="input w-full" value="{{ $customer->alamat }}" name="alamat"/>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-city me-2"></i>Kota</span>
                    <span class="label-text-alt">@error('kota') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="081..." class="input w-full" value="{{ $customer->kota }}" name="kota"/>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt">@error('telp') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="081..." class="input w-full" value="{{ $customer->telp }}" name="telp"/>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-barcode me-2"></i>NPWP</span>
                    <span class="label-text-alt">@error('NPWP') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="001.002.003" class="input w-full" value="{{ $customer->NPWP }}" name="NPWP"/>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-circle-exclamation me-2"></i>Limit Hutang</span>
                    <span class="label-text-alt">@error('limit') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="081234" class="input w-full harga" value="{{ number_format($customer->limit) }}" name="limit"/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
<h2 class="text-xl font-semibold mb-5">Detail Transaksi</h2>
<div class="grid grid-cols-1 md:grid-cols-3 md:gap-5">
    <div class="stat bg-accent w-auto rounded-2xl">
        <div class="stat-title">Jumlah Transaksi</div>
        <div class="stat-value">{{ count($customer->invoice) }}</div>
        <div class="stat-desc">Jumlah Hutang : <span class="text-lg">{{ $countHutang }}</span></div>
    </div>
    <div class="stat bg-accent w-auto rounded-2xl">
        <div class="stat-title">Total Transaksi</div>
        <div class="stat-value">Rp <span class="">{{ format_decimal($grandTotal) }}</span></div>
        <div class="stat-desc"></div>
    </div>
    <div class="stat bg-accent w-auto rounded-2xl">
        <div class="stat-title">Total Hutang</div>
        <div class="stat-value">Rp <span class="">{{ format_decimal($hutang) }}</span></div>
        <div class="stat-desc"></div>
    </div>
</div>
<div class="rounded-2xl bg-accent p-4 my-5">
    <div class="overflow-x-auto">
        <table class="data-table table-zebra">
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
                        <td colspan="5" class="text-error text-center font-medium">Tidak ada Transaksi</td>
                    </tr>
                @else
                    @foreach ($customer->invoice as $item)
                    <tr>
                        <td>{{ $item->kode }}</td>
                        <td>Rp {{ number_format($item->total) }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td><div class="badge {{ $item->paid_at != null ? 'badge-secondary' : 'badge-error' }}">{{ $item->paid_at != null ? 'Lunas' : 'Belum Lunas' }}</div></td>
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
