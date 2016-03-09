@extends('layouts.app')

@section('content')
    @if (count($rooms) > 0)
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Rooms</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <!-- Task Name -->
                                <td class="table-text">
                                    <div>{{ $room->name }}</div>
                                </td>

                                <td>
                                    <div>{{ $room->description }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection