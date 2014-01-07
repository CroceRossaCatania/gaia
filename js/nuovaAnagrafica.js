$(document).ready( function() {

	var dt = new Date;
	dt.setYear(dt.getYear() - 14)
	$( "#inputDataNascita" ).datepicker({ maxDate: dt });
 
});
