
        <div id="suo-dlg-no-record" class="hidden-print text-center">
            <h1>На текущую дату</h1>
            <h1>приём завершен</h1>
        </div>

@push('dialogs')
    <script>
        var dlgNoRecord = $( "#suo-dlg-no-record" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            dialogClass: "no-close hidden-print"
        });

</script>
@endpush

