@extends('layouts.terminal')

@section('content')
    <div class="container">
    @if (count($terminals) > 0)
                <table class="table table-striped task-table">
                    <thead>
                        <th>Адрес</th>
                        <th>Имя</th>
                        <th>Описание</th>
                        <th></th>
                    </thead>
                    <tbody>

                        @each('terminals.terminal_select', $terminals, 'terminal')
                        
                    </tbody>
                </table>
    @else
          <h2>Не определён ни один терминал</h2>
    @endif
        <p>Для настройки терминалов необходимо перейти в режим администратора.</p>
        <p><a class="btn btn-default" href="{{ url('suoadmin') }}" role="button">Перейти &raquo;</a></p>
    </div>
@endsection