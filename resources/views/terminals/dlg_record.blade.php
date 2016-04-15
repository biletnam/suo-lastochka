
        <div id="suo-dlg-record" class="hidden-print">
            <h1 class="center-block text-center">Выберите день записи</h1>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="container-fluid center-block text-center">
                @php($monday=strtotime('Monday this week'))

                <div class="row">
                    @for ($i = 0; $i < 3; $i++)
                        @php($day=date('d.m',strtotime("+$i day", $monday)))

                        @include('terminals.dlg_record_button')
                    @endfor
                </div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    @for ($i = 3; $i < 5; $i++)
                        @php($day=date('d.m',strtotime("+$i day", $monday)))

                        @include('terminals.dlg_record_button')
                    @endfor
                </div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div id="btn-record-day-next" class="suo-terminal-record-button" onclick="recordDay( 'next' ); return false;">
                            <p class="suo-terminal-record-button-top">&nbsp;</p>
                            <p>Другие дни</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@push('dlg-record')
    <script>
        var dlgRecord = $( "#suo-dlg-record" ).dialog({
            autoOpen: false,
            height: 550,
            width: 650,
            modal: true,
            dialogClass: "no-close hidden-print",
            close: function( event, ui ) { onDlgRecordClose(); }
        });
</script>
@endpush