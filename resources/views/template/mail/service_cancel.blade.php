<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Oops, Ada sedikit masalah..</h1>
    <h2>Service kamu ada yang dibatalkan.</h2>
    <p>Service <b>{{ $service->nama }}</b> dibatalkan karena: </p>
    <p><b>{{ $service->cancel_reason }}</b></p>
    <br>
    <p>Jangan lupa untuk mengambil ban milikmu di toko ya!</p>
</body>
</html>
