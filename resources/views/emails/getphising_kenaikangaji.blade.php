<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>

    <p style="font-family: 'Times New Roman', Times, serif; font-size:12pt">Dear {{ $PhisingTarget->name_target }} ,</p>

    <br>

    <p style="font-family: Georgia, 'Times New Roman', Times, serif; font-size:12pt">
        We assessed the 2024 pay structure as set out in the terms of employment and found that your pay date will be moved forward to the 23rd of each month starting February 2024.
        Follow the Login link to access your payroll information into HRIS : <a href="{{ url('/') }}">https://hris.sl-maritime.com/</a>
    </p>
    <br><br>

    <p style="font-family: 'Times New Roman', Times, serif; font-size:12pt">Regards,</p>
    <p style="font-family: 'Times New Roman', Times, serif; font-size:12pt">Payroll Dept.</p>



    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
</body>

</html>


{{-- We assessed the 2024 pay structure as set out in the terms of employment and found that your pay date will be moved forward to the 23rd of each month starting February 2024.

Follow the Login link to access your payroll information into HRIS --}}
