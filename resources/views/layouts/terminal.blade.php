<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Терминал</title>

    <!-- Fonts -->
    <link href="/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/terminal.css" rel="stylesheet">
    
</head>
<body id="app-layout">
    <div class="onscreen">
    @include('terminals.dlg_get_a_check')

    @yield('content')
    </div>

    <div class="onprint">
        <div id="check_title">Поликлиника</div>
        <div id="check_number">111</div>
        <div id="check_operator"></div>
        <div id="check_room_number"></div>
        <div id="check_room_description">1</div>
        <div id="check_start_date"></div>
        <div id="check_position"></div>
        <div id="check_get_time"></div>
    </div>

    <!-- JavaScripts -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/terminal.js"></script>
</body>
</html>
