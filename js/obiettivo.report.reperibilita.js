$(document).ready ( function() {
    $("#datainizio").datepicker({
                maxDate: new Date()
            });
    
    if ( $("#datafine").length > 0 ) {
                $("#datafine").datepicker({
                        maxDate: new Date(),
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
