var dlgGetACheck = $( "#dlg-get-a-check" ).dialog({
    autoOpen: false,
    height: 300,
    width: 350,
    modal: true,
    dialogClass: "no-close"
});

function createTicket(room) {
    dlgGetACheck.dialog( "open" );
    setTimeout(function() {
        dlgGetACheck.dialog( "close" );
    }, 5000);

    var date = 'today';

    // Using the core $.ajax() method
    $.ajax({

        // The URL for the request
        url: "/terminal/createticket",

        // The data to send (will be converted to a query string)
        data: {
            room: room
            , date: date
        },

        // Whether this is a POST or GET request
        type: "GET",

        // The type of data we expect back
        dataType : "json",
    })
      // Code to run if the request succeeds (is done);
      // The response is passed to the function
      .done(function( json ) {
         alert( json.check_number );
         $( "#check_number" ).html( json.check_number );
         $( "#check_room_description" ).html( json.check_room_description );

         //setTimeout(print, 600);

//         $( "<h1>" ).text( json.title ).appendTo( "body" );
//         $( "<div class=\"content\">").html( json.html ).appendTo( "body" );
      })
      // Code to run if the request fails; the raw request and
      // status codes are passed to the function
//      .fail(function( xhr, status, errorThrown ) {
//        alert( "Sorry, there was a problem!" );
//        console.log( "Error: " + errorThrown );
//        console.log( "Status: " + status );
//        console.dir( xhr );
//      })
      // Code to run regardless of success or failure;
//      .always(function( xhr, status ) {
//        alert( "The request is complete!" );
//      }
        ;

}
