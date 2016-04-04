var ticket_to_call = 0;

$(function() {
  init();
});

function init() {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

    getTickets();
}

function getTickets() {
    $.get("/operator/checks",
        function( tickets ) {
            parseTickets( tickets );
        })
    // Code to run if the request fails; the raw request and
    // status codes are passed to the function
    .fail(function( xhr, status, errorThrown ) {
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    })
    ;
}

function onclickCall() {
    $.post(
        "/operator/call",
        {
            ticket: ticket_to_call
        }, function( tickets ) {
            parseTickets( tickets );
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

function onclickAccept() {
    $.post(
        "/operator/accept",
        {
            ticket: ticket_to_call
        }, function( tickets ) {
            parseTickets( tickets );
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

function onclickClose() {
    $.post(
        "/operator/close",
        {
            ticket: ticket_to_call
        }, function( tickets ) {
            parseTickets( tickets );
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

function parseTickets( tickets ) {
    var call = '', accept = '', close = '';
    if ( 0 != tickets[ "accepted" ] ) { // нажали "Принять", теперь надо "Завершить"
        ticket_to_call = tickets[ "accepted" ][ "id" ];
        close = tickets[ "accepted" ][ "check_number" ];
    } else if ( 0 != tickets[ "called" ] ) { // нажали "Вызвать", теперь надо или "Принять", или "Вызвать" ещё раз
        ticket_to_call = tickets[ "called" ][ "id" ];
        call = accept = tickets[ "called" ][ "check_number" ];
    } else if ( 0 != tickets[ "count" ] ) { // нет вызыванных или принятых, но в очереди кто-то есть, можно "Вызвать"
        ticket_to_call = tickets[ "current" ][ "id" ];
        call = tickets[ "current" ][ "check_number" ];
    }

    $( "#call-check-number" ).text( call );
    $( "#accept-check-number" ).text( accept );
    $( "#close-check-number" ).text( close );

    $( "#btn-call").prop( "disabled", (('' !== call) ? false : true) );
    $( "#btn-accept").prop( "disabled", (('' !== accept) ? false : true) );
    $( "#btn-close").prop( "disabled", (('' !== close) ? false : true) );
}