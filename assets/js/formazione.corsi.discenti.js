$(document).ready( function() {
    
    $('#nuova-persona').on('submit', function() {
       alert( JSON.stringify( $(".chosen-select").val() ) );
       
       // recuperare i discenti già selezionati 
       // salvarli in un cookie?! per recuperarli al caricamento successivo dopo l'inserimento di una nuova persona
       
       return false;
    });

});
