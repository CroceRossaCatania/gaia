$(document).ready( function() {
 
$("#inputDataInizio").datetimepicker({
		timeText: 'Alle:',
    	hourText: 'Ore',
    	minuteText: 'Minuti',
    	currentText: 'Ora',
    	closeText: 'Ok',
        defaultTimezone: '+0100',
        minDate: new Date()
    });


});