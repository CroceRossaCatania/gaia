$(document).ready ( function() {
    $(".dti").datetimepicker({
	timeText: 'Alle:',
	hourText: 'Ore',
	minuteText: 'Minuti',
	currentText: 'Ora',
	closeText: 'Ok',
    defaultTimezone: '+0100',
    minDate: new Date(),
    beforeShow: function (e) {
        if ( $(".dtf").length > 0 ) {
            $(".dti").datepicker('option', {
                maxDate:    $(".dtf").datepicker('getDate')
            });   
        }
    }
    });

    $(".dtf").datetimepicker({
	timeText: 'Alle:',
	hourText: 'Ore',
	minuteText: 'Minuti',
	currentText: 'Ora',
	closeText: 'Ok',
    defaultTimezone: '+0100',
    minDate: new Date(),
                    beforeShow: function (e) {
                        if ( $(".dti").length > 0 ) {
                            $(".dtf").datepicker('option', {
                                minDate:    $(".dti").datepicker('getDate')
                            }); 
                        }
                    }
    });
});
