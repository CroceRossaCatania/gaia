$(document).ready( function() {
   
   var tutteRighe;
   var numRighe;
   var numRigheNascoste = 0;
   
   tutteRighe = $("[data-timestamp]");
   numRighe = tutteRighe.length;
   
   var ora = new Date();
   
   $(tutteRighe).each( function(i, e) { 
       var ts = $(e).data('timestamp');
       var to = new Date(ts);
       if ( to < ora ) {
           numRigheNascoste++;
           $(e).hide();
       }
    });
    
    if ( numRigheNascoste > 0 ) {
        $("#rigaMostraTuttiTurni").show();
        $("#numTurniNascosti").text(numRigheNascoste);
        $("#mostraTuttiTurni").click ( function () {
            $("#turniAttivita tr").show(500);
            $("#rigaMostraTuttiTurni").hide();
        });
    }
   
});