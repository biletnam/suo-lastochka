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

/**
 * Неделя в диалоге записи
 * 0 - текущая неделя, 1 - следующая неделя на экране. При нажатии кнопки "Другие дни" неделя меняется
 *
 * @type Number
 */
var currentRecordWeek = 0;

/**
 * Количество заявок по каждому дню
 * 0 - текущая неделя, 1 - следующая неделя, значения - массив с количеством записей
 *
 * @type Array
 */
var weekRecords = [];

/**
 * Данные по кабинетам
 * Индекс - ид кабинета, значения max_day_records - максимум для данного кабинета
 *
 * @type Array
 */
var roomData = [];

function init() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    dailyReload();
}

function dailyReload() {
    var today = new Date();
    var tomorrow = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1, 0, 15);
    var diff = tomorrow.getTime() - today.getTime();
    setTimeout(function(){window.location.reload();}, diff);
}

function page( page ) {
    $.get("/terminal/" + terminal + "/page",
        { page: page },
        function( json ) {
            $( "#suo-page" ).html( json.page );
            rooms = json.rooms;
            roomData = json.roomData;
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

    date = date || "today";

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
        },
        function( json ) { onTicketCount( json ); }),
        "json"
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;
}

function onTicketCount( json ) {
    $.each( json, function( key, value) {
        $( "#suo-tickets-count-" + value.room ).text( value.ticket_count );
    });


    setTimeout(function() {
//        ticketcount();
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

function recordTicket( room ) {
    recordRoom = room;
    dlgRecord.dialog( "open" );
    setTimeout(function() {
        dlgRecord.dialog( "close" );
    }, 15000);

    ticketCountToRecordDialog( room );
}

function recordDay( dayIndex ) {
    var room = recordRoom;
    var day = weekRecordCaption[currentRecordWeek][dayIndex];
    dlgRecord.dialog( "close" );
    if (1 != roomData[ room ][ "can_record_by_time" ]) {
        createTicket( room, day );
    } else {
        dlgRecordByTime.dialog( "open" );
        setTimeout(function() {
            dlgRecordByTime.dialog( "close" );
        }, 15000);
    }
}

function onDlgRecordClose( ) {
    recordRoom = -1;
    currentRecordWeek = 0;
}

function nextRecordDay() {
    currentRecordWeek++;
    if (currentRecordWeek > 1) {
        currentRecordWeek = 0;
    }
    recordDayChangeCaption( );
}

function ticketCountToRecordDialog( room ) {
    $.get("/terminal/ticketcountbyday",
        {
            room: room,
            date1: weekRecordCaption[0][0],
            date2: weekRecordCaption[1][4],
        },
        function( json ) {
            weekRecords = json[ "weeks" ];
            recordDayChangeCaption( );
        }),
        "json"
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;

}

function recordDayChangeCaption( ) {
    for (var i = 0; i < 5; i++) {
        $( "#text-record-day-" + i ).text(weekRecordCaption[currentRecordWeek][i]);

        if (0 != weekRecords[currentRecordWeek][i]) {
            $( "#text-record-day-ticket-count-" + i ).text(
                    "В очереди " + weekRecords[currentRecordWeek][i] + " из " + roomData[ recordRoom ][ "max_day_record" ]);
            $( "#text-record-day-" + i ).removeClass( "suo-terminal-record-button-on-middle" );
        } else {
            $( "#text-record-day-ticket-count-" + i ).text( "" );
            $( "#text-record-day-" + i ).addClass( "suo-terminal-record-button-on-middle" );
        }

    }
}

function recordbyTime() {
    alert( "recordbyTime" );
}

function onDlgRecordByTimeClose() {
    alert( "onDlgRecordByTimeClose" );
}