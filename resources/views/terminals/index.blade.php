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
                        <th>Select</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @each('terminals.terminal_select', $terminals, 'terminal')
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection