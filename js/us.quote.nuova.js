$(document).ready( function() {
 	var min = $("#inputData").attr('data-inizio');
    var max = $("#inputData").attr('data-fine');
    $("#inputData").datepicker({
    	minDate: min,
    	maxDate: max
    });
});
