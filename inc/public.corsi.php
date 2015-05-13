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
    
    
    <div class="span9">
         <h4>Filtri</h4>
        <ul>
            <li>
                <input type="checkbox" value="sss">&nbsp;Cat 1
            </li>
            <li>
                <input type="checkbox" value="sss">&nbsp;Cat 2
            </li>
            <li>
                <input type="checkbox" value="sss">&nbsp;Dog 3
            </li>
        </ul>
         
         <ul>
            <input type="text" value="Lugo" /><i class="icon-plus"></i><br/>
            - Ravenna --- x<br/>
            - Ferrara --- x
        </ul>
        
         
         <hr/>
        
        <div id='calendar'></div>
    </div>
    
    <div class="span3" style="text-align: left">
  
        <h4>Se hai i permessi</h4>
        <nav>
            <a class="btn btn-danger" href="?p=formazione.corsi.crea">
                <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                Crea Corso
            </a>
        </nav>
        
       
        
        
        <ul>
            <li>
                Richieste Pendenti.<br/>
                viale 1<bR/>
            </li>
            <li>
                   I tuoi Corsi
                   <BR/>
                   corso 1<br/>
                   corso 2<br/>
                   piazza 3<br/>
            </li>
            
        </ul>
        
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
