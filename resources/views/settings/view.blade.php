@extends('template.header')

@section('content')
<h1 class="text-3xl font-bold">Pengaturan</h1>
<div class="rounded p-4 shadow bg-accent mt-5">
    <div class="grid md:grid-cols-2 items-center">
        <div class="">
            <h1 class="text-2xl font-medium">PPN</h1>
            <p class="">Tentukan nilai PPN untuk Invoice dan PO</p>
        </div>
        <form action="" class="flex">
            <input type="text" class="input" value="{{ $ppn }}">
            <button class="ms-2 btn btn-primary">Save</button>
        </form>
    </div>
    <div class="divider"></div>
</div>
@endsection
