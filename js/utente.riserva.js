$(document).ready( function() {
 
$("#datainizio").datepicker({
                beforeShow: function (e) {
                    if ( $("#datafine").length > 0 ) {
                        $("#datainizio").datepicker('option', {
                            maxDate:    $("#datafine").datepicker('getDate')
                        });   
                    }
                }
           });
if ( $("#datafine").length > 0 ) {
                $("#datafine").datepicker({
                     beforeShow: function (e) {
                         if ( $("#datainizio").length > 0 ) {
                             $("#datafine").datepicker('option', {
                                 minDate:    $("#datainizio").datepicker('getDate')
                             }); 
                         }
                     }
                }); 
           }
 
});