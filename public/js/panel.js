var timers = [];

function checks() {
    $.get("/panel/checks",
        { rooms: rooms },
        function( tickets ) {
            parseTickets( tickets );
        }),
        "json"
    // Code to run if the request fails; the raw request and
    // status codes are passed to the function
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;
}

function parseTickets( tickets ) {
    nextChecks();

    $.each( rooms, function( key, value) {
        $( "#current-" + value ).html( "&nbsp;" );
        $( "#next-" + value ).html( "&nbsp;" );
    });

    if ( tickets[ "count" ] > 0) {
        $.each( tickets[ "rooms" ], function( room, ticket) {
            if ('' != ticket[ "accepted" ]) {
                $( "#current-" + room ).html( ticket[ "accepted" ] );
            } else if ('' != ticket[ "called" ]) {
                $( "#current-" + room ).html( ticket[ "called" ] );
                playNote();
                blink( room, ticket[ "called" ] );
            }

            if ('' != ticket[ "next" ]) {
                $( "#next-" + room ).html( ticket[ "next" ] );
            }
        });
    }
}

function blink( room, text ) {
    if (text == $( "#current-" + room ).html()) {
        $( "#current-" + room ).html( "&nbsp;" );
    } else {
        $( "#current-" + room ).html( text );
    }

    clearTimeout( timers[ "room" + room ] );
    timers[ "room" + room ] = setTimeout(function() {
        blink( room, text );
    }, 1000);
}

function playNote() {
    $( "#audio" ).removeProp( "muted" );
    stopPlayNote();
}

function stopPlayNote() {
    $( "#audio" ).attr( "muted", "muted" );
}

function nextChecks() {
    $.each( timers, function( name, timer ) {
        clearTimeout( timer );
    });

    timers[ "checks" ] = setTimeout(function() {
        checks();
    }, 5000);
}