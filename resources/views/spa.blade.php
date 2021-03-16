<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Suptodo</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>

<body>
    <div id="app"></div>
    <script src="https://kit.fontawesome.com/4f3834f0ec.js" crossorigin="anonymous"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>