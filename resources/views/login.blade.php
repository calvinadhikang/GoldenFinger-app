<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('sweetalert::alert')
    <section class="h-screen w-screen grid place-items-center p-8">
        <div class="w-full bg-accent rounded-lg shadow mx-8 md:w-1/2">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-3xl font-bold text-primary text-center">
                    Admin Gold Finger
                </h1>
                <form class="space-y-4 md:space-y-6" method="post">
                    @csrf
                    <div>
                        <label for="username" class="block mb-2 text-lg font-medium">Username</label>
                        <input type="text" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-lg rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-lg font-medium">Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </form>
            </div>
        </div>
      </section>
</body>
</html>
