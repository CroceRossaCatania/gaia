$(document).ready( function() {
 
$("#inputData").datetimepicker({
	timeText: 'Alle:',
	hourText: 'Ore',
	minuteText: 'Minuti',
	currentText: 'Ora',
	closeText: 'Ok',
    defaultTimezone: '+0100',
    maxDate: 0,
    setDate: new Date()
});

});