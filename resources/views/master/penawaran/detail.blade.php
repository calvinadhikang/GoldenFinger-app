@extends('template/header')

@section('content')
    <h1 class="  text-2xl font-bold">Detail Penawaran</h1>
    <div class="text-sm breadcrumbs mb-5  ">
        <ul>
            <li><a href="/penawaran">Data Penawaran</a></li>
            <li>Detail Penawaran</li>
        </ul>
    </div>

    <div class="prose mt-5">
        <h3>Informasi Penawaran</h3>
    </div>
    <div class="rounded-2xl bg-accent p-4 my-5">
        <div class="grid grid-cols-2">
            <p>Status Transaksi</p>
            <p class="text-right">{{ $penawaran->status_text }}</p>
            <p>Total</p>
            <p class="text-right">Rp {{ number_format($penawaran->total) }}</p>
            <p>PPN {{ $penawaran->ppn }}%</p>
            <p class="text-right">Rp {{ number_format($penawaran->ppn_value) }}</p>
            <p>Grand Total</p>
            <p class="text-right">Rp {{ number_format($penawaran->grand_total) }}</p>
        </div>
    </div>
    @if ($penawaran->status == -1)
        <div class="rounded-2xl bg-accent p-4 my-5">
            <div class="grid grid-cols-2">
                <p>Tanggal Penolakan</p>
                <p class="text-right">{{ $penawaran->canceled_at }}</p>
            </div>
            <p class="my-2">Alasan Penolakan</p>
            <textarea class="textarea w-full" disabled>{{ $penawaran->cancel_reason }}</textarea>
        </div>
    @elseif ($penawaran->status == 1)
        <div class="rounded-2xl bg-accent p-4 my-5">
            <div class="grid grid-cols-2">
                <p>Tanggal Konfirmasi</p>
                <p class="text-right">{{ $penawaran->confirmed_at }}</p>
                <p>Invoice</p>
                <a class="text-right" href="{{ url('/invoice/detail/'.$penawaran->confirmed_invoice) }}"><button class="btn btn-xs btn-secondary">Lihat Invoice</button></a>
            </div>
        </div>
    @endif

    <div class="prose mt-5">
        <h3>Informasi Customer</h3>
    </div>
    <div class="rounded-2xl bg-accent p-4 my-5">
        <div class="flex flex-wrap">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full " value="{{ $penawaran->customer->nama }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="email" class="input   w-full" value="{{ $penawaran->customer->email }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" value="{{ $penawaran->customer->alamat }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" value="{{ $penawaran->customer->telp }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-city me-2"></i>Kota</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Kota..." class="input   w-full"
                    value="{{ $penawaran->customer->kota }}" disabled />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-barcode me-2"></i>NPWP</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="001.002.003" class="input   w-full"
                    value="{{ $penawaran->customer->NPWP }}" disabled />
            </div>
        </div>
    </div>

    <div class="prose">
        <h3>Data Pesanan</h3>
    </div>
    <div class="rounded-2xl bg-accent p-4 my-5">
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th>
                        <h3 class="font-bold">Part Number</h3>
                    </th>
                    <th>
                        <h3 class="font-bold">Nama</h3>
                    </th>
                    <th>
                        <h3 class="font-bold">Tipe</h3>
                    </th>
                    <th>
                        <h3 class="font-bold">Harga</h3>
                    </th>
                    <th>
                        <h3 class="font-bold">Jumlah</h3>
                    </th>
                    <th>
                        <h3 class="font-bold">Subtotal</h3>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penawaran->details as $item)
                    <tr>
                        <td>{{ $item->part }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->type }}</td>
                        <td>Rp {{ number_format($item->harga) }}</td>
                        <td>{{ number_format($item->qty) }}</td>
                        <td>Rp {{ number_format($item->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right w-full mt-10">Total Pesanan : <span class="">Rp
                {{ number_format($penawaran->total) }}</span></div>
    </div>

    @if ($penawaran->status == 0)
        <h3 class="text-xl font-semibold">Aksi</h3>
        <div class="rounded-2xl bg-accent p-4 my-5">
            <p>Untuk mengkonfirmasi penawaran, masukan password anda</p>
            <form method="POST" action="{{ url("/penawaran/detail/$penawaran->id/confirm") }}">
                @csrf
                <label class="text-sm mt-2">Password</label>
                <div class="flex items-center gap-x-2">
                    <input type="password" name="password" class="input" placeholder="Password" required>
                    <button class="btn btn-primary">Konfirmasi Penawaran</button>
                </div>
            </form>
            <div class="divider"></div>
            <p>Untuk menolak penawaran, masukan password anda dan alasan penolakan</p>
            <form method="POST" action="{{ url("/penawaran/detail/$penawaran->id/cancel") }}">
                @csrf
                <p class="text-sm mt-2">Alasan Penolakan</p>
                <textarea name="cancel_reason" class="textarea w-full" placeholder="Alasan penolakan" required></textarea>
                <p class="text-sm mt-2">Password</p>
                <div class="flex items-center gap-x-2">
                    <input type="password" name="password" class="input input-error" required>
                    <button class="btn btn-error">Tolak Penawaran</button>
                </div>
            </form>
        </div>
    @endif
@endsection
