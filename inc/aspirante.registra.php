<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE || Aspirante::daVolontario($me) )
	redirect('aspirante.home');

$a = new Aspirante;
$a->utente 	= $me;
$a->data 	= time();

$a->luogo = "{$me->indirizzo}, {$me->comuneResidenza}, {$me->CAPResidenza}";
$a->localizzaStringa($a->luogo);

$a->raggio = $a->trovaRaggioMinimo();

redirect('aspirante.localita');
