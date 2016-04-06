@extends('layouts.terminal')

@push('show')
    <script>
        var terminal = {!! $terminal !!};

        $(function() {
            init();
            page(1);
        });
</script>
@endpush