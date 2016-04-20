
        <div id="suo-dlg-select-time" class="hidden-print">
            <h1 class="center-block text-center">День записи</h1>
            <h1 class="center-block text-center">Выберите время записи</h1>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div id="suo-dlg-select-time-container" class="container-fluid center-block text-center">

            </div>
        </div>

@push('dialogs')
    <script>
        var dlgSelectTime = $( "#suo-dlg-select-time" ).dialog({
            autoOpen: false,
            height: 550,
            width: 650,
            modal: true,
            dialogClass: "no-close hidden-print",
            close: function( event, ui ) { onDlgSelectTimeClose(); }
        });

</script>
@endpush
