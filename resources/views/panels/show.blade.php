@extends('layouts.panel')

@section('content')
    <div class="panel panel-default">

        <div class="panel-body">
            <table class="table table-striped task-table">

                <!-- Table Body -->
                <tbody>
                    <tr>
                        @each('panels.window', $rooms, 'room')
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection