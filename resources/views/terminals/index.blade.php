@extends('layouts.terminal')

@section('content')
    @if (count($terminals) > 0)
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Terminals</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>Create</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($terminals as $terminal)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $terminal->ip_address }}</div>
                                </td>

                                <td class="table-text">
                                    <div>{{ $terminal->name }}</div>
                                </td>

                                <td>
                                    <div>{{ $terminal->description }}</div>
                                </td>

                                <td>
                                    <form action="{{ url('terminal/select') }}" method="POST">
                                        {!! csrf_field() !!}

                                        <input type="hidden" name="terminal" value="{{ $terminal->id }}">
                                        <button type="submit" id="select-terminal-{{ $terminal->id }}" class="btn btn-danger">
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