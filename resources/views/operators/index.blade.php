@extends('layouts.operator')

@section('content')
    @if (count($tickets) > 0)
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Tickets</th>
                        <th>&nbsp;</th>
                        <th>Status</th>
                        <th>Call</th>
                        <th>Close</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <!-- Task Name -->
                                <td class="table-text">
                                    <div>{{ $ticket->room->description }}</div>
                                </td>

                                <td>
                                    <div>{{ $ticket->id }}</div>
                                </td>

                                <td>
                                    <div>{{ $ticket->status }}</div>
                                </td>

                                <td>
                                    <form action="{{ url('operator/call') }}" method="POST">
                                        {!! csrf_field() !!}

                                        <input type="hidden" name="ticket" value="{{ $ticket->id }}">
                                        <button type="submit" id="call-{{ $ticket->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Call
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <form action="{{ url('operator/close') }}" method="POST">
                                        {!! csrf_field() !!}

                                        <input type="hidden" name="ticket" value="{{ $ticket->id }}">
                                        <button type="submit" id="close-{{ $ticket->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Close
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