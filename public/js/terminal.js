/**
 * Скрипты терминала
 *
 */

// Переменные

/**
 * Ид кабинетов
 *
 * @type Array
 */
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


// Инициализация


function init() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    dailyReload();

    getPage();
}

function dailyReload() {
    var today = new Date();
    var tomorrow = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1, 0, 15);
    var diff = tomorrow.getTime() - today.getTime();
    setTimeout(function() {
        window.location.reload();
    }, diff);
}


// Запросы к серверу


function getPage( page ) {
    $.get("/terminal/" + terminal + "/page",
        { 
            page: page
        },
        function( json ) {
            onGetPage( json );
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
        showDialog(dlgNoRecord, 5000);
        return;
    }

    date = date || "today";

    showDialog(dlgGetACheck, 5000);

    $.post("/terminal/createticket",
        {
            terminal: terminal,
            room: room,
            date: date,
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
    $.get("/terminal/ticketcount",
        {
            rooms: rooms,
        },
        function( counts ) {
            onTicketCount( counts );
        }),
        "json"
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;
}

function getTicketCountToRecordDialog( room ) {
    $.get("/terminal/ticketcountbyday",
        {
            room: room,
            date1: weekRecordCaption[0][0],
            date2: weekRecordCaption[1][4],
        },
        function( json ) {
            onTicketCountToRecordDialog( json );
        }),
        "json"
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;

}

// Обработка ответов сервера

function onGetPage( json ) {
    $( "#suo-page" ).html( json.page );
    rooms = json.rooms;
    roomData = json.roomData;
    getTicketCount();
}


function onTicketCreated( json ) {
    $.each( json, function( key, data) {
        $( "#suo-check-" + data ).html( data );
    });
    
    //setTimeout(print, 600);
}

function onTicketCount( json ) {
    $.each( json, function( key, data) {
        $( "#suo-tickets-count-" + data.room ).text( data.ticket_count );
        roomData[ data.room ][ "ticket_count" ] = data.ticket_count;
    });

    setTimeout(function() {
        getTicketCount();
    }, 5000);
}

function onTicketCountToRecordDialog( json ) {
    weekRecords = json[ "weeks" ];
    changeButtonsCaptionOnRecordDialog( );
}


// Обработка нажатий кнопок терминала

/**
 * Нажатие на выбор кабинета
 *
 * @param {integer} room Кабинет
 * @returns {undefined}
 */
function onClickRoom( room ) {
    if ("1" !== roomData[ room ][ "can_record" ]) {
        createTicket( room, "today" );
    } else {
        recordTicket( room );
    }
}

/**
 * Нажатие на следующую страницу с кабинетами
 *
 * @param {integer} page Следующая страница
 * @returns {undefined}
 */
function onClickNextPage( page ) {
    getPage( page );
}

/**
 * Нажатие на выборе следующей недели для записи
 *
 * @returns {undefined}
 */
function onClickNextWeek() {
    currentRecordWeek++;
    if (currentRecordWeek > 1) {
        currentRecordWeek = 0;
    }
    changeButtonsCaptionOnRecordDialog( );
}

/**
 * Нажатие на выбор дня записи
 *
 * @param {integer} dayIndex
 * @returns {undefined}
 */
function onClickDay( dayIndex ) {
    var room = recordRoom;
    var day = weekRecordCaption[currentRecordWeek][dayIndex];
    dlgSelectDay.dialog( "close" );
    if ("1" !== roomData[ room ][ "can_record_by_time" ]) {
        createTicket( room, day );
    } else {
        showDialog(dlgSelectTime, 15000);
    }
}

/**
 * Нажатие на выбор времени записи
 *
 * @param {integer} time
 * @returns {undefined}
 */
function onClickTime( time ) {
    alert( "onClickTime" + time );
}


// Обработка закрытий диалогов


function onDlgSelectDayClose( ) {
    recordRoom = -1;
    currentRecordWeek = 0;
}


function onDlgSelectTimeClose() {
    alert( "onDlgSelectTimeClose" );
}


// Вспомогательные функции


function isLessThenMaxRecords( room ) {
    var result = true;
    var data = roomData[ room ];

    if ("0" !== data[ "max_day_record" ]) {
        if (data[ "ticket_count" ] >= data[ "max_day_record" ]) {
            result = false;
        }
    }

    return result;
}

function recordTicket( room ) {
    recordRoom = room;
    showDialog(dlgSelectDay, 15000);

    getTicketCountToRecordDialog( room );
}

function changeButtonsCaptionOnRecordDialog( ) {
    for (var i = 0; i < 5; i++) {
        $( "#text-record-day-" + i ).text(weekRecordCaption[currentRecordWeek][i]);

        if ("0" !== weekRecords[currentRecordWeek][i]) {
            $( "#text-record-day-ticket-count-" + i ).text(
                    "В очереди " + weekRecords[currentRecordWeek][i] + " из " + roomData[ recordRoom ][ "max_day_record" ]);
            $( "#text-record-day-" + i ).removeClass( "suo-terminal-record-button-on-middle" );
        } else {
            $( "#text-record-day-ticket-count-" + i ).text( "" );
            $( "#text-record-day-" + i ).addClass( "suo-terminal-record-button-on-middle" );
        }

    }
}

function showDialog( dialog, time_to_show ) {
    dialog.dialog( "open" );
    setTimeout(function() {
        dialog.dialog( "close" );
    }, time_to_show);
}