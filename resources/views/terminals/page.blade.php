@extends('layouts.terminal')

@section('content')
    @if (count($rooms) > 0)
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Body -->
                    <tbody>
                        @each('terminals.button', $rooms, 'room')
                    </tbody>
                </table>

                <div>{!! $rooms->links() !!}</div>
            </div>
        </div>
    @endif
@endsection