
        <div id="suo-dlg-record" class="hidden-print">
            <h1 class="center-block text-center">Выберите день записи</h1>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="container-fluid center-block text-center suo-dlg-record-table">
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
            </div>
        </div>

@push('dlg-record')
    <script>
        var dlgRecord = $( "#suo-dlg-record" ).dialog({
            autoOpen: false,
            height: 500,
            width: 650,
            modal: true,
            dialogClass: "no-close hidden-print",
            close: function( event, ui ) { onDlgRecordClose(); }
        });
</script>
@endpush