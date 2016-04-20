
        <div id="suo-dlg-select-day" class="hidden-print">
            <h1 class="center-block text-center">Выберите день записи</h1>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="container-fluid center-block text-center">
                <div class="row">
                    @for ($i = 0; $i < 3; $i++)
                        @include('terminals.dialogs.select_day_button')
                    @endfor
                </div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    @for ($i = 3; $i < 5; $i++)
                        @include('terminals.dialogs.select_day_button')
                    @endfor
                </div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div id="btn-record-day-next" class="suo-terminal-record-button" onclick="onClickNextWeek( ); return false;">
                            <p class="suo-terminal-record-button-on-middle">Другие дни</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@push('dialogs')
    <script>
        var dlgSelectDay = $( "#suo-dlg-select-day" ).dialog({
            autoOpen: false,
            height: 550,
            width: 650,
            modal: true,
            dialogClass: "no-close hidden-print",
            close: function( event, ui ) { onCloseDlgSelectDay(); }
        });

        var weekRecordCaption = {!! $weeks !!};
        var indexToday = {{ $indexToday }};
</script>
@endpush