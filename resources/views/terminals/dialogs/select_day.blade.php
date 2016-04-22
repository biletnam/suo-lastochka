
        <div id="suo-dlg-select-day" class="hidden-print">
            <h1 class="center-block text-center">Выберите день записи</h1>
            <h3 class="center-block text-center">Кабинет <span id="suo-dlg-select-day-room"></span></h3>
            <div class="container-fluid center-block text-center">
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
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
                    <div class="col-md-6">
                        <div id="btn-record-day-next" class="suo-terminal-record-button" onclick="onClickNextWeek( ); return false;">
                            <p class="suo-terminal-record-button-on-middle">Другие дни</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="btn-record-day-next" class="suo-terminal-record-button" onclick="onClickSelectDayClose( ); return false;">
                            <p class="suo-terminal-record-button-on-middle">Закрыть</p>
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

        var weekRecordCaption = {!! $weeks_json !!};
        var indexToday = {{ $indexToday }};
</script>
@endpush