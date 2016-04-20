
        <div id="suo-dlg-get-a-check" class="hidden-print text-center">
            <h1>Пожалуйста,</h1>
            <h1>возьмите талон</h1>
        </div>

@push('dialogs')
    <script>
        var dlgGetACheck = $( "#suo-dlg-get-a-check" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            dialogClass: "no-close hidden-print",
            close: function( event, ui ) { onCloseDlgGetACheck(); }
        });

</script>
@endpush
