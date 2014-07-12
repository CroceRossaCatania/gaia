$(document).ready( function() {

	var dt = new Date;
	dt.setFullYear(dt.getFullYear() - 14)
	$( "#inputDataNascita" ).datepicker({ maxDate: dt });
 
});
