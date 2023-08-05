@extends('template/header')

@section('content')
<div class="flex items-center mb-10">
    <div class="grow m-auto">
        <div class="">
            <h1 class="text-4xl font-extrabold">Operational Cost</h1>
        </div>
    </div>
</div>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url('cost/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Deskripsi</h3></th>
                    <th class="prose"><h3 class="font-bold">Total</h3></th>
                    <th class="prose"><h3 class="font-bold">Tanggal</h3></th>
                    <th class="prose"><h3 class="font-bold">Aksi</h3></th>
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
                            <form method="POST" action="{{ url("/cost/remove/$item->id") }}">
                                @csrf
                                <button><i class="fa-solid fa-circle-minus text-base hover:text-red-600"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
