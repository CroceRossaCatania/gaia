$(document).ready( function() {
 
$("#inputDataNascita").datepicker();

    $("#cercaTitolo").keyup(function(){
       var query = $("#cercaTitolo").val();
       
       if ( query.length > 0 ) {
           $("#risultatiRicerca").show('fade', 500);
           $("#risultatiRicerca tbody").html('<tr class="info"><td colspan="2" class="cp"><i class="icon-spinner icon-spin"></i> Ricerca in corso...</td></tr>');

           api('titoli:cerca', {
               query:   query
           }, function(x) {
               $("#risultatiRicerca tbody").html('');
               for (i in x.risposta) {
                     $("#risultatiRicerca tbody").append('<tr><td><strong>' + x.risposta[i][1] + '</strong></td><td class="span2"><a class="btn btn-success span12" href="javascript:aggiungiTitolo(' + x.risposta[i][0] + ')"><i class="icon-plus"></i> Aggiungi</a></td></tr>');
          }
               if ( x.risposta.length == 0 ) {
                    $("#risultatiRicerca tbody").html('<tr class="warning"><td colspan="2" class="cp"><i class="icon-warning-sign"></i> Nessun titolo corrispondente alla ricerca.</td></tr>');
               }
           });
       } else {
           $("#risultatiRicerca").hide('fade', 500);
       }
       
    });
    
   
    _abilita_filtraggio("#cercaUtente", "#tabellaUtenti");


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
        		$("#step1Donazione").hide('fade', 500, function() {
				$("#step2Donazione").show(500);
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

function aggiungiTitolo (idTitolo) {
    $("#idTitolo").val(idTitolo);
    
    if ( $("[data-richiediDate]").length > 0 ) {
        $("#step1").hide('fade', 500, function() {
           $("#step2").show(500); 
           $("#dataInizio").datepicker({
                beforeShow: function (e) {
                    if ( $("#dataFine").length > 0 ) {
                        $("#dataInizio").datepicker('option', {
                            maxDate:    $("#dataFine").datepicker('getDate')
                        });   
                    }
                }
           });
           if ( $("#dataFine").length > 0 ) {
                $("#dataFine").datepicker({
                     beforeShow: function (e) {
                         if ( $("#dataInizio").length > 0 ) {
                             $("#dataFine").datepicker('option', {
                                 minDate:    $("#dataInizio").datepicker('getDate')
                             }); 
                         }
                     }
                }); 
           }

        }); 
    } else {
        $("#step2 form").submit();
    }
}