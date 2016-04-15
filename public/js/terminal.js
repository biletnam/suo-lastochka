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
 * Индекс - кабинет, значения - массив с днями и количеством записей
 *
 * @type Array
 */
var weekRecords = [];

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

function recordTicket( room ) {
    recordRoom = room;
    dlgRecord.dialog( "open" );
    setTimeout(function() {
        dlgRecord.dialog( "close" );
    }, 15000);
}

function recordDay( dayIndex ) {
    var room = recordRoom;
    var day = weekRecordCaption[currentRecordWeek][dayIndex];
    dlgRecord.dialog( "close" );
    createTicket( room, day );
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
    for (var i = 0; i < 5; i++) {
        $( "#text-record-day-" + i ).text(weekRecordCaption[currentRecordWeek][i]);
    }
}