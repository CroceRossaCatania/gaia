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
                     minDate: new Date(),
                     beforeShow: function (e) {
                         if ( $("#datainizio").length > 0 ) {
                             var maxDate = $("#datainizio").datepicker('getDate');
                             maxDate.setFullYear(maxDate.getFullYear() + 1);
                             $("#datafine").datepicker('option', {
                                 minDate:    $("#datainizio").datepicker('getDate'),
                                 maxDate:   maxDate
                             }); 
                         }
                     }
                }); 
           }
$("#protData").datepicker();
});
