$(document).ready( function() {
 	var min = $("#inputData").attr('data-inizio');
    var max = $("#inputData").attr('data-fine');
    var x = max.split('/');
    var date = new Date(x[2], x[0], x[1]);
    if (date > new Date()) {
    	max = new Date();
    }
    $("#inputData").datepicker({
    	minDate: min,
    	maxDate: max
    });
});
