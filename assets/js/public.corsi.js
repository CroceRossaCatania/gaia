/**
 * (c)2014 Croce Rossa Italiana
 */

$(document).ready(function() {
    
    var eventsSource = [];
    
    /*
    function(start, end, timezone, callback) {
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
    */
    
    function updateEvents(){
        
        // console.log('updateEvents');
        var moment = $('#calendario').fullCalendar('getDate');
        // alert("The current date of the calendar is " + moment.format());
        console.log(moment);
    
        $('#calendario').fullCalendar('removeEventSource', eventsSource);
        $('#calendario').fullCalendar('refetchEvents');
        
        inizio = new Date('2015-01-01');
        fine   = new Date('2015-12-31');
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
                
                eventsSource.push(risposta[y]);
            }
            
            $('#calendario').fullCalendar('addEventSource', eventsSource)
            $('#calendario').fullCalendar('refetchEvents');
            
            $("#icona-caricamento").addClass('icon-calendar').removeClass('icon-spinner').removeClass('icon-spin');
            //callback(risposta);
        });
    }
    
    $('#type').change(function(evt){
        evt.preventDefault();
        updateEvents();
        return false;
    });
    
    $('#provincia').change(function(evt){
        evt.preventDefault();
        updateEvents();
        return false;
    });
    
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
        events: eventsSource
    });
    
    updateEvents();
    
    $(".chosen-select").chosen({max_selected_options: 5});

/*
function reloadCal() {
    newSource = '/feeds/calendarjson.ashx?e1=' + $('#e1').is(':checked')
        + '&e2=' + $('#e2').is(':checked');
    $('#calendar').fullCalendar('removeEventSource', source)
    $('#calendar').fullCalendar('refetchEvents')
    $('#calendar').fullCalendar('addEventSource', newSource)
    $('#calendar').fullCalendar('refetchEvents');
    source = newSource;
}


    function loadCal() {
    $('#calendar').fullCalendar({
        events: source,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        eventRender: function (event, element)
        {
            element.attr('href', '#');
        }
    });
}
*/

});
