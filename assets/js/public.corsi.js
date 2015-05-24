/**
 * (c)2014 Croce Rossa Italiana
 */

$(document).ready(function() {
    
    var eventsSource = [];
    
    function updateEvents(callback){
        
        var start = $('#calendario').fullCalendar('getCalendar').getView().start.toISOString();
        var end = $('#calendario').fullCalendar('getCalendar').getView().end.toISOString();
        console.log('....', start, ' -->', end);
        eventsSource = [];
        
        $("#icona-caricamento").removeClass('icon-calendar').addClass('icon-spinner').addClass('icon-spin');
        
        api('corsi', {
            inizio: start,
            fine:   end,
            type: $('#type').val(),
            provincia: $('#provincia').val()
        }, function (risposta) {
            
            var response = risposta.risposta.corsi;
            
            for ( var y in response ) {
                var tmp = {};
                tmp.id      = response[y].corso.id;
                tmp.title   = response[y].corso.nome;
                tmp.start   = response[y].inizio;
                tmp.end     = response[y].fine;
                tmp.color   = response[y].colore;
                
                eventsSource.push(tmp);
            }
            
            if (callback !== undefined) {
                callback(eventsSource);
            }
            $("#icona-caricamento").addClass('icon-calendar').removeClass('icon-spinner').removeClass('icon-spin');
            
        });
        
    }
    
    $('#type').change(function(evt){
        evt.preventDefault();
        //updateEvents();
        $('#calendario').fullCalendar('refetchEvents');
        return false;
    });
    
    $('#provincia').change(function(evt){
        evt.preventDefault();
        //updateEvents();
        $('#calendario').fullCalendar('refetchEvents');
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
        events: function(start, end, timezone, callback) {
            updateEvents(callback);
        }
        //events: eventsSource,
    });
    
    //updateEvents(start, end, timezone, callback);
    
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
