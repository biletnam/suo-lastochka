
function init() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function createTicket( room, date, time ) {
    date = date || "today";
    time = time || "now";

//    showDialog(dlgGetACheck, 5000);

    $.post("/reception/createticket",
        {
            room: room,
            date: date,
            time: time,
        },
        function( json ) {
            onTicketCreated( json );
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

function onTicketCreated( json ) {
    alert( json );
}

function onClickDay( room, date ) {
    var max = +roomData[ room ][ "max_day_record" ];
    var current = +tickets[ room ][ date ];
    if (current >= max) {
        return;
    }
    
    createTicket( room, date );
}