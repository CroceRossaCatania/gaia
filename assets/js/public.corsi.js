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
            events: [
                    {
                            title: 'All Day Event',
                            url: '?p=formazione.corsi.corso',
                            start: '2015-02-01'
                    },
                    {
                            title: 'Long Event',
                            start: '2015-02-07',
                            url: '?p=formazione.corsi.corso',
                            end: '2015-02-10'
                    },
                    {
                            id: 999,
                            title: 'Repeating Event',
                            url: '?p=formazione.corsi.corso',
                            start: '2015-02-09T16:00:00'
                    },
                    {
                            id: 999,
                            title: 'Repeating Event',
                            url: '?p=formazione.corsi.corso',
                            start: '2015-02-16T16:00:00'
                    },
                    {
                            title: 'Conference',
                            start: '2015-02-11',
                            url: '?p=formazione.corsi.corso',
                            end: '2015-02-13'
                    },
                    {
                            title: 'Meeting',
                            start: '2015-02-12T10:30:00',
                            url: '?p=formazione.corsi.corso',
                            end: '2015-02-12T12:30:00'
                    },
                    {
                            title: 'Lunch',
                            url: '?p=formazione.corsi.corso',
                            start: '2015-02-12T12:00:00'
                    },
                    {
                            title: 'Meeting',
                            url: '?p=formazione.corsi.corso',
                            start: '2015-02-12T14:30:00'
                    },
                    {
                            title: 'Happy Hour',
                            url: '?p=formazione.corsi.corso',
                            start: '2015-02-12T17:30:00'
                    },
                    {
                            title: 'Dinner',
                            url: '?p=formazione.corsi.corso',
                            start: '2015-02-12T20:00:00'
                    },
                    {
                            title: 'Birthday Party',
                            url: '?p=formazione.corsi.corso',
                            start: '2015-02-13T07:00:00'
                    },
                    {
                            title: 'Google',
                            url: '?p=formazione.corsi.corso',
                            start: '2015-02-28'
                    }
            ]
    });
});
