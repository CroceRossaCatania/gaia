$(document).ready( function() {
    
    var limite = new Date();
    limite.setDate( limite.getDate() + minDateOffset );
    
    $("#dataInizio").datetimepicker({
        timeText: 'Alle:',
        hourText: 'Ore',
    	minuteText: 'Minuti',
    	currentText: 'Ora',
    	closeText: 'Ok',
        defaultTimezone: '+0100',
        minDate: limite
    });


});