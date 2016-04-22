@extends('layouts.reception')

@section('content')

    <div class="container">
        <h1>Запись клиентов</h1>
        <table class="table suo-reception-table">
            <thead>
                <tr>
                    <td>Кабинет</td>
                    @foreach($weeks['current'] as $day)
                    
                    <td>{{ $day['short'] }}</td>
                    @endforeach
                    @foreach($weeks['next'] as $day)

                    <td>{{ $day['short'] }}</td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)

                <tr>
                    <td>{{ $room->description }}</td>
                    
                    @foreach($weeks['current'] as $day)
                        @include('reception.buttons.record')

                    @endforeach
                    @foreach($weeks['next'] as $day)
                        @include('reception.buttons.record')
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    @stack('dialogs')
    <script>
        var roomData = {!! $roomData !!},
            tickets = {!! $tickets_json !!};

        $(function() {
            init();
        });
    </script>
@endpush