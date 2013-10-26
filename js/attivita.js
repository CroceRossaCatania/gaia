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

		allDaySlot:   		false, 

		header:  			{
							    left:   'title',
							    //center: '',
							    right:  'month,basicWeek today prev,next'
							}, 

                events: function ( inizio, fine, callback ) {
                    inizio = new Date(inizio);
                    fine   = new Date(fine);
                    var sinizio = inizio.toISOString();
                    var sfine   = fine.toISOString();
                    api('attivita', {
                        inizio: sinizio,
                        fine:   sfine
                    },
                    function (risposta) {
                        callback(risposta.response);
                    });
                }



    });

});
