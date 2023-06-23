<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
	<script src="https://kit.fontawesome.com/7ecee868f3.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="navbar bg-primary">
        <div class="navbar-start">
            <div class="drawer drawer-mobile">
                <input id="my-drawer" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content">
                    <!-- Drawer content here -->
					<label for="my-drawer" class="btn btn-square btn-ghost drawer-button">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
					</label>
                </div>
                <div class="drawer-side">
                    <label for="my-drawer" class="drawer-overlay"></label>
                    <ul class="menu p-4 w-80 h-full bg-base-100 text-white relative">
                        <!-- Sidebar content here -->
                        <div class="rounded bg-primary p-4 mb-5">
                            <div class="prose">
                                <h1 class="mb-0">Calvin Adhikang</h1>
                                <p class="bg-secondary text-center rounded-lg"><b>Admin</b></p>
                            </div>
                        </div>
                        <div class="prose">
                            <h3>Master</h3>
                        </div>
                        <li><a>
                            <div class="flex items-center">
                                <i class="fa-solid fa-box-open me-2 w-6"></i>
                                Barang
                            </div>
                        </a></li>
                        <li><a>
                            <div class="flex items-center">
                                <i class="fa-solid fa-user me-2 w-6"></i>
                                Customer
                            </div>
                        </a></li>
                        <li><a>
                            <div class="flex items-center">
                                <i class="fa-solid fa-id-badge me-2 w-6"></i>
                                Karyawan
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
                        <li><a>
                            <div class="flex items-center">
                                <i class="fa-solid fa-dollar-sign me-2 w-6"></i>
                                Penjualan / Invoice
                            </div>
                        </a></li>
                        <li><a>
                            <div class="flex items-center">
                                <i class="fa-solid fa-cart-shopping me-2 w-6"></i>
                                Pembelian / PO
                            </div>
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="navbar-center prose">
            <h2 class="">Golden Finger</h2>
        </div>
        <div class="navbar-end">
            <button class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </button>
            <button class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
					</svg>
                    <span class="badge badge-xs badge-secondary indicator-item"></span>
                </div>
            </button>
        </div>
    </div>
	<div class="px-2 pt-10 flex-wrap md:px-10">
		@yield('content')
	</div>
</body>
</html>
