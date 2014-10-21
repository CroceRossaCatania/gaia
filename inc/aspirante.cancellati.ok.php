<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
    redirect('utente.me');

// Se non ho ancora registrato il mio essere aspirante
if ( !($a = Aspirante::daVolontario($me)) )
    redirect('aspirante.registra');

$utente = $a->utente();

$m = new Email('cancellazioneAspirante', 'Cancellazione da Portale Gaia');
$m->a = $utente;
$m->_UTENTE = $utente->nome;
$m->invia();

$a->cancella();
$sessione->cancella();

redirect('');