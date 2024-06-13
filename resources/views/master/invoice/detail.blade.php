@extends('template/header')

@section('content')
    <h1 class="text-2xl font-bold">Detail Invoice</h1>
    <div class="text-sm breadcrumbs mb-5 ">
        <ul>
            <li><a href="/invoice">Data Invoice</a></li>
            <li>Detail Invoice</li>
        </ul>
    </div>

    @if ($invoice->deleted_at)
        <h3 class="text-xl font-semibold text-secondary">Aktifkan Transaksi Invoice</h3>
        <div class="rounded-2xl bg-accent p-4 mt-5 mb-10">
            <p>Status invoice saat ini adalah <span class="text-error font-semibold">Tidak Aktif</span> <br>
                Untuk mengaktifkan kembali Invoice silahkan isi password dibawah dan tekan tombol</p>
            <form method="POST" action="{{ url("/invoice/detail/$invoice->id/restore") }}">
                @csrf
                <p class="text-sm mt-2">Password</p>
                <div class="flex items-center gap-x-2">
                    <input type="password" name="password" class="input input-secondary">
                    <button class="btn btn-secondary">Aktifkan Invoice</button>
                </div>
            </form>
        </div>
    @endif

    <div class="rounded-2xl bg-accent p-4 my-5">
        <div class="grid grid-cols-2">
            <div class="text-xl font-semibold">Kode Transaksi</div>
            <div class="text-right text-lg font-medium">{{ $invoice->kode }}</div>
            <div class="">Kode PO</div>
            <div class="text-right">{{ $invoice->po }}</div>
            <div class="divider"></div>
            <div class="divider"></div>
            <div class="">Total Harga</div>
            <div class="text-right">Rp {{ number_format($invoice->total) }}</div>
            <div class="">PPN ({{ $invoice->ppn }}%)</div>
            <div class="text-right">Rp {{ number_format($invoice->ppn_value) }}</div>
            <div class="text-xl font-semibold">Grand Total</div>
            <div class="text-right font-semibold text-xl text-primary">Rp {{ number_format($invoice->grand_total) }}</div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-5">
        <p class="text-xl font-semibold">Status Transaksi</p>
        <p class="px-2 py-1 border rounded-2xl-full bg-accent text-sm">{{ $statusText }}</p>
    </div>

    <div class="p-4 rounded-2xl bg-accent mb-5">
        <div class="grid grid-cols-2">
            @if ($invoice->status > 0)
                <p>Terkonfirmasi Pada</p>
                <p class="text-end">{{ date_format(new DateTime($invoice->confirmed_at), 'd M Y') }}</p>
                <p>Terkonfirmasi Oleh</p>
                <p class="text-end">{{ $confirmed_by->nama }}</p>
                @if ($invoice->paid_at)
                <p>Metode Pembayaran</p>
                <p class="text-end">{{ $invoice->paid_method }}</p>
                <p>Kode Pembayaran</p>
                <p class="text-end">{{ $invoice->paid_code }}</p>
                <p>Pembayaran Terkonfirmasi Oleh</p>
                <p class="text-end">{{ $paid_by->nama }}</p>
                @endif
            @elseif ($invoice->cancel_by != null)
                <p>Dibatalkan Karena</p>
                <p class="text-end">{{ $invoice->cancel_reason }}</p>
            @endif
        </div>
    </div>

    @if ($invoice->status == 0)
        <div class="p-4 rounded-2xl bg-accent">
            <p class="text-sm">Invoice perlu dikonfirmasi Admin. Pastikan stok barang mencukupi !</p>
            <form class="mt-5" method="POST" action="{{ url("/invoice/detail/$invoice->id/confirm") }}">
                @csrf
                <p class="w-full text-sm">Password User Admin: </p>
                <div class="flex items-center gap-x-2 mt-2">
                    <input type="password" name="password" class="input  ">
                    <button class="btn btn-primary">Konfirmasi Pesanan!</button>
                </div>
            </form>
            <div class="divider"></div>
            <p class="text-sm">Bila pesanan tidak dapat dipenuhi, tekan tombol dibawah!</p>
            <button class="btn btn-error btn-outline mt-2" onclick="modal_cancel.showModal()">Pesanan, Tidak dapat
                dibuat</button>
        </div>
    @elseif ($invoice->status == 1 || $invoice->status == 2)
        <div class="p-4 rounded-2xl bg-accent">
            @if (!$invoice->paid_at)
                <div class="text-red-200 bg-red-600 font-semibold text-xl text-center rounded-2xl p-3 mb-5">Belum Lunas</div>
            @else
                <div class="  bg-secondary font-semibold text-xl text-center rounded-2xl p-3">Lunas</div>
            @endif

            <div class="grid grid-cols-2 mt-2">
                <p>Tanggal Jatuh Tempo</p>
                <p class="text-right">{{ date_format(new DateTime($invoice->jatuh_tempo), 'd M Y') }}</p>
                <p>Tanggal Pembayaran</p>
                <p class="text-right {{ $invoice->paid_at == null ? 'text-error' : 'text-secondary' }}">
                    {{ $invoice->paid_at == null ? 'Belum Bayar' : date_format(new DateTime($invoice->paid_at), 'd M Y') }}
                </p>
            </div>
            @if (!$invoice->paid_at)
                <p class="text-right {{ $isOverdue ? "text-red-400" : "" }}">{{ $daysLeft }}</p>
            @endif

            @if ($invoice->paid_at == null && $invoice->deleted_at == null)
                <div class="divider"></div>
                <div class="grid grid-cols-2">
                    <div class="">
                        <h3 class="text-xl font-semibold">Pesanan Sudah Lunas ?</h3>
                        <p>Klik tombol disamping bila pesanan sudah lunas</p>
                    </div>
                    <button class="btn btn-primary mt-2" onclick="modal_pembayaran.showModal()">Pesanan, Sudah Lunas
                        !</button>
                </div>
            @endif
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
                <input type="text" class="input   w-full " value="{{ $invoice->customer->nama }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="email" class="input   w-full" value="{{ $invoice->customer->email }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" value="{{ $invoice->customer->alamat }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" value="{{ $invoice->customer->telp }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-city me-2"></i>Kota</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Kota..." class="input   w-full"
                    value="{{ $invoice->customer->kota }}" disabled />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-barcode me-2"></i>NPWP</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="001.002.003" class="input   w-full"
                    value="{{ $invoice->customer->NPWP }}" disabled />
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-file-lines me-2"></i>Nomor PO</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" value="{{ $invoice->po }}" disabled />
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
                @foreach ($invoice->details as $item)
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
                {{ number_format($invoice->total) }}</span></div>
    </div>

    @if ($invoice->komisi > 0)
        <h3 class="text-xl font-semibold">Komisi</h3>
        <div class="rounded-2xl bg-accent p-4 my-5">
            <div class="grid grid-cols-2">
                <p>Penerima Komisi </p>
                <p class="text-right text-lg font-semibold">{{ $invoice->contact_person }}</p>
                <p>Jumlah Komisi </p>
                <p class="text-right text-lg font-semibold">Rp {{ number_format($invoice->komisi) }}</p>
            </div>
            <div class="divider"></div>
            <div class="mt-5 grid grid-cols-2">
                <div class="">Grand Total</div>
                <div class="text-right">Rp {{ number_format($invoice->grand_total) }}</div>
                <div class="">Komisi</div>
                <div class="text-right">- Rp {{ number_format($invoice->komisi) }}</div>
                <div class="text-xl font-semibold">Total Pendapatan - Komisi</div>
                <div class="text-right font-semibold text-xl text-primary">Rp
                    {{ number_format($invoice->grand_total - $invoice->komisi) }}</div>
            </div>
        </div>
    @endif

    <h3 class="text-xl font-semibold">Buat Excel</h3>
    <div class="rounded-2xl bg-accent p-4 my-5">
        <div class="flex items-center gap-4">
            <a href="{{ url("invoice/detail/$invoice->id/dokumen/surat_jalan") }}">
                <button class="btn btn-success shadow-lg" name="type" value="invoice"><i
                        class="fa-solid fa-file-excel"></i>Buat Surat Jalan !</button>
            </a>
            <a href="{{ url("invoice/detail/$invoice->id/dokumen/invoice") }}">
                <button class="btn btn-success shadow-lg"><i class="fa-solid fa-file-excel"></i>Buat Invoice !</button>
            </a>
            {{-- <a href="{{ url("invoice/detail/$invoice->id/dokumen/tanda_terima") }}">
                <button class="btn btn-success shadow-lg"><i class="fa-solid fa-file-excel"></i>Buat Tanda Terima !</button>
            </a> --}}
        </div>
    </div>

    <h3 class="text-xl font-semibold">Buat PDF</h3>
    <div class="rounded-2xl bg-accent p-4 my-5">
        <div class="flex gap-4 items-center">
            <a href="{{ url("/invoice/detail/$invoice->id/pdf/surat_jalan") }}"><button class="btn btn-secondary"><i class="fa-solid fa-file-pdf"></i>Buat Surat Jalan !</button></a>
            <a href="{{ url("/invoice/detail/$invoice->id/pdf/invoice") }}"><button class="btn btn-secondary"><i class="fa-solid fa-file-pdf"></i>Buat Invoice !</button></a>
            <a href="{{ url("/invoice/detail/$invoice->id/pdf/tanda_terima") }}"><button class="btn btn-secondary"><i class="fa-solid fa-file-pdf"></i>Buat Tanda Terima !</button></a>
            <a href="{{ url("/invoice/detail/$invoice->id/pdf/faktur_pajak") }}"><button class="btn btn-secondary"><i class="fa-solid fa-file-pdf"></i>Buat Faktur Pajak !</button></a>
        </div>
    </div>

    @if (!$invoice->deleted_at)
        <h3 class="text-xl font-semibold text-error">Hapus Transaksi Invoice</h3>
        <div class="rounded-2xl bg-accent p-4 my-5 text-error">
            <p>Untuk menghapus transaksi Invoice, masukan password dan tekan tombol dibawah</p>
            <form method="POST" action="{{ url("/invoice/detail/$invoice->id/delete") }}">
                @csrf
                <p class="text-sm mt-2">Password</p>
                <div class="flex items-center gap-x-2">
                    <input type="password" name="password" class="input input-error">
                    <button class="btn btn-error">Hapus Invoice</button>
                </div>
            </form>
        </div>
    @endif



    <dialog id="modal_pembayaran" class="modal">
        <div class="modal-box bg-slate-700  ">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg">Pelunasan Pesanan</h3>
            <p class="py-4">Pastikan kembali bahwa pesanan sudah dibayar oleh customer. <br> Bila sudah yakin, tekan
                tombol dibawah</p>
            <div>
                <form method="POST" action="{{ url('/invoice/finish') }}">
                    @csrf
                    <p class="mb-2 text-sm">Metode Pembayaran</p>
                    <select name="payment_method" class="select w-full" required>
                        <option value="" disabled selected>Pilih Metode Pembayaran</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>

                    <div class="my-2 flex justify-between text-sm">
                        <p>Kode Pembayaran</p>
                        <p>Isi dengan "-" bila Cash</p>
                    </div>
                    <input type="text" name="payment_code" class="input w-full" required>

                    <div class="divider"></div>

                    <p class="mb-2 text-sm">Masukan password anda : </p>
                    <input type="password" name="password" class="input input-primary w-full" required>

                    <button class="btn btn-primary mt-5" name="id" value="{{ $invoice->id }}">Ya, Sudah Lunas
                        !</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="modal_cancel" class="modal">
        <div class="modal-box bg-slate-700  ">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg">Pembatalan Konfirmasi Pesanan</h3>
            <p class="py-4">Dengan mengisi form dibawah maka,<br> Pesanan akan dibatalkan dan di-informasikan kepada
                customer.</p>
            <div>
                <form method="POST" action="{{ url('/invoice/cancel') }}">
                    @csrf
                    <p class="mt-2">Alasan Pembatalan</p>
                    <input type="text" name="cancel_reason" class="input w-full" required>

                    <div class="divider"></div>

                    <p class="mb-2 text-sm">Masukan password anda : </p>
                    <input type="password" name="password" class="input input-error w-full" required>

                    <button class="btn btn-error mt-5" name="id" value="{{ $invoice->id }}">Batalkan
                        Pesanan!</button>
                </form>
            </div>
        </div>
    </dialog>
@endsection
