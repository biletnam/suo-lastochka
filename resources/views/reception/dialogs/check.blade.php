
        <div id="suo-dlg-check" class="text-center">
            <p id="suo-check-title">Поликлиника</p>
            <p id="suo-check-title">Запись создана</p>
            <p id="suo-check-error"></p>
            <p id="suo-check-number"></p>
            <p id="suo-check-operator"></p>
            <p id="suo-check-room-number"></p>
            <p id="suo-check-room-description"></p>
            <p id="suo-check-start-date"></p>
            <p id="suo-check-position"></p>
            <p id="suo-check-get-time"></p>
            <p class="suo-dialog-button-close suo-reception-record-button-on-middle pull-right" onclick="onClickDlgCheckClose(); return false;">Закрыть</p>
            <div class="clearfix"></div>
        </div>

@push('dialogs')
    <script>
        var dlgCheck = $( "#suo-dlg-check" ).dialog({
            autoOpen: false,
            height: 250,
            width: 300,
            modal: true,
            dialogClass: "no-close hidden-print",
            close: function( event, ui ) { onCloseDlgСheck(); }
        });

</script>
@endpush