$(function() {
    var dlgGetACheck = $( "#dlg-get-a-check" ).dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true
    });
    function createTicket() {
        dlgGetACheck.dialog( "open" );
    }

    $( ".btn-create-ticket" ).button().on( "click", createTicket);
});
