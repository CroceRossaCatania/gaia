$(document).ready( function() {
    $("#moduloRegistrazione").submit( function() {
       if ( $("#inputComitato").val().length < 1 ) {
           alert('Seleziona il tuo comitato di appartenenza!');
           $("#inputComitato").focus();
           return false;
       } else {
           return true;
       }
    });
});