<?php

/*
 * ©2014 Croce Rossa Italiana
 */

$_titolo = "Calencario dei Corsi";

?>
<style>
/* Dello stile veloce...*/
#calendar {
        max-width: 900px;
        margin: 0 auto;
}
</style>
<link href='/assets/css/fullcalendar.min.2.3.1.css' rel='stylesheet' />
<link href='/assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='/assets/js/libs/moment.min.js'></script>
<script src='/assets/js/fullcalendar.min.2.3.1.js'></script>
<script src='/assets/js/lang/it.js'></script>

<div class="row-fluid">
    
    <div class="span8">
        <div id='calendar'></div>
    </div>
    
    <div class="span4">
        <nav>
            <ul>
                <li>Crea nuovo corso (*verifica i permessi*)</li>
                <li>Crea nuovo corso (*verifica i permessi*)</li>
            </ul>
        </nav>
    </div>
        
</div>

<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			defaultDate: '2015-02-12',
                        locale: 'it',
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

</script>
