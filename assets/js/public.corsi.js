/**
 * (c)2014 Croce Rossa Italiana
 */

;$(document).ready(function() {
    'use strict';
    
    var eventsSource = [];
    var coordinates = {};
    
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            console.warning("Geolocation is not supported by this browser.");
        }
    }
    
    function showPosition(position) {
        coordinates = {latitude: position.coords.latitude, longitude: position.coords.longitude};
        console.log('coordinates', coordinates );
        //console.log("Latitude: " + position.coords.latitude +", Longitude: " + position.coords.longitude);
        $('#calendario').fullCalendar('refetchEvents');
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                console.warning("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                console.error("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                console.error("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                console.warning("An unknown error occurred.");
                break;
        }
    }
    
    $('[data-role="findme"]').click(function(){
        getLocation();
    });
    

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
            provincia: $('#provincia').val(),
            coords: coordinates
        }, function (risposta) {
            
            var response = risposta.risposta.corsi;
            
            for ( var y in response ) {
                var tmp = {};
                tmp.id      = response[y].corso.id;
                tmp.title   = response[y].corso.nome;
                tmp.start   = response[y].inizio;
                tmp.end     = response[y].fine;
                tmp.color   = response[y].colore;
                tmp.url   = response[y].url;
                
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
        defaultDate: new Date(),
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
