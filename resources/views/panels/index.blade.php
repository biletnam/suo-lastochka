@extends('layouts.panel')

@section('content')

    <div class="container">
    @if (count($panels) > 0)

        <table class="table table-striped task-table">
            <thead>
                <th>Адрес</th>
                <th>Имя</th>
                <th>Описание</th>
                <th></th>
            </thead>
            <tbody>

                @each('panels.panel_select', $panels, 'panel')

            </tbody>
        </table>
    @else

          <h2>Не определёна ни одина панель</h2>
    @endif

        <p>Для настройки панелей необходимо перейти в режим администратора.</p>
        <p><a class="btn btn-default" href="{{ url('suoadmin') }}" role="button">Перейти &raquo;</a></p>
    </div>
@endsection
