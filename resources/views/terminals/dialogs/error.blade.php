
        <div id="suo-dlg-error" class="hidden-print text-center">
            <h1>Пожалуйста,</h1>
            <h1>повторите позже</h1>
        </div>

@push('dialogs')
    <script>
        var dlgError = $( "#suo-dlg-error" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            dialogClass: "no-close hidden-print"
        });

</script>
@endpush