$(document).ready( function() {

	$("#inputSedeSITRegione").on('change', function(){
		$("#SedeSITProvincia").hide();
		$("#SedeSITCitta").hide();
		$("#SedeSITOspedale").hide();
		$('#inputSedeSITProvincia').empty();
		$('#inputSedeSITCitta').empty();
		$('#inputSedeSIT').empty();

		var query = $("#inputSedeSITRegione").val();
		api('donazionesedi:cerca', {
			query:   query,
			req:     "regione",
			res:     "provincia"
		}, function(x) {
			$('#inputSedeSITProvincia').append('<option selected="selected" disabled=""></option>');
			$.each( x.risposta, function( index, value ){
				$('#inputSedeSITProvincia').append('<option value="'+value+'">'+value+'</option>');
			});
			$("#SedeSITProvincia").show(500);
        });
	});

	$("#inputSedeSITProvincia").on('change', function(){
		$("#SedeSITCitta").hide();
		$("#SedeSITOspedale").hide();
		$('#inputSedeSITCitta').empty();
		$('#inputSedeSIT').empty();

		var query = $(this).val();
		api('donazionesedi:cerca', {
			query:   query,
			req:     "provincia",
			res:     "citta"
		}, function(x) {
			$('#inputSedeSITCitta').append('<option selected="selected" disabled=""></option>');
			$.each( x.risposta, function( index, value ){
				$('#inputSedeSITCitta').append('<option value="'+value+'">'+value+'</option>');
			});
			$("#SedeSITCitta").show(500);
        });
	});

	$("#inputSedeSITCitta").on('change', function(){
		$("#SedeSITOspedale").hide();
		$('#inputSedeSIT').empty();

		var query = $(this).val();
		api('donazionesedi:cerca', {
			query:   query,
			req:     "citta",
			res:     "nome"
		}, function(x) {
			$('#inputSedeSIT').append('<option selected="selected" disabled=""></option>');
			$.each( x.risposta, function( index, value ){
				$('#inputSedeSIT').append('<option value="'+index+'">'+value+'</option>');
			});
			$("#SedeSITOspedale").show(500);
        });
	});


	$("#tipo").on('change', function(){
		$("#idDonazione").val(this.value);
    
		if ( $("[data-richiediDate]").length > 0 ) {
        		$("#step1").hide('fade', 500, function() {
				$("#step2").show(500);
				$("#data").datepicker({ maxDate: 0 });
			});
		}
	});

	$("#sedeRegione").on('change', function(){
		$("#provincia").hide();
		$("#citta").hide();
		$("#ospedale").hide();
		$('#sedeProvincia').empty();
		$('#sedeCitta').empty();
		$('#sede').empty();

		var query = $("#sedeRegione").val();
		api('donazionesedi:cerca', {
			query:   query,
			req:     "regione",
			res:     "provincia"
		}, function(x) {
			$('#sedeProvincia').append('<option selected="selected" disabled=""></option>');
			$.each( x.risposta, function( index, value ){
				$('#sedeProvincia').append('<option value="'+value+'">'+value+'</option>');
			});
			$("#provincia").show(500);
        });
	});

	$("#sedeProvincia").on('change', function(){
		$("#citta").hide();
		$("#ospedale").hide();
		$('#sedeCitta').empty();
		$('#sede').empty();

		var query = $(this).val();
		api('donazionesedi:cerca', {
			query:   query,
			req:     "provincia",
			res:     "citta"
		}, function(x) {
			$('#sedeCitta').append('<option selected="selected" disabled=""></option>');
			$.each( x.risposta, function( index, value ){
				$('#sedeCitta').append('<option value="'+value+'">'+value+'</option>');
			});
			$("#citta").show(500);
        });
	});

	$("#sedeCitta").on('change', function(){
		$("#ospedale").hide();
		$('#sede').empty();

		var query = $(this).val();
		api('donazionesedi:cerca', {
			query:   query,
			req:     "citta",
			res:     "nome"
		}, function(x) {
			$('#sede').append('<option selected="selected" disabled=""></option>');
			$.each( x.risposta, function( index, value ){
				$('#sede').append('<option value="'+index+'">'+value+'</option>');
			});
			$("#ospedale").show(500);
        });
	});

});
