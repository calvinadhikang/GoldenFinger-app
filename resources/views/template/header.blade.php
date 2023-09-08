<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
	<script src="https://kit.fontawesome.com/7ecee868f3.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ URL::asset('css/datatable.css') }}" />
</head>

<body>
    @include('sweetalert::alert')
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-side">
            <label for="my-drawer-2" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 h-full bg-base-200 text-base-content">
                <!-- Sidebar content here -->
                <div class="rounded-lg drop-shadow-lg bg-accent p-4 mb-5">
                    <h1 class="text-xl font-semibold">Calvin Adhikang</h1>
                    <p>Admin</p>
                </div>

                <li><a href="{{ url('/dashboard') }}">
                    <div class="flex items-center">
                        <i class="fa-solid fa-gauge-high me-2 w-6"></i>
                        Dashboard
                    </div>
                </a></li>
                <div class="prose">
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

                <div class="prose mt-8">
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
                <div class="flex-grow"></div>
                <a href="{{ url('/logout') }}" class="no-underline w-full">
                    <div class="btn btn-error btn-sm btn-block mb-4">Logout</div>
                </a>
            </ul>
        </div>
        <div class="drawer-content flex flex-col">
            <!-- Page content here -->
            <!-- Navbar -->
            <div class="w-full navbar bg-primary lg:invisible">
                <div class="flex-none lg:hidden">
                <label for="my-drawer-2" class="btn btn-square btn-ghost drawer-button lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </label>
                </div>
                <div class="flex-1 px-2 mx-2 prose">
                    {{-- NavBar Content --}}
                    <div class="flex-grow"></div>
                    <a href="{{ url('/logout') }}" class="no-underline"><div class="text-white bg-red-500 px-4 py-1 rounded-lg hover:shadow-xl hover:font-semibold">Logout</div></a>
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
            <div class="px-2 pt-10 lg:pt-0 flex-wrap md:px-10">
                @yield('content')
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
</html>
