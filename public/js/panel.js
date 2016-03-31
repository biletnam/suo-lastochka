$(function() {
  checks();
});

function checks() {
    // Using the core $.ajax() method
    $.ajax({

        // The URL for the request
        url: "/panel/checks",

        // The data to send (will be converted to a query string)
//        data: {
//            room: room
//        },

        // Whether this is a POST or GET request
        type: "GET",

        // The type of data we expect back
        dataType : "json",
    })
      // Code to run if the request succeeds (is done);
      // The response is passed to the function
      .done(function( json ) {
          $.each( json, function( i, rooms ) {
                $( "#checks-room-" + rooms[ "room" ] ).text( rooms[ "checks" ] );
                if ("" != rooms[ "accepted" ]) {
                    $( "#call-room-" + rooms[ "room" ] ).text( rooms[ "accepted" ] ).removeClass( "called" );
                } else if ("" != rooms[ "called" ]) {
                    $( "#call-room-" + rooms[ "room" ] ).html( rooms[ "called" ] ).fadeToggle( "slow" ,
                        function() { $( "#call-room-" + rooms[ "room" ] ).fadeToggle( "slow" ); });
//                    $( "#call-room-" + rooms[ "room" ] ).text( rooms[ "called" ] ).fadeToggle( "slow" ,
//                        function() { $( "#call-room-" + rooms[ "room" ] ).fadeToggle( "slow" ); });
                } else {
                    //$( "#call-room-" + rooms[ "room" ] ).text( "" ).removeClass( "called" );
                }
            });

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


