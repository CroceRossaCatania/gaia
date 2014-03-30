$(document).ready( function() {
 	var min = $("#inputData").attr('data-min');
    $("#inputData").datepicker({
    	minDate: min,
    	maxDate: new Date()
    });
});
