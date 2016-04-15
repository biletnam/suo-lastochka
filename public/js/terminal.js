var dlgGetACheck = $( "#suo-dlg-get-a-check" ).dialog({
    autoOpen: false,
    height: 300,
    width: 350,
    modal: true,
    dialogClass: "no-close hidden-print"
});

var dlgNoRecord = $( "#suo-dlg-no-record" ).dialog({
    autoOpen: false,
    height: 300,
    width: 350,
    modal: true,
    dialogClass: "no-close hidden-print"
});

var rooms = [];

/**
 * Кабинет, в который собираемся записываться
 *
 * @type Number
 */
var recordRoom = -1;

function init() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function page( page ) {
    $.get("/terminal/" + terminal + "/page",
        { page: page },
        function( json ) {
            $( "#suo-page" ).html( json.page );
            rooms = json.rooms;
            ticketcount();
        }),
        "json"
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;
}

function createTicket( room, date ) {
    if (true != isLessThenMaxRecords( room )) {
        dlgNoRecord.dialog( "open" );
        setTimeout(function() {
            dlgNoRecord.dialog( "close" );
        }, 5000);

        return;
    }

    dlgGetACheck.dialog( "open" );
    setTimeout(function() {
        dlgGetACheck.dialog( "close" );
    }, 5000);

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

    //setTimeout(print, 600);
}

function ticketcount() {
    $.get("/terminal/ticketcount",
        {
            rooms: rooms,
            date: "today"
        },
        function( json ) {
            $.each( json, function( key, value) {
                $( "#suo-tickets-count-" + value.room ).text( value.ticket_count );
            });
        }),
        "json"
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;

    setTimeout(function() {
        ticketcount();
    }, 5000);
}

function isLessThenMaxRecords( room ) {
    var result = true;

    if (0 !== $( "#suo-max-day-record-" + room ).length) {
        var max = $( "#suo-max-day-record-" + room ).text();
        if (max <= $( "#suo-tickets-count-" + room ).text()) {
            result = false;
        }
    }

    return result;
}

function recordTicket( room, date ) {
    recordRoom = room;
    dlgRecord.dialog( "open" );
    setTimeout(function() {
        dlgRecord.dialog( "close" );
    }, 5000);
}

function recordDay( day ) {
    var room = recordRoom;
    dlgRecord.dialog( "close" );
    createTicket( room, day );
}

function onDlgRecordClose( ) {
    recordRoom = -1;
}