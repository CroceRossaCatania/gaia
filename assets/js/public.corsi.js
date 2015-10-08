/**
 * (c)2014 Croce Rossa Italiana
 */

;
$(document).ready(function () {
    'use strict';

    var eventsSource = [];
    var coordinates = {};

    function getLocation() {

        function showPosition(position) {
            coordinates = {latitude: position.coords.latitude, longitude: position.coords.longitude};
            $('#geo_dati').html("(" + position.coords.latitude + ", " + position.coords.longitude + ")");
            //console.log("Latitude: " + position.coords.latitude +", Longitude: " + position.coords.longitude);
            
            $('#calendario').fullCalendar('removeEvents');
            $('#calendario').fullCalendar('refetchEvents');
        }

        function showError(error) {
            switch (error.code) {
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

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            console.warning("Geolocation is not supported by this browser.");
        }
    }

    function updateEvents(callback) {

        var start = $('#calendario').fullCalendar('getCalendar').getView().start.toISOString();
        var end = $('#calendario').fullCalendar('getCalendar').getView().end.toISOString();
        console.log('....', start, ' -->', end);
        eventsSource = [];

        $("#icona-caricamento").removeClass('icon-calendar').addClass('icon-spinner').addClass('icon-spin');

        api('corsi', {
            inizio: start,
            fine: end,
            type: $('#type').val(),
            provincia: $('#provincia').val(),
            coords: coordinates
        }, function (risposta) {

            var response = risposta.risposta.corsi;
            eventsSource = [];
            
            for (var y in response) {
                var tmp = {};
                tmp.id = response[y].corso.id;
                tmp.title = response[y].corso.nome;
                tmp.start = response[y].inizio;
                tmp.end = response[y].fine;
                tmp.color = response[y].colore;
                tmp.url = response[y].url;

                eventsSource.push(tmp);
            }

            if (callback !== undefined) {
                callback(eventsSource);
            }
            $("#icona-caricamento").addClass('icon-calendar').removeClass('icon-spinner').removeClass('icon-spin');

        });

    }


    $('[data-role="findme"]').click(function () {
        getLocation();
    });

    $(".chosen-select").chosen({max_selected_options: 5});

    $('#type').change(function (evt) {
        evt.preventDefault();
        //updateEvents();
        $('#calendario').fullCalendar('removeEvents');
        $('#calendario').fullCalendar('refetchEvents');
        return false;
    });

    $('#provincia').change(function (evt) {
        evt.preventDefault();
        //updateEvents();
        $('#calendario').fullCalendar('removeEvents');
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
        events: function (start, end, timezone, callback) {
            updateEvents(callback);
        }
    });
    
});