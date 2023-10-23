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
    $role = "Admin";
    if ($user->role == 1) {
        $role = "Stakeholder";
    }
    ?>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-side">
            <label for="my-drawer-2" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 min-h-screen bg-accent text-base-content overflow-y-visible flex flex-col">
                <!-- Sidebar content here -->
                <div class="rounded-lg drop-shadow-lg bg-primary px-4 py-5 mb-5">
                    <h1 class="text-2xl font-bold text-base-100">{{ $user->nama }}</h1>
                    <p class="text-base-100 font-semibold">{{ $role }}</p>
                </div>

                <li><a href="{{ url('/dashboard') }}">
                    <div class="flex items-center">
                        <i class="fa-solid fa-gauge-high me-2 w-6"></i>
                        Dashboard
                    </div>
                </a></li>
                <div class="prose mt-4">
                    <h3>Master</h3>
                </div>
                <li><a href="{{ url('/barang') }}">
                    <div class="flex items-center">
                        <i class="fa-solid fa-box-open me-2 w-6"></i>
                        Barang
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
                <li><a>
                    <div class="flex items-center">
                        <i class="fa-solid fa-users me-2 w-6"></i>
                        Pemegang Saham
                    </div>
                </a></li>

                <div class="prose mt-4">
                    <h3>Operasional</h3>
                </div>
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

                <li class="mt-4 -ms-4">
                    <details>
                        <summary class="font-medium text-xl">Laporan</summary>
                        <ul class="ms-4">
                            <li><a>Lap. Stok</a></li>
                            <li><a>Lap. Penjualan</a></li>
                            <li><a>Lap. Pendapatan</a></li>
                        </ul>
                    </details>
                </li>

                <h3 class="mt-4 text-xl font-medium">Lainnya</h3>
                <li><a href="{{ url('/settings') }}">
                    <div class="flex items-center">
                        <i class="fa-solid fa-gear me-2 w-6"></i>
                        Pengaturan
                    </div>
                </a></li>

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
            <div class="px-2 pt-10 lg:pt-0 flex-wrap md:px-10 flex items-center w-full justify-center">
                <div class="lg:max-w-5xl w-full">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
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

        let table = new DataTable('#table');
    });
</script>
</html>
