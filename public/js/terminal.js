var dlgGetACheck = $( "#suo-dlg-get-a-check" ).dialog({
    autoOpen: false,
    height: 300,
    width: 350,
    modal: true,
    dialogClass: "no-close hidden-print"
});

function init() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function nextPage( nextPage ) {
    $.get("",
        { page: nextPage },
        function( html ) {
            $( "#suo-page" ).html( html );
        }),
        "html"
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;
}

function createTicket( room ) {
    dlgGetACheck.dialog( "open" );
    setTimeout(function() {
        dlgGetACheck.dialog( "close" );
    }, 5000);

    var date = 'today';

    $.post(
        "/terminal/createticket",
        {
            terminal: terminal,
            room: room,
            date: date,
        }, function( check ) {
            parseCheck( check );
        },
        "json"
    )
    // Code to run if the request fails; the raw request and
    // status codes are passed to the function
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;

}

function parseCheck( check ) {
    $( "#suo-check-number" ).html( check.number );
    $( "#suo-check-operator" ).html( check.operator );
    $( "#suo-check-room-number" ).html( check.room_number );
    $( "#suo-check-room-description" ).html( check.room_description );
    $( "#suo-check-start-date" ).html( check.start_date );
    $( "#suo-check-get-time" ).html( check.get_time );
}