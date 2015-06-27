$(document).ready( function() {
 
$("#data").datepicker({ maxDate: 0 });

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
