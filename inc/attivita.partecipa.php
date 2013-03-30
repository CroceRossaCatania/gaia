<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['turno'];
$t = new Turno($t);
$a = $t->attivita();

/* Se non posso partecipare torna alla scheda... */
if ( !$t->puoPartecipare($me) ) {
    redirect('attivita.scheda&id=' . $a->id);
}

/* Crea la partecipazione */
$p = new Partecipazione();
$p->turno =          $t;
$p->volontario =     $me;
$p->generaAutorizzazioni();

redirect('attivita.storico&okpending&id=' . $a->id);