@extends('layouts.terminal')

@section('content')
    <div class="hidden-print">

        @include('terminals.dlg_get_a_check')

        @include('terminals.dlg_no_record')

        @include('terminals.dlg_record')

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
    <script>
        var terminal = {!! $terminal !!};

        $(function() {
            init();
            page(1);
        });
</script>
@endpush