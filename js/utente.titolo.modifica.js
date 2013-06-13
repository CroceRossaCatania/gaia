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
                     beforeShow: function (e) {
                         if ( $("#dataInizio").length > 0 ) {
                             $("#dataFine").datepicker('option', {
                                 minDate:    $("#dataInizio").datepicker('getDate')
                             }); 
                         }
                     }
                }); 
           }
 
});