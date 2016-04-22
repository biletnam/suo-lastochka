@extends('layouts.reception')

@section('content')

    <div class="container">
        <h1>Запись клиентов</h1>
        <table class="table">
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

                        <td>{{ $day['short'] }}</td>
                        @endforeach
                        @foreach($weeks['next'] as $day)

                        <td>{{ $day['short'] }}</td>
                        @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection