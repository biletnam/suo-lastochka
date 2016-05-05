@extends('layouts.operator')

@section('content')
<p>
    <button type="button" class="btn suo-btn-operator btn-warning" id="btn-call" onclick="onclickCall(); return false;">
        Вызвать <span id="call-check-number"></span>
    </button>
    <button type="button" class="btn suo-btn-operator btn-warning" id="btn-accept" onclick="onclickAccept(); return false;">
        Принять <span id="accept-check-number"></span>
    </button>
    <button type="button" class="btn suo-btn-operator btn-warning" id="btn-close" onclick="onclickClose(); return false;">
        Завершить <span id="close-check-number"></span>
    </button>
</p>
@endsection

@push('scripts')
    <script>
        $(function() {
            init();
        });
    </script>
@endpush
