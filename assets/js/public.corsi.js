/**
 * (c)2014 Croce Rossa Italiana
 */

$(document).ready(function() {
    $('#calendario').fullCalendar({
    	
        
        header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
        },
        defaultDate: '2015-02-12',
        editable: true,

        /*
         * Funzione adattatore che comunica con le API
         */
        eventLimit: true, // allow "more" link when too many events
        events: function(start, end, timezone, callback) {
            $("#icona-caricamento").removeClass('icon-calendar').addClass('icon-spinner').addClass('icon-spin');
            inizio = new Date(start);
            fine   = new Date(end);
            var sinizio = inizio.toISOString();
            var sfine   = fine.toISOString();
            api('corsi', {
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
    
    $(".chosen-select").chosen({max_selected_options: 5});

});
