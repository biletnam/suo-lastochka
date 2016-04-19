<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Электронная очередь - Терминал</title>

    <!-- Fonts -->
    <link href="/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/terminal.css" rel="stylesheet">
    
</head>
<body id="app-layout">
        
@yield('content')

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    @stack('dlg-record')
    @stack('dlg-record-by-time')
    @stack('show')

    <script src="/js/terminal.js"></script>
</body>
</html>
