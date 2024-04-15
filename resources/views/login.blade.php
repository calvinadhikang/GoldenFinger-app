<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Gold Finger Wheels</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('sweetalert::alert')
    <section class="h-screen w-screen grid place-items-center p-8">
        <div class="w-full bg-accent rounded-lg shadow mx-8 md:w-1/2">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <div class="">
                    <h1 class="text-3xl font-bold text-center">Admin Login</h1>
                    <p class="text-sm text-center text-slate-400">Goldfinger Wheels Indonesia</p>
                </div>
                <form class="space-y-4 md:space-y-6" method="post">
                    @csrf
                    <div>
                        <label for="username" class="block mb-2 text-lg font-medium">Username</label>
                        <input type="text" name="username" class="input w-full" placeholder="name@company.com">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-lg font-medium">Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="input w-full">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </form>
            </div>
        </div>
      </section>
</body>
</html>
