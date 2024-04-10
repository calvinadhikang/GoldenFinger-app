@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold mb-5">Operational Cost</h1>

{{-- <h1 class="font-medium mb-3">Filter Data</h1>
<div class="p-4 rounded shadow bg-accent mb-5">
    <form method="GET" class="flex gap-5">
        <input type="month" class="input input-primary flex-grow bg-white text-black" name="month" value="{{ $filter }}">
        <button class="btn btn-secondary">Search</button>
    </form>
</div> --}}

<h1 class="font-medium mb-3">Pengeluaran <span class="badge badge-secondary">{{ $filterReadable }}</span></h1>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url('cost/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Deskripsi</h3></th>
                    <th><h3 class="font-bold">Total</h3></th>
                    <th><h3 class="font-bold">Tanggal</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            @if (count($data) <= 0)
                <tr>
                    <th class="text-error text-lg" colspan="5">Tidak ada data...</th>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->deskripsi }}</td>
                        <td>Rp {{ format_decimal($item->total) }}</td>
                        <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                        <td>
                            <button onclick="my_modal_3.showModal()" class="btn-modal" id-cost="{{ $item->id }}" value="{{ $item->deskripsi }}"><i class="fa-solid fa-trash text-red-600 hover:text-red-400"></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>

<dialog id="my_modal_3" class="modal">
    <div class="modal-box bg-slate-700 text-white">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg">Konfirmasi Hapus Operational Cost !</h3>
        <p class="py-4">Yakin ingin hapus operational cost <br><span class="font-medium" id="cost-detail"></span></p>
        <div class="flex gap-3">
            <form method="dialog">
                <button class="btn btn-primary" type="">Tidak</button>
            </form>
            <form method="POST" action="{{ url("/cost/remove") }}">
                @csrf
                <button class="btn btn-ghost hover:btn-error" name="id" id="btn-remove">Ya, Hapus</button>
            </form>
        </div>
    </div>
</dialog>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    $(document).ready(
        $('.btn-modal').on('click', function (e) {
            $('#cost-detail').html($(this).val())
            $('#btn-remove').val($(this).attr('id-cost'))
        })
    )
</script>

@endsection
