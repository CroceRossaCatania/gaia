$(document).ready( function() {
 
$("#inputDataNascita").datepicker();

    $("#cercaTitolo").keyup(function(){
       var query = $("#cercaTitolo").val();
       
       if ( query.length > 0 ) {
           $("#risultatiRicerca").show('fade', 500);
           $("#risultatiRicerca tbody").html('<tr class="info"><td colspan="2" class="cp"><i class="icon-spinner icon-spin"></i> Ricerca in corso...</td></tr>');

           api('titoli:cerca', {
               query:   query
           }, function(x) {
               $("#risultatiRicerca tbody").html('');
               for (i in x.response) {
                     $("#risultatiRicerca tbody").append('<tr><td><strong>' + x.response[i][1] + '</strong></td><td class="span2"><a class="btn btn-success span12" href="javascript:aggiungiTitolo(' + x.response[i][0] + ')"><i class="icon-plus"></i> Aggiungi</a></td></tr>');
          }
               if ( x.response.length == 0 ) {
                    $("#risultatiRicerca tbody").html('<tr class="warning"><td colspan="2" class="cp"><i class="icon-warning-sign"></i> Nessun titolo corrispondente alla ricerca.</td></tr>');
               }
           });
       } else {
           $("#risultatiRicerca").hide('fade', 500);
       }
       
    });
    
   
    _abilita_filtraggio("#cercaUtente", "#tabellaUtenti");

});

function aggiungiTitolo (idTitolo) {
    $("#idTitolo").val(idTitolo);
    $("#step2 form").submit();
}