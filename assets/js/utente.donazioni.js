$(document).ready( function() {
    
	$("#tipo").on('change', function(){
		$("#idDonazione").val(this.value);
    
		if ( $("[data-richiediDate]").length > 0 ) {
        		$("#step1").hide('fade', 500, function() {
				$("#step2").show(500);
				$("#data").datepicker({ maxDate: 0 });
			});
		} /*else {
        		$("#step2 form").submit();
	    	}*/
	});

	$("#sedeRegione").on('change', function(){
		$("#provincia").show(500);
	});

});
