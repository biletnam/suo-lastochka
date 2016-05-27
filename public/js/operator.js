var ticket_to_call = 0;
var timers = [];

function init() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    getChecks();
}

// Получение данных с сервера

function getChecks() {
    getDataFromServer("/operator/checks", {}, onGetChecks);
}

function call( ) {
    postDataToServer("/operator/call", {
            ticket: ticket_to_call
        }, onCall);
}

function accept( ) {
    postDataToServer("/operator/accept", {
            ticket: ticket_to_call
        }, onAccept);
}

function close( ) {
    postDataToServer("/operator/close", {
            ticket: ticket_to_call
        }, onClose);
}

// Обработка полученных данных с сервера

function onGetChecks( json ) {
    parseTickets( json );
}

function onCall( json ) {
    parseTickets( json );
}

function onAccept( json ) {
    parseTickets( json );
}

function onClose( json ) {
    parseTickets( json );
}

// Обработка нажатий кнопок

function onclickCall() {
    call( );
}

function onclickAccept() {
    accept( );
}

function onclickClose() {
    close( );
}

// Вспомогательные функции

function parseTickets( tickets ) {
    var call = '', accept = '', close = '';

    if ( 0 != tickets[ "accepted" ] ) { // нажали "Принять", теперь надо "Завершить"
        ticket_to_call = tickets[ "accepted" ][ "id" ];
        close = tickets[ "accepted" ][ "check_number" ];
    } else if ( 0 != tickets[ "called" ] ) { // нажали "Вызвать", теперь надо или "Принять", или "Вызвать" ещё раз
        ticket_to_call = tickets[ "called" ][ "id" ];
        call = accept = close = tickets[ "called" ][ "check_number" ];
    } else if ( 0 != tickets[ "count" ] ) { // нет вызыванных или принятых, но в очереди кто-то есть, можно "Вызвать"
        ticket_to_call = tickets[ "inqueue" ][ "id" ];
        call = tickets[ "inqueue" ][ "check_number" ];
    }

    $( "#call-check-number" ).text( call );
    $( "#accept-check-number" ).text( accept );
    $( "#close-check-number" ).text( close );

    $( "#btn-call").prop( "disabled", (('' !== call) ? false : true) );
    $( "#btn-accept").prop( "disabled", (('' !== accept) ? false : true) );
    $( "#btn-close").prop( "disabled", (('' !== close) ? false : true) );

    nextChecks();
}

function nextChecks() {
    $.each( timers, function( name, timer ) {
        clearTimeout( timer );
    });

    timers[ "checks" ] = setTimeout(function() {
        getChecks();
    }, 5000);
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

function postDataToServer(url, data, success) {
    $.post(url, data, success, "json" )
        .fail(function( xhr, status, errorThrown ) {
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
        })
    ;
}