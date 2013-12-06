<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE || Aspirante::daVolontario($me) )
	redirect('aspirante.home');

$a = new Aspirante;
$a->utente 	= $me;
$a->data 	= time();

$a->localizzaStringa("{$me->indirizzo}, {$me->comuneResidenza}, {$me->CAPResidenza}");

$a->raggio = $a->trovaRaggioMinimo();

//redirect('aspirante.localita');
redirect('aspirante.home');