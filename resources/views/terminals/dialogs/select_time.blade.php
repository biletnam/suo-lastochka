
        <div id="suo-dlg-select-time" class="hidden-print">
            <h1 class="center-block text-center">Выберите время записи</h1>
            <h3 class="center-block text-center">День записи <span id="suo-dlg-select-time-day"></span></h3>
            <div id="suo-dlg-select-time-container" class="container-fluid center-block text-center">

            </div>
        </div>

@push('dialogs')
    <script>
        var dlgSelectTime = $( "#suo-dlg-select-time" ).dialog({
            autoOpen: false,
            height: 650,
            width: 850,
            modal: true,
            dialogClass: "no-close hidden-print",
            close: function( event, ui ) { onDlgSelectTimeClose(); }
        });

</script>
@endpush
