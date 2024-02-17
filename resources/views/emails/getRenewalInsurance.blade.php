<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


    <title>sl-maritime.com</title>
</head>

<body>
    {{-- <h1>{{ $mailData['title'] }}</h1>
    <p>{{ $mailData['body'] }}</p> --}}


    <p>Silahkan klik tombol link di bawah ini dan update status dalam kurun waktu {{ $mailData['countdown'] }} hari. Jika tidak ada tindakan
        maka status akan berubah menjadi <b>Expired</b></p>

    <h1>Thank you</h1>
    <br>
    <a href="{{ url('/Insurance/RenewalMonitoring') }}"><button style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 3px; text-decoration: none; display: inline-block; font-size: 16px;">Click me</button></a>
    {{-- <button style="background-color: #eb0a0a; color: #fff; padding: 10px 20px; border: none; border-radius: 3px; text-decoration: none; display: inline-block; font-size: 16px;">Click me</button> --}}
    <br>





    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
</body>

</html>
