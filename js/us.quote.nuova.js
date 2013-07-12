$(document).ready( function() {
 
$("#inputData").datepicker();

$('#inputQuota').bind('change', function(event) {

           var i= $('#inputQuota').val();

            if(i==0)
             {
                 $('#inputCausale').show();
                 $('#causale').show();
                 $('#inputImporto').show();
                 $('#importo').show();
             }else{
                 $('#inputCausale').hide();
                 $('#causale').hide();
                 $('#inputImporto').hide();
                 $('#importo').hide();
             }
});
    
});