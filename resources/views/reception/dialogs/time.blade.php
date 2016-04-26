
        <div id="suo-dlg-select-time" class="text-center">
            <h1 class="center-block text-center">Выберите время записи</h1>
            <h3 class="center-block text-center">Кабинет <span id="suo-dlg-select-time-room"></span>, день записи <span id="suo-dlg-select-time-day"></span></h3>
            <div class="container-fluid center-block text-center">
                <div id="suo-dlg-select-time-container" class="center-block text-center">

                </div>
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row">
                    <div class="col-md-7">&nbsp;</div>
                    <div class="col-md-3">
                        <div id="btn-record-day-next" class="suo-reception-record-button" onclick="onClickSelectTimeClose( ); return false;">
                            <p class="suo-reception-record-button-on-middle">Закрыть</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

@push('dialogs')
    <script>
        var dlgSelectTime = $( "#suo-dlg-select-time" ).dialog({
            autoOpen: false,
            height: 450,
            width: 550,
            modal: true,
            dialogClass: "no-close hidden-print",
            close: function( event, ui ) { onCloseDlgSelectTime(); }
        });

</script>
@endpush