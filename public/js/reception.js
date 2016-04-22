

// Инициализация


function init() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    setTimeout(function() {
        getTicketCount();
    }, 5000);
}

var selectedRoom = -1;


// Запросы серверу


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

function getTicketCount() {
    $.get(
            "/reception/ticketcount",
            {
                rooms: rooms
            },
            function( json ) {
                onTicketCount( json );
            }
        )
        .fail(function( xhr, status, errorThrown ) {
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
        })
    ;
}

function getTimeDialog( room, date ) {
    $.get(
            "/reception/timedialog",
            {
                room: room,
                date: date
            },
            function( json ) {
                onGetTimeDialog( json );
            }
        )
        .fail(function( xhr, status, errorThrown ) {
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
        })
    ;
}


// Обработка ответов сервера


function onTicketCreated( json ) {
    $.each( json, function( element, data) {
        $( "#suo-check-" + element ).html( data );
    });

    showDialog(dlgCheck, 5000);

    getTicketCount();
}

function onTicketCount( json ) {
    $.each( json, function( room, room_data) {
        $.each( room_data, function( date, count) {
            $( "#suo-tickets-count-" + room + "-" + date).text( count );
            tickets[ room ][ date ] = +count;

            if (+count >= +roomData[ room ][ "max_day_record" ]) {
                $( "#suo-btn-room-date-" + room + "-" + date).addClass( "suo-reception-button-disabled" );
            } else {
                $( "#suo-btn-room-date-" + room + "-" + date).removeClass( "suo-reception-button-disabled" );
            }


        });
    });

    setTimeout(function() {
        getTicketCount();
    }, 5000);
}

function onGetTimeDialog( json ) {
    $( "#suo-dlg-select-time-container" ).html( json[ "dialog" ] );
    $( "#suo-dlg-select-time-day" ).html( json[ "day" ] );
    $( "#suo-dlg-select-time-room" ).html( roomData[ selectedRoom ][ "description" ] );

    showDialog(dlgSelectTime, 15000);
}


// Обработка нажатий кнопок


function onClickDay( room, date ) {
    var max = +roomData[ room ][ "max_day_record" ];
    var current = +tickets[ room ][ date ];
    if (current >= max) {
        return;
    }

    if ("0" == roomData[ room ][ "can_record_by_time" ]) {
        createTicket( room, date );
    } else {
        selectedRoom = room;
        getTimeDialog( room, date );
    }
}

function onClickDlgCheckClose( ) {
    dlgCheck.dialog( "close" );
}

function onClickSelectTimeClose( ) {
    dlgSelectTime.dialog( "close" );
}

function onClickTime( time, disabled ) {
    alert( time );
}


// Обработка закрытий диалогов


function onCloseDlgСheck() {

}

function onCloseDlgSelectTime( ) {
    selectedRoom = -1;
}


// Вспомогательные функции


function showDialog( dialog, time_to_show ) {
    dialog.dialog( "open" );
    setTimeout(function() {
        dialog.dialog( "close" );
    }, time_to_show);
}