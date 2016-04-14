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