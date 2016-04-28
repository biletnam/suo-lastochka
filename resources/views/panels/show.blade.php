@extends('layouts.panel')

@section('content')
    <table class="table suo-table">
        <thead>
            <th class="suo-header">Кабинет</th>
            <th class="suo-header">Обслуживается</th>
            <th class="suo-header">Следующий</th>
        </thead>
        <tbody>
            @each('panels.table.room', $rooms, 'room')
        </tbody>
    </table>
@endsection

@push('roomids')
    <script>
        var rooms = {!! $ids !!};
        var panel = {!! $panel !!};
        $(function() {
            init();
            checks();
        });
</script>
@endpush