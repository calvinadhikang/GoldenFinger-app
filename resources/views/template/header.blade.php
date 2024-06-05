<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Goldfinger Wheels Indonesia</title>
	<script src="https://kit.fontawesome.com/7ecee868f3.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ URL::asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
</head>

<body>
    @include('sweetalert::alert')
    <?php
    $user = Session::get('user');
    ?>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-side">
            <label for="my-drawer-2" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 min-h-screen bg-accent text-base-content overflow-y-visible flex flex-col">
                <!-- Sidebar content here -->
                <a href="{{ url('/profile') }}" class="rounded-lg drop-shadow-lg bg-primary px-4 py-5 mb-5 hover:bg-opacity-80">
                    <h1 class="text-2xl font-bold text-base-100">{{ $user->nama }}</h1>
                    <p class="text-base-100 font-semibold">{{ $user->role }}</p>
                </a>

                @if ($user->role == 'Teknisi')
                    <li><a href="{{ url('/vservice') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-boxes-stacked me-2 w-6"></i>
                            Service Vulkanisir
                        </div>
                    </a></li>
                @else
                    <li><a href="{{ url('/dashboard') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-gauge-high me-2 w-6"></i>
                            Dashboard
                        </div>
                    </a></li>

                    <h3 class="text-lg font-semibold mt-4">Master</h3>
                    <li><a href="{{ url('/barang') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-box-open me-2 w-6"></i>
                            Barang
                        </div>
                    </a></li>
                    <li><a href="{{ url('/kategori') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-list me-2 w-6"></i>
                            Kategori
                        </div>
                    </a></li>
                    <li><a href="{{ url('/customer') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-user me-2 w-6"></i>
                            Customer
                        </div>
                    </a></li>
                    <li><a href="{{ url('/karyawan') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-id-badge me-2 w-6"></i>
                            Karyawan
                        </div>
                    </a></li>
                    <li><a href="{{ url('/vendors') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-store me-2 w-6"></i>
                            Vendor
                        </div>
                    </a></li>
                    <li><a href="{{ url('/machine') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-boxes-stacked me-2 w-6"></i>
                            Mesin Vulkanisir
                        </div>
                    </a></li>
                    @if ($user->role == "Stakeholder")
                    <h3 class="text-lg font-semibold mt-4">Pemegang Saham</h3>
                    <li><a href="{{ url('/shares') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-users me-2 w-6"></i>
                            Porsi Saham
                        </div>
                    </a></li>
                    @endif

                    <h3 class="text-lg font-semibold mt-4">Operasional</h3>
                    <li><a href="{{ url('/arap') }}">
                        <div class="flex items-center justify-between">
                            <i class="fa-solid fa-scale-balanced me-2 w-6"></i>
                            AR AP Handle
                        </div>
                    </a></li>
                    <li><a href="{{ url('/invoice') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-dollar-sign me-2 w-6"></i>
                            Penjualan / Invoice
                        </div>
                    </a></li>
                    <li><a href="{{ url('/po') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-cart-shopping me-2 w-6"></i>
                            Pembelian / PO
                        </div>
                    </a></li>
                    <li><a href="{{ url('/cost') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-tags me-2 w-6"></i>
                            Pengeluaran / Cost
                        </div>
                    </a></li>
                    <li><a href="{{ url('/vservice') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-boxes-stacked me-2 w-6"></i>
                            Service Vulkanisir
                        </div>
                    </a></li>
                    <li><a href="{{ url('/penawaran') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-layer-group me-2 w-6"></i>
                            Penawaran
                        </div>
                    </a></li>

                    <li class="mt-4 -ms-4">
                        <details>
                            <summary class="font-semibold text-lg">Laporan</summary>
                            <ul class="ms-4">
                                <li><a href="{{ url('/laporan/cost') }}">Lap. Operational Cost</a></li>
                                <li><a href="{{ url('/laporan/stok') }}">Lap. Stok</a></li>
                                <li><a href="{{ url('/laporan/piutang') }}">Lap. Piutang</a></li>
                                <li><a href="{{ url('/laporan/hutang') }}">Lap. Hutang</a></li>
                                <li><a href="{{ url('/laporan/pendapatan') }}">Lap. Pendapatan</a></li>
                                <li><a href="{{ url('/laporan/pembelian') }}">Lap. Pembelian</a></li>
                                <li><a href="{{ url('/laporan/dividen') }}">Lap. Dividen</a></li>
                                <li><a href="{{ url('/laporan/penjualan') }}">Lap. Penjualan</a></li>
                                <li><a href="{{ url('/laporan/laba_bersih') }}">Lap. Laba Bersih</a></li>
                                <li><a href="{{ url('/laporan/laba_rugi') }}">Lap. Laba Rugi</a></li>
                            </ul>
                        </details>
                    </li>

                    <h3 class="mt-4 text-lg font-semibold">Lainnya</h3>
                    <li><a href="{{ url('/settings') }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-gear me-2 w-6"></i>
                            Pengaturan
                        </div>
                    </a></li>
                @endif

                <div class="flex-grow h-10 mt-10 md:m-0"></div>
                <a href="{{ url('/logout') }}" class="no-underline w-full">
                    <div class="btn btn-error btn-md btn-block text-white mb-4 hover:bg-red-500 hover:border-red-500">Logout</div>
                </a>
            </ul>
        </div>
        <div class="drawer-content flex flex-col">
            <!-- Page content here -->
            <!-- Navbar -->
            <div class="w-full navbar bg-accent lg:invisible">
                <div class="flex-none lg:hidden">
                <label for="my-drawer-2" class="btn btn-square btn-ghost drawer-button lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </label>
                </div>
                <div class="flex-1 px-2 mx-2 prose">
                    {{-- NavBar Content --}}
                    <div class="flex-grow"></div>
                </div>
                <div class="flex-none hidden lg:block">
                <ul class="menu menu-horizontal">
                    <!-- Navbar menu content here -->
                    {{-- <li><a>Navbar Item 1</a></li>
                    <li><a>Navbar Item 2</a></li> --}}
                </ul>
                </div>
            </div>
            <!-- content here -->
            <div class="px-2 pt-5 lg:pt-0 flex-wrap md:px-10 flex items-center w-full justify-center">
                <div class="lg:max-w-screen-2xl w-full">
                    @if ($errors->any())
                        <div class="alert alert-error my-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> --}}
<script>
    $(document).ready(function() {
        $(".harga").on("input", function() {
            // Remove commas and non-numeric characters from the input value
            let rawValue = $(this).val().replace(/[^0-9]/g, '');

            // Format the input value with thousand separators
            let formattedValue = Number(rawValue).toLocaleString();

            // Update the input value with the formatted value
            $(this).val(formattedValue);
        });

        let table = $('.data-table').DataTable({
            'order': []
        });
    });
</script>
</html>
