@extends('template/header')

@section('content')
<h1 class="text-3xl font-bold mb-5">Operational Cost</h1>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url('cost/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table id="table">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Deskripsi</h3></th>
                    <th><h3 class="font-bold">Total</h3></th>
                    <th><h3 class="font-bold">Tanggal</h3></th>
                    <th><h3 class="font-bold">Hapus</h3></th>
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
                        <td>Rp {{ number_format($item->total) }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <button onclick="my_modal_3.showModal()" class="btn-modal" id-cost="{{ $item->id }}" value="{{ $item->deskripsi }}"><i class="fa-solid fa-circle-minus text-base hover:text-red-600"></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>

<dialog id="my_modal_3" class="modal">
    <div class="modal-box bg-slate-300">
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
