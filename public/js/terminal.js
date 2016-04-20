/**
 * Скрипты терминала
 *
 */

// Печать талона
function printTicket() {
    //setTimeout(print, 600);

    initSelected();
}


// Переменные

/**
 * Ид кабинетов
 *
 * @type Array
 */
var rooms = [];

/**
 * Данные по кабинетам
 * Индекс - ид кабинета, значения max_day_records - максимум для данного кабинета и другие
 *
 * @type Array
 */
var roomData = [];

/**
 * Кабинет, в который собираемся записываться
 *
 * @type Number
 */
var selectedRoom = -1;

/**
 * День, на который собираемся записаться
 *
 * @type String
 */
var selectedDay = '';

/**
 * Признак необходимости установки начальных значений для переменных selected...
 *
 * @type Boolean
 */
var needToInitSelected = true;

/**
 * Неделя в диалоге записи
 * 0 - текущая неделя, 1 - следующая неделя на экране. При нажатии кнопки "Другие дни" неделя меняется
 *
 * @type Number
 */
var selectedWeek = 0;

/**
 * Количество заявок по каждому дню
 * 0 - текущая неделя, 1 - следующая неделя, значения - массив с количеством записей
 *
 * @type Array
 */
var weekRecords = [];


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

function createTicket( room, date, time ) {
    if (true !== isLessThenMaxRecords( room )) {
        showDialog(dlgNoRecord, 5000);
        return;
    }

    date = date || "today";
    time = time || "now";

    showDialog(dlgGetACheck, 5000);

    $.post("/terminal/createticket",
        {
            terminal: terminal,
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

function getTicketCountToSelectDayDialog( room ) {
    $.get("/terminal/ticketcountbyday",
        {
            room: room,
            date1: weekRecordCaption[0][0],
            date2: weekRecordCaption[1][4],
        },
        function( json ) {
            onTicketCountToSelectDayDialog( json );
        }),
        "json"
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;

}

function getTimeDialog( room, day ) {
    $.get("/terminal/timedialog",
        {
            room: room,
            day: day,
        },
        function( json ) {
            onGetTimeDialog( json );
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
    if ('' !== json.error) {
        dlgGetACheck.dialog( "close" );
        showDialog(dlgError, 5000);
        console.log( "Error: " + json.error );
    } else {
        $.each( json, function( element, data) {
            $( "#suo-check-" + element ).html( data );
        });

        printTicket();
    }
}

function onTicketCount( json ) {
    $.each( json, function( key, data) {
        $( "#suo-tickets-count-" + data.room ).text( data.ticket_count );
        roomData[ data.room ][ "ticket_count" ] = data.ticket_count;
    });

    setTimeout(function() {
        //getTicketCount();
    }, 5000);
}

function onTicketCountToSelectDayDialog( json ) {
    weekRecords = json[ "weeks" ];
    changeButtonsCaptionOnSelectDayDialog( );
}

function onGetTimeDialog( json ) {
    $( "#suo-dlg-select-time-container" ).html( json.dialog );
    $( "#suo-dlg-select-time-day" ).html( json.day );

    showDialog(dlgSelectTime, 15000);
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
    selectedWeek++;
    if (selectedWeek > 1) {
        selectedWeek = 0;
    }
    changeButtonsCaptionOnSelectDayDialog( );
}

/**
 * Нажатие на выбор дня записи
 *
 * @param {integer} dayIndex
 * @returns {undefined}
 */
function onClickDay( dayIndex ) {
    needToInitSelected = false;
    dlgSelectDay.dialog( "close" );
    var room = selectedRoom;
    var day = weekRecordCaption[selectedWeek][dayIndex];
    if ("1" !== roomData[ room ][ "can_record_by_time" ]) {
        createTicket( room, day );
    } else {
        selectedDay = day;
        getTimeDialog( room, day );
    }
}

/**
 * Нажатие на выбор времени записи
 *
 * @param {integer} time
 * @returns {undefined}
 */
function onClickTime( time ) {
    needToInitSelected = false;
    dlgSelectTime.dialog( "close" );

    createTicket( selectedRoom, selectedDay, time );
}


// Обработка закрытий диалогов


function onCloseDlgSelectDay( ) {
    initSelected();
}


function onCloseDlgSelectTime() {
    initSelected();
}

function onCloseDlgGetACheck() {
    initSelected();
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
    selectedRoom = room;
    showDialog(dlgSelectDay, 15000);

    getTicketCountToSelectDayDialog( room );
}

function changeButtonsCaptionOnSelectDayDialog( ) {
    for (var i = 0; i < 5; i++) {
        $( "#text-record-day-" + i ).text(weekRecordCaption[selectedWeek][i]);

        if ("0" !== weekRecords[selectedWeek][i]) {
            $( "#text-record-day-ticket-count-" + i ).text(
                    "В очереди " + weekRecords[selectedWeek][i] + " из " + roomData[ selectedRoom ][ "max_day_record" ]);
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

function initSelected() {
    if (false !== needToInitSelected) {
        selectedRoom = -1;
        selectedDay = '';
        selectedWeek = 0;
    }

    needToInitSelected = true;
}
