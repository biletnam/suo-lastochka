@extends('layouts.panel')

@section('content')
    <div class="panel panel-default">

        <div class="panel-body">
            <div>Электронная очередь</div>
            <table class="table table-striped task-table">

                <thead>
                    <th>Кабинет</th>
                    <th>Клиент</th>
                    <th></th>
                </thead>
                <!-- Table Body -->
                <tbody>
@each('panels.window', $rooms, 'room')
                </tbody>
            </table>
        </div>
    </div>
@endsection