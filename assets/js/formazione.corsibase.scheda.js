$(document).ready( function() {
   $("[data-iscrizione]").each ( function (i, e) {
       $(e).click( function () {
           var a1 = $(e).data('iscrizione');
           var a2 = $(e).data('accetta');
           var motivo = '';
           var com = '';
           if ( a2 == 0 ) {
              motivo = prompt("Motiva la negazione dell'iscrizione la corso");
              if ( motivo.length < 3 ) {
                alert("Inserisci una motivazione valida");
                return false;
              }
              $(e).parents('tr').addClass('warning');
           } else {
              com = $("#com").val();
           }
           api('corsobase:accetta', {
               id:      a1,
               iscr:    a2,
               motivo:  motivo,
               com:     com
           }, function(x) {
              if (a2 == 0) {
                $(e).parents('tr').hide(500);
              } else {
                window.location = '?p=formazione.corsibase.scheda&ammesso&id='+ x.risposta.id;
              }
           });
           return true;
       });
   });
});