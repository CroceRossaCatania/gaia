$(document).ready(function() {

    $('#calendario').fullCalendar({

    	/* Localizzazione in italiano */
    	monthNames: 		['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio',
    							'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
    	monthNamesShort: 	['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu',
								'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'],
		dayNames: 		 	['Domenica', 'Lunedì', 'Martedì', 'Mercoledì',
 								'Giovedì', 'Venerdì', 'Sabato'],
 		firstDay:			1, 
 		dayNamesShort: 		['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'],
 		buttonText: 		{
							    prev:     '&nbsp;&#9668;&nbsp;',
							    next:     '&nbsp;&#9658;&nbsp;',
							    prevYear: '&nbsp;&laquo;&nbsp;',
							    nextYear: '&nbsp;&raquo;&nbsp;',
							    today:    'oggi',
							    month:    'mese',
							    week:     'settimana',
							    day:      'giorno'
							},
		titleFormat: 		{
							    month: 'MMMM yyyy',                            
							    week: "d MMM[ yyyy]{ '&#8212;' d MMM yyyy}",
							    day: 'dddd d MMM yyyy'
							},
		columnFormat: 		{
							    month: 'ddd',
							    week: 'ddd d/M',
							    day: 'dddd d/M'
							},
		timeFormat: 		{
							    agenda: 'H:mm{ - H:mm}',
							    '': 'H(:mm)'            
							},
		axisFormat: 		'H:mm',
		defaultView: 		'basicWeek',
		allDaySlot:   		false, 

		header:  			{
							    left:   'title',
							    //center: '',
							    right:  'month,basicWeek today prev,next'
							}, 

		/*
		 * Funzione adattatore che comunica con le API
		 */
        events: function ( inizio, fine, callback ) {

        	$("#icona-caricamento")
        		.removeClass('icon-calendar')
        		.addClass('icon-spinner').addClass('icon-spin');

            inizio = new Date(inizio);
            fine   = new Date(fine);
            var sinizio = inizio.toISOString();
            var sfine   = fine.toISOString();
            api('attivita', {
                inizio: sinizio,
                fine:   sfine
            },
            function (risposta) {


            	risposta = risposta.risposta;
            	for ( var y in risposta ) {
            		risposta[y].id		= risposta[y].turno.id;
            		risposta[y].title	= risposta[y].turno.nome + ", " + risposta[y].attivita.nome;
            		risposta[y].start	= risposta[y].inizio;
            		risposta[y].end		= risposta[y].fine;
            		risposta[y].color   = risposta[y].colore;
            	}

	        	$("#icona-caricamento")
	        		.addClass('icon-calendar')
	        		.removeClass('icon-spinner').removeClass('icon-spin');

                callback(risposta);
            });
        }



    });

});
