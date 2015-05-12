<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPubblica();

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
    <div id='calendar'></div>
        
    
    <pre>
    consultazione calendari, richiesta iscrizione: 
    - Corso per popolazione: senza login (raccolta dati anagrafici) 
    - Corso per soci Cri: con login (eredita accessi e qualifiche da GAIA)

    o (FRONTEND) Calendario: 
     Data e Luogo

     Tipologia di Corso

     Faculty  Requisiti di accesso (richiesta iscrizione al corso, con eventuale login per soci) PER

     Consultazione programma corso

     Info di contatto

     Eventuale possibilità di dovnload materiale

    </pre>
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
					start: '2015-02-01'
				},
				{
					title: 'Long Event',
					start: '2015-02-07',
					end: '2015-02-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2015-02-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2015-02-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2015-02-11',
					end: '2015-02-13'
				},
				{
					title: 'Meeting',
					start: '2015-02-12T10:30:00',
					end: '2015-02-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2015-02-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2015-02-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2015-02-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2015-02-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2015-02-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2015-02-28'
				}
			]
		});
		
	});

</script>
