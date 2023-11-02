<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <tr>
        <th>Part</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Batas</th>
    </tr>
    @foreach ($data as $item)
    <tr>
        <td>{{ $item->part }}</td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->harga }}</td>
        <td>{{ $item->stok }}</td>
        <td>{{ $item->batas }}</td>
    </tr>
    @endforeach
</body>
</html>
