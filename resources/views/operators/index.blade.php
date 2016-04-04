@extends('layouts.operator')

@section('content')
<div>Электронная очередь</div>
<div>Всего в очереди <span id="ticket-count">{{ $tickets['count'] }}</span></div>
    @if (count($tickets) > 0)
    <div>
        <form action="{{ url('operator/current') }}" method="POST">
            {!! csrf_field() !!}

            <input type="hidden" name="ticket" id="current-ticket" value="{{ $tickets['tickets'][0] }}">
            <button type="submit" id="current-button" class="btn btn-danger">
                <i class="fa fa-btn fa-trash"></i>Вызвать <span id="current-check">{{ $tickets['checks'][0] }}</span>
            </button>
        </form>
    </div>
    <div>
        <form action="{{ url('operator/callnext') }}" method="POST">
            {!! csrf_field() !!}

            <input type="hidden" name="ticket" id="call-next-ticket" value="{{ $tickets['tickets'][1] }}">
            <button type="submit" id="call-next-button" class="btn btn-danger">
                <i class="fa fa-btn fa-trash"></i>Вызвать следующего <span id="call-next-check">{{ $tickets['checks'][1] }}</span>
            </button>
        </form>
    </div>

    @endif
@endsection