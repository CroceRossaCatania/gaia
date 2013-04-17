$(document).ready ( function() {
    $("#inizio").datetimepicker({
	timeText: 'Alle:',
	hourText: 'Ore',
	minuteText: 'Minuti',
	currentText: 'Ora',
	closeText: 'Ok',
                  defaultTimezone: '+0100',
        
                minDate: new Date(),
                        beforeShow: function (e) {
                            if ( $("#fine").length > 0 ) {
                                $("#inizio").datepicker('option', {
                                    maxDate:    $("#fine").datepicker('getDate')
                                });   
                            }
                        }
            });
    
    if ( $("#fine").length > 0 ) {
                $("#fine").datetimepicker({
                        timeText: 'Alle:',
                        hourText: 'Ore',
                        minuteText: 'Minuti',
                        currentText: 'Ora',
                        closeText: 'Ok',
                        defaultTimezone: '+0100',
                        
                        minDate: new Date(),
                        beforeShow: function (e) {
                            if ( $("#inizio").length > 0 ) {
                                $("#fine").datepicker('option', {
                                    minDate:    $("#inizio").datepicker('getDate')
                                }); 
                            }
                        }
                   }); 
              }
    $("#privacyGroup button").click( function() {
       $("#privacyGroup button").removeClass('active');
       $(this).addClass('active');
       $("#privacySwitch").val($(this).data('value'));
    });
});
