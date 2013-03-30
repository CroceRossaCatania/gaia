$(document).ready ( function() {
    $(".dt").datetimepicker({
	timeText: 'Alle:',
	hourText: 'Ore',
	minuteText: 'Minuti',
	currentText: 'Ora',
	closeText: 'Ok',
        defaultTimezone: '+0100'
    });
    
    $("#privacyGroup button").click( function() {
       $("#privacyGroup button").removeClass('active');
       $(this).addClass('active');
       $("#privacySwitch").val($(this).data('value'));
    });
});
