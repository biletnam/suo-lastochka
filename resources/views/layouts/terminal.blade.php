<!DOCTYPE html>
<html lang="en">
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
    <div class="hidden-print">

    @include('terminals.dlg_get_a_check')

    @include('terminals.dlg_no_record')

    <div id="suo-page">
        
@yield('content')

    </div>
    </div>

    <div class="visible-print-block">
        <div class="suo-check">
            <div id="suo-check-title">Поликлиника</div>
            <div id="suo-check-number"></div>
            <div id="suo-check-operator"></div>
            <div id="suo-check-room-number"></div>
            <div id="suo-check-room-description"></div>
            <div id="suo-check-start-date"></div>
            <div id="suo-check-position"></div>
            <div id="suo-check-get-time"></div>
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    @stack('show')
    <script src="/js/terminal.js"></script>
</body>
</html>
