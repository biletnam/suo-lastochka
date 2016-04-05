<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Панель</title>

    <!-- Fonts -->
    <link href="/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/panel.css" rel="stylesheet">

</head>
<body id="app-layout">
    <audio muted="muted" id="audio">
        <source src="/audio/note.wav" type="audio/mpeg">
    </audio>
    <h1 class="center-block text-center">Электронная очередь</h1>

@yield('content')

    <!-- JavaScripts -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    @stack('roomids')
    <script src="/js/panel.js"></script>
</body>
</html>
