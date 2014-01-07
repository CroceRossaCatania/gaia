$(document).ready( function() {
    
    $("#cercaTitolo").keyup(function(){
       var query = $("#cercaTitolo").val();
       
       if ( query.length > 0 ) {
           $("#risultatiRicerca").show('fade', 500);
           $("#risultatiRicerca tbody").html('<tr class="info"><td colspan="2" class="cp"><i class="icon-spinner icon-spin"></i> Ricerca in corso...</td></tr>');

           api('titoli:cerca', {
               query:   query
           }, function(x) {
               $("#risultatiRicerca tbody").html('');
               for (i in x.risposta) {
                     $("#risultatiRicerca tbody").append('<tr><td><strong>' + x.risposta[i][1] + '</strong></td><td class="span2"><a class="btn btn-success span12" href="javascript:cercaTitolo(' + x.risposta[i][0] + ')"><i class="icon-search"></i> Cerca</a></td></tr>');
          }
               if ( x.risposta.length == 0 ) {
                    $("#risultatiRicerca tbody").html('<tr class="warning"><td colspan="2" class="cp"><i class="icon-warning-sign"></i> Nessun titolo corrispondente alla ricerca.</td></tr>');
               }
           });
       } else {
           $("#risultatiRicerca").hide('fade', 500);
       }
       
    });
    
   
    _abilita_filtraggio("#cercaUtente", "#tabellaUtenti");

});

function cercaTitolo (idTitolo) {
    $("#idTitolo").val(idTitolo);
    $("#step2 form").submit();
}