/**
 * (c)2014 Croce Rossa Italiana
 */

$(document).ready(function() {
    $('#calendario').fullCalendar({
    	/* Localizzazione in italiano
    	monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
    	monthNamesShort: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'],
        dayNames: ['Domenica', 'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato'],
 	firstDay: 1, 
 	dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'],
        buttonText: {
            prev:     '&nbsp;&#9668;&nbsp;',
            next:     '&nbsp;&#9658;&nbsp;',
            prevYear: '&nbsp;&laquo;&nbsp;',
            nextYear: '&nbsp;&raquo;&nbsp;',
            today:    'oggi',
            month:    'mese',
            week:     'settimana',
            day:      'giorno'
        },
        
	titleFormat: {
            month: 'MMMM yyyy',                            
            week: "d MMM[ yyyy]{ '&#8212;' d MMM yyyy}",
            day: 'dddd d MMM yyyy'
        },
	columnFormat: {
            month: 'ddd',
            week: 'ddd d/M',
            day: 'dddd d/M'
        },
        timeFormat: {
            agenda: 'H:mm{ - H:mm}',
            '': 'H(:mm)'            
        },
       
        axisFormat: 		'H:mm',
        allDaySlot:   		false, 
         */
        header:  {
            left:   'title',
            //center: '',
            right:  'month,basicWeek today prev,next'
        }, 
        
        defaultView: 		'basicWeek',
        allDaySlot:   		false, 
        /*
         * Funzione adattatore che comunica con le API
         */
        
         events: {
            url: '/api.php',
            type: 'POST',
            data: {
                custom_param1: 'something',
                custom_param2: 'somethingelse'
            },
            error: function() {
                alert('there was an error while fetching events!');
            },
            color: 'yellow',   // a non-ajax option
            textColor: 'black' // a non-ajax option
        },
        
        
        events: function(start, end, timezone, callback) {
            $("#icona-caricamento").removeClass('icon-calendar').addClass('icon-spinner').addClass('icon-spin');
            inizio = new Date(start);
            fine   = new Date(end);
            var sinizio = inizio.toISOString();
            var sfine   = fine.toISOString();
            api('attivita', {
                inizio: sinizio,
                fine:   sfine
            }, function (risposta) {
                risposta = risposta.risposta.turni;
                for ( var y in risposta ) {
                    risposta[y].id      = risposta[y].turno.id;
                    risposta[y].title	= risposta[y].turno.nome + ", " + risposta[y].attivita.nome;
                    risposta[y].start	= risposta[y].inizio;
                    risposta[y].end	= risposta[y].fine;
                    risposta[y].color   = risposta[y].colore;
                }

                $("#icona-caricamento").addClass('icon-calendar').removeClass('icon-spinner').removeClass('icon-spin');
                callback(risposta);
            });
        }
    });
});
