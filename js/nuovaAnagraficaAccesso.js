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

    $('#inputAnno').bind('change', function(event) {
       $('#inputMese').show();
       $('#mese').show();
    });

	$('#inputMese').bind('change', function(event) {
     $('#inputGiorno').show();
     $('#giorno').show();
	});
  
});