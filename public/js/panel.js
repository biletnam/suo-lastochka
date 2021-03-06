var timers = [];

function init() {
    dailyReload();
}

function dailyReload() {
    var today = new Date();
    var tomorrow = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1, 0, 15);
    var diff = tomorrow.getTime() - today.getTime();
    setTimeout(function(){window.location.reload();}, diff);
}

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

    $( "#current-room-" ).html( "&nbsp;" );
    $( "#next-room-" ).html( "&nbsp;" );

    if ( tickets[ "count" ] > 0) {
        $.each( tickets[ "rooms" ], function( room, windows ) {
            $.each( windows, function ( window, ticket ) {
                var id = "-room-" + room + "-window-" + window;
                if ('' != ticket[ "accepted" ]) {

                    $( "#current" + id ).html( ticket[ "accepted" ] );
                } else if ('' != ticket[ "called" ]) {
                    $( "#current" + id ).html( ticket[ "called" ] );
                    playNote();
                    blink( room, ticket[ "called" ] );
                }

                if ('' != ticket[ "next" ]) {
                    $( "#next" + id ).html( ticket[ "next" ] );
                }
            });
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
    $( "#audio" ).trigger( "play" );
    stopPlayNote();
}

function stopPlayNote() {
    $( "#audio" ).trigger( "pause" );
    $( "#audio" ).prop( "currentTime", 0 );
}

function nextChecks() {
    $.each( timers, function( name, timer ) {
        clearTimeout( timer );
    });

    timers[ "checks" ] = setTimeout(function() {
        checks();
    }, 5000);
}