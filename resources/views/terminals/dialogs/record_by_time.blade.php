
        <div id="suo-dlg-record-by-time" class="hidden-print">
            <h1 class="center-block text-center">День записи</h1>
            <h1 class="center-block text-center">Выберите время записи</h1>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="container-fluid center-block text-center">
                @for ($row = 0; $row <= 4; $row++)
                <div class="row">
                    @for ($col = 0; $col <= 4; $col++)

                    <div class="col-md-2">
                        <div class="suo-terminal-record-button" onclick="onClickTime( '{{ $row }} {{ $col }}' ); return false;">
                            <p class="suo-terminal-record-button-on-middle">{{ $row }} {{ $col }}</p>
                        </div>
                    </div>

                    @endfor
                </div>

                @endfor

            </div>
        </div>

@push('dialogs')
    <script>
        var dlgRecordByTime = $( "#suo-dlg-record-by-time" ).dialog({
            autoOpen: false,
            height: 550,
            width: 650,
            modal: true,
            dialogClass: "no-close hidden-print",
            close: function( event, ui ) { onDlgRecordByTimeClose(); }
        });

</script>
@endpush
