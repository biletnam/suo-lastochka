@extends('layouts.terminal')

@section('content')
    @if (count($rooms) > 0)
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Rooms</th>
                        <th>&nbsp;</th>
                        <th>Create</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $room->name }}</div>
                                </td>

                                <td>
                                    <div>{{ $room->description }}</div>
                                </td>

                                <td>
                                    <form action="{{ url('terminal/select') }}" method="POST">
                                        {!! csrf_field() !!}

                                        <input type="hidden" name="terminal" value="{{ $room->id }}">
                                        <button type="submit" id="create-ticket-{{ $room->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Create
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection