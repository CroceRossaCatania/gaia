$(document).ready ( function() {
    
    $(".dti").datetimepicker({
        timeText: 'Alle:',
        hourText: 'Ore',
        minuteText: 'Minuti',
        currentText: 'Ora',
        closeText: 'Ok',
        defaultTimezone: '+0100',
        minDate: new Date()
    });

    $(".dtia").datetimepicker({
        timeText: 'Alle:',
        hourText: 'Ore',
        minuteText: 'Minuti',
        currentText: 'Ora',
        closeText: 'Ok',
        defaultTimezone: '+0100'
    });

    $(".modificabile input").change(function() {
        $("#salva").show(500); $("#nuovo").hide();
    });
    $(".modificabile input").keyup(function() {
        $("#salva").show(500); $("#nuovo").hide();
    });

});
