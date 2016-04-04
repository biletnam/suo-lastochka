@extends('layouts.operator')

@section('content')
<p>
    <button type="button" class="btn suo-btn-operator btn-warning" id="btn-call" onclick="onclickCall(); return false;">
        Вызвать <span id="call-check-number"></span>
    </button>
    <button type="button" class="btn suo-btn-operator btn-warning" id="btn-accept" onclick="onclickAccept(); return false;">
        Принять <span id="accept-check-number"></span>
    </button>
    <button type="button" class="btn suo-btn-operator btn-warning" id="btn-end" onclick="onclickEnd(); return false;">
        Завершить <span id="end-check-number"></span>
    </button>
</p>
<p>
    <button type="button" class="btn suo-btn-operator btn-warning" id="btn-call-next" onclick="onclickCallNext(); return false;">
        Вызвать следующего <span id="call-next-check-number"></span>
    </button>
</p>
@endsection