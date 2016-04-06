@extends('layouts.terminal')

@push('show')
    <script>
        var terminal = {!! $terminal !!};

        $(function() {
            init();
            nextPage(1);
        });
</script>
@endpush