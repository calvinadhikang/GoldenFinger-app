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
    <div class="rounded-2xl bg-accent p-4 mt-5 mb-10">
        <div class="rounded-lg text-center text-lg font-semibold bg-red-300 py-3 mb-3">Invoice Tidak Aktif</div>
        <p>Status invoice saat ini adalah <span class="text-error font-semibold">Tidak Aktif</span> <br>
            Untuk mengaktifkan kembali Invoice silahkan isi password dibawah dan tekan tombol</p>
        <form method="POST" action="{{ url("/invoice/detail/$invoice->id/restore") }}">
            @csrf
            <p class="text-sm mt-2">Password</p>
            <div class="flex items-center gap-x-2">
                <input type="password" name="password" class="input">
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
            <div class="font-semibold">Grand Total</div>
            <div class="text-right font-semibold text-lg">Rp {{ number_format($invoice->grand_total) }}</div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-5">
        <p class="text-xl font-semibold">Status Transaksi</p>
        <p class="px-3 py-2 rounded-xl bg-accent text-sm">{{ $statusText }}</p>
    </div>

    <div class="p-4 rounded-2xl bg-accent mb-5">
        @if ($invoice->cancel_by == null)
            <div class="grid grid-cols-2">
                <p>Terkonfirmasi Pada</p>
                <p class="text-end">{{ date_format(new DateTime($invoice->confirmed_at), 'd M Y') }}</p>
                <p>Terkonfirmasi Oleh</p>
                <p class="text-end">{{ $confirmed_by->nama ?? "Belum Terkonfirmasi" }}</p>
                @if ($invoice->confirmed_by != null)
                    <p>Tanggal Jatuh Tempo</p>
                    <p class="text-right">{{ date_format(new DateTime($invoice->jatuh_tempo), 'd M Y') }}</p>
                    <p>Status Pembayaran</p>
                    <p class="text-right {{ $invoice->paid_at == null ? 'text-error' : '' }}">
                        {{ $invoice->paid_at == null ? 'Belum Lunas' : 'Lunas' }}
                    </p>
                @else
                @endif
            </div>
        @elseif ($invoice->cancel_by != null)
            <p class="font-medium">Dibatalkan Karena</p>
            <p>{{ $invoice->cancel_reason }}</p>
        @endif
    </div>

    @if ($invoice->status == 0)
        {{-- Section Konfirmasi dan Pembatalan --}}
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
            <div class="flex justify-between items-center">
                <div class="">
                    <div class="font-medium text-lg">Data Pembayaran</div>
                    <div class="grid grid-cols-2 gap-x-5">
                        <div class="">Total Diterima</div>
                        <div class="">Rp {{ number_format($invoice->paid_total) }}</div>
                        <div class="">Kekurangan</div>
                        <div class="text-error">Rp {{ number_format($invoice->grand_total - $invoice->paid_total) }}</div>
                    </div>
                </div>
                <button class="btn btn-primary" onclick="modal_pembayaran.showModal()">Tambah Data Pembayaran</button>
            </div>
            <table class="table table-lg table-zebra mt-5">
                <thead>
                    <tr>
                        <th><div class="font-bold">Metode Pembayaran</div></th>
                        <th><div class="font-bold">Kode Pembayaran</div></th>
                        <th><div class="font-bold">Total</div></th>
                        <th><div class="font-bold">Dikonfirmasi Oleh</div></th>
                        <th><div class="font-bold">Tanggal</div></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data_pembayaran) <= 0)
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data pembayaran</td>
                        </tr>
                    @else
                        @foreach ($data_pembayaran as $pembayaran)
                            <tr>
                                <td>{{ $pembayaran->method }}</td>
                                <td>{{ $pembayaran->code }}</td>
                                <td>Rp {{ number_format($pembayaran->total) }}</td>
                                <td>{{ $pembayaran->karyawan->nama }}</td>
                                <td>{{ date_format($pembayaran->created_at, 'd M Y') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
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
                <input type="text" class="input w-full " value="{{ $invoice->customer->nama }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="email" class="input w-full" value="{{ $invoice->customer->email }}"
                    disabled />
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input w-full" value="{{ $invoice->customer->alamat }}"
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
                    <th><h3 class="font-bold">Part Number</h3></th>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Tipe</h3></th>
                    <th><h3 class="font-bold">Harga</h3></th>
                    <th><h3 class="font-bold">Jumlah</h3></th>
                    <th><h3 class="font-bold">Subtotal</h3></th>
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
        <h3 class="text-xl font-semibold">Hapus Transaksi Invoice</h3>
        <div class="rounded-2xl bg-red-300 p-4 my-5">
            <p>Untuk menghapus transaksi Invoice, masukan password dan tekan tombol dibawah</p>
            <form method="POST" action="{{ url("/invoice/detail/$invoice->id/delete") }}">
                @csrf
                <p class="text-sm mt-2">Password</p>
                <div class="flex items-center gap-x-2">
                    <input type="password" name="password" class="input">
                    <button class="btn btn-error">Hapus Invoice</button>
                </div>
            </form>
        </div>
    @endif

    <dialog id="modal_pembayaran" class="modal">
        <div class="modal-box bg-accent">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg">Pembayaran Invoice</h3>
            <div role="alert" class="alert alert-warning my-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <span>Pastikan kembali bahwa pesanan sudah dibayar oleh customer. <br> Bila sudah yakin, tekan
                    tombol dibawah</span>
            </div>
            <div>
                <form method="POST" action="{{ url('/invoice/create/payment') }}">
                    @csrf
                    <p class="mb-2">Metode Pembayaran</p>
                    <select name="payment_method" class="select w-full" required>
                        <option value="" disabled selected>Pilih Metode Pembayaran</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>

                    <div class="my-2 flex justify-between">
                        <p>Kode Pembayaran</p>
                        <p>Isi dengan "-" bila Cash</p>
                    </div>
                    <input type="text" name="payment_code" class="input w-full" required>

                    <div class="my-2 flex justify-between">
                        <p>Nominal Pembayaran</p>
                        <p></p>
                    </div>
                    <input type="text" name="payment_nominal" class="input w-full harga" required>

                    <div class="divider"></div>

                    <p class="mb-2">Masukan password anda : </p>
                    <input type="password" name="password" class="input w-full" required>

                    <button class="btn btn-primary mt-5" name="id" value="{{ $invoice->id }}">Ya, Sudah Lunas
                        !</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="modal_cancel" class="modal">
        <div class="modal-box bg-accent">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg">Pembatalan Konfirmasi Pesanan</h3>
            <div role="alert" class="alert alert-warning my-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <span>Pesanan yang dibatalkan tidak dapat diaktifkan kembali.</span>
            </div>
            <div>
                <form method="POST" action="{{ url('/invoice/cancel') }}">
                    @csrf
                    <div class="space-y-3">
                        <p class="">Alasan Pembatalan</p>
                        <input type="text" name="cancel_reason" class="input w-full" required>
                        <p class="">Masukan password anda : </p>
                        <input type="password" name="password" class="input w-full" required>
                    </div>

                    <button class="btn btn-error mt-5" name="id" value="{{ $invoice->id }}">Batalkan Pesanan!</button>
                </form>
            </div>
        </div>
    </dialog>
@endsection
