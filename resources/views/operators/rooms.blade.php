@extends('layouts.operator')

@section('content')
<h1>Выбор кабинета</h1>
<form class="form-horizontal" role="form" method="POST" action="{{ url('/operator/selectroom') }}">
    {!! csrf_field() !!}
<table class="table">
    <tr>
@foreach($rooms as $room)
    @for($window = 1; $window <= $room->window_count; $window++)
    @php($value=$room->id)
    @if($window != 1)
        @php($value .= '-' . $window)
    @endif
        <td>
            <button type="submit" name="room" value="{{ $value }}" class="btn suo-btn-operator btn-warning">
            {{ $room->description }}
            @if($room->window_count != 1)
             окно {{ $window }}
            @endif
            </button>
        </td>
    @endfor
@endforeach
    </tr>
</table>
</form>
@endsection