$(document).ready( function() {
   $("[data-autorizzazione]").each ( function (i, e) {
       $(e).click( function () {
           var a1 = $(e).data('autorizzazione');
           var a2 = $(e).data('accetta');
           if ( a2 == 0 ) {
               $(e).parents('tr').addClass('warning');
           } else {
               $(e).parents('tr').addClass('success');
           }
           $(e).parent().children('a').addClass('disabled').html('<i class="icon-spin icon-spinner"></i> Attendere');
           api('autorizza', {
               id:      a1,
               aut:     a2
           }, function (x) {
               $(e).parents('tr').hide(500);
           })
           return true;
       });
   });
});