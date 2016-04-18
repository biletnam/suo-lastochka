@extends('layouts.panel')

@section('content')
    <table class="table suo-table">
        <thead>
            <th class="suo-header">Кабинет</th>
            @each('panels.table.header', $rooms, 'room')
        </thead>
        <tbody>
            <tr>
                <td class="suo-header">Обслуживается</td>
                @each('panels.table.current', $rooms, 'room')
            </tr>
            <tr>
                <td class="suo-header">Следующий</td>
                @each('panels.table.next', $rooms, 'room')
            </tr>
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