$(document).ready( function() {

    $("#dataInizio").datepicker({
                    beforeShow: function (e) {
                        if ( $("#dataFine").length > 0 ) {
                            $("#dataInizio").datepicker('option', {
                                maxDate:    $("#dataFine").datepicker('getDate')
                            });   
                        }
                    }
               });

    if ( $("#dataFine").length > 0 ) {
                    $("#dataFine").datepicker({
                         minDate: new Date(),
                         beforeShow: function (e) {
                             if ( $("#dataInizio").length > 0 ) {
                                 var maxDate = $("#dataInizio").datepicker('getDate');
                                 maxDate.setFullYear(maxDate.getFullYear() + 1);
                                 $("#dataFine").datepicker('option', {
                                     minDate:    $("#dataInizio").datepicker('getDate'),
                                     maxDate:   maxDate
                                 }); 
                             }
                         }
                    }); 
               }

    $("#protData").datepicker({
        maxDate: new Date()
    });

    var selettoreTipologia = "#inputTipo";  // ID del selettore
    var tipologiePositive  = [10, 20];      // Lista valori POSITIVI
    var scomparireNegativo = "#dataFine";   // Cosa far scomparire in NEGATIVO

    $(selettoreTipologia).change(function() {
        if ($(selettoreTipologia).val() == -1) {
         $(scomparireNegativo).hide(); 
        } else {
         $(scomparireNegativo).show(); 
        }
    });

});
