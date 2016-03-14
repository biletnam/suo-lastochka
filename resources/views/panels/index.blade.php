@extends('layouts.panel')

@section('content')
    @if (count($tickets) > 0)
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Tickets</th>
                        <th>&nbsp;</th>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection