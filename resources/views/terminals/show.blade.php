@extends('layouts.terminal')

@section('content')
    <div class="hidden-print">

        @include('terminals.dialogs.get_a_check')

        @include('terminals.dialogs.no_record')

        @include('terminals.dialogs.select_day')

        @include('terminals.dialogs.select_time')

        @include('terminals.dialogs.error')

        <div id="suo-page"></div>
    </div>

    <div class="visible-print-block">
        <div class="suo-check">
            <p id="suo-check-title">Поликлиника</p>
            <p id="suo-check-number"></p>
            <p id="suo-check-operator"></p>
            <p id="suo-check-room-number"></p>
            <p id="suo-check-room-description"></p>
            <p id="suo-check-start-date"></p>
            <p id="suo-check-position"></p>
            <p id="suo-check-get-time"></p>
        </div>
    </div>
@endsection

@push('show')
    @stack('dialogs')
    <script>
        var terminal = {!! $terminal !!};

        $(function() {
            init();
        });
    </script>
    <script src="/js/terminal.js"></script>
@endpush