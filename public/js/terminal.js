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
var selectedWeek = "current";

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
    getDataFromServer("/terminal/" + terminal + "/page", { page: page }, onGetPage );
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
    getDataFromServer("/terminal/ticketcount", { rooms: rooms }, onTicketCount );
}

function getTicketCountToSelectDayDialog( room ) {
    getDataFromServer("/terminal/ticketcountbyday", {
        room: room,
        date1: weekRecordCaption[ "current" ][ 0 ][ "long" ],
        date2: weekRecordCaption[ "next" ][ 4 ][ "long" ],
    },
    onTicketCountToSelectDayDialog );
}

function getTimeDialog( room, day ) {
    getDataFromServer("/terminal/timedialog", {
        room: room,
        day: day,
    },
    onGetTimeDialog );
}

// Обработка ответов сервера

function onGetPage( json ) {
    $( "#suo-page" ).html( json[ "page" ] );
    rooms = json[ "rooms" ];
    roomData = json[ "roomData" ];
    getTicketCount();
}


function onTicketCreated( json ) {
    if ('' !== json[ "error" ]) {
        dlgGetACheck.dialog( "close" );
        showDialog(dlgError, 5000);
        console.log( "Error: " + json[ "error" ] );
    } else {
        $.each( json, function( element, data) {
            $( "#suo-check-" + element ).html( data );
        });

        printTicket();
    }
}

function onTicketCount( json ) {
    $.each( json, function( key, data) {
        $( "#suo-tickets-count-" + data[ "room"] ).text( data[ "ticket_count" ] );
        roomData[ data[ "room"] ][ "ticket_count" ] = data[ "ticket_count" ];
    });

    setTimeout(function() {
        //getTicketCount();
    }, 5000);
}

function onTicketCountToSelectDayDialog( json ) {
    weekRecords = json[ "weeks" ];
    changeButtonsCaptionOnSelectDayDialog( );

    showDialog(dlgSelectDay, 15000);
}

function onGetTimeDialog( json ) {
    $( "#suo-dlg-select-time-container" ).html( json[ "dialog" ] );
    $( "#suo-dlg-select-time-day" ).html( json[ "day" ] );
    $( "#suo-dlg-select-time-room" ).html( roomData[ selectedRoom ][ "description" ] );

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
    if ("current" == selectedWeek) {
        selectedWeek = "next";
    } else {
        selectedWeek = "current";
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
    if (
            ("current" == selectedWeek && dayIndex < indexToday)
        || (+weekRecords[ selectedWeek ][ dayIndex ] >= +roomData[ selectedRoom ][ "max_day_record" ])
        ) {
        return;
    }
    needToInitSelected = false;
    dlgSelectDay.dialog( "close" );
    var room = selectedRoom;
    var day = weekRecordCaption[ selectedWeek ][ dayIndex ][ "long" ];
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
function onClickTime( time, disabled ) {
    if (true != disabled) {
        needToInitSelected = false;
        dlgSelectTime.dialog( "close" );
        createTicket( selectedRoom, selectedDay, time );
    }
}

function onClickSelectDayClose( ) {
    dlgSelectDay.dialog( "close" );
}

function onClickSelectTimeClose( ) {
    dlgSelectTime.dialog( "close" );
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
    $( "#suo-dlg-select-day-room" ).html( roomData[ selectedRoom ][ "description" ] );

    getTicketCountToSelectDayDialog( room );
}

function changeButtonsCaptionOnSelectDayDialog( ) {
    var currentRecords = 0,
        maxDayRecord = +roomData[ selectedRoom ][ "max_day_record" ],
        textCount = "",
        captions = weekRecordCaption[ selectedWeek ],
        records = weekRecords[ selectedWeek ];

    for (var i = 0; i < 5; i++) {
        textCount = "";
        currentRecords = +records[ i ];

        $( "#text-record-day-" + i ).text( captions[ i ][ "short" ] );

        // отключаем кнопку, если дата меньше сегодняшней или уже записался максимум
        if (("current" == selectedWeek && i < indexToday) || (currentRecords >= maxDayRecord)) {
            $( "#btn-record-day-" + i ).addClass( "suo-terminal-record-button-disabled" );
            if (currentRecords < maxDayRecord) {
                $( "#text-record-day-" + i ).addClass( "suo-terminal-record-button-on-middle" );
            } else {
                $( "#text-record-day-" + i ).removeClass( "suo-terminal-record-button-on-middle" );
                textCount = "В очереди " + currentRecords + " из " + maxDayRecord;
            }
        } else {
            $( "#btn-record-day-" + i ).removeClass( "suo-terminal-record-button-disabled" );
            if (0 == currentRecords) {
                $( "#text-record-day-" + i ).addClass( "suo-terminal-record-button-on-middle" );
            } else {
                $( "#text-record-day-" + i ).removeClass( "suo-terminal-record-button-on-middle" );
                textCount = "В очереди " + currentRecords + " из " + maxDayRecord;
            }
        }

        $( "#text-record-day-ticket-count-" + i ).text( textCount );
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
        selectedWeek = "current";
    }

    needToInitSelected = true;
}

function getDataFromServer(url, data, success) {
    $.get(url, data, success)
        .fail(function( xhr, status, errorThrown ) {
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
        })
    ;
}