$(document).ready( function() {
   $("[data-iscrizione]").each ( function (i, e) {
       $(e).click( function () {
           var a1 = $(e).data('iscrizione');
           var a2 = $(e).data('accetta');
           var motivo = '';
           if ( a2 == 0 ) {
              motivo = prompt("Motiva la negazione dell'iscrizione la corso");
              if ( motivo.legth < 3 ) {
                alert("Inserisci una motivazione valida");
                return false;
              }
              $(e).parents('tr').addClass('warning');
           } else {
              $(e).parents('tr').addClass('success');
           }
           api('iscriviBase', {
               id:      a1,
               iscr:    a2,
               motivo:  motivo
           })
           if (a2 == 0) {
              $(e).parents('tr').hide(500);
           } else {
              $(e).parent().children('a').addClass('disabled');
           }
           return true;
       });
   });
});