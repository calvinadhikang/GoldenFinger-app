@extends('template.header')
@section('content')
<h1 class="text-xl font-semibold mb-5">Configure Shares</h1>
<div class="bg-accent p-4 rounded-2xl mb-5">
    <form method="POST">
        @csrf
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th class="font-bold">Nama</th>
                    <th class="font-bold">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>
                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                            <input type="text" class="harga input input-primary" name="shares[]" value="{{ $item->shares }}">
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        <p class="text-gray-500 mt-5">Pastikan jumlah total shares adalah 100</p>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
