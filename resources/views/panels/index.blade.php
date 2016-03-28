@extends('layouts.panel')

@section('content')
    @if (count($panels) > 0)
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Panel</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>Select</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @each('panels.panel_select', $panels, 'panel')
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection