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
		var query = $("#sedeRegione").val();
		
		api('titoli:cerca', {
               query:   "c",
               t:       "2"
           }, function(x) {
				alert(x);
           });

		/*api('donazionesedi:cerca', {
            query:   query,
			req:     "regione",
			res:     "provincia"
		}, function(x) {
			
			$("#provincia").show(500);
		});*/
		
	});

	$("#sedeProvincia").on('change', function(){
		$("#citta").show(500);
	});

	$("#sedeCitta").on('change', function(){
		$("#ospedale").show(500);
	});

});
