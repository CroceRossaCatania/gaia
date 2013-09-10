<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['turno'];
$t = new Turno($t);
$a = $t->attivita();

/* Se non posso partecipare torna alla scheda... */
if ( !$t->puoRichiederePartecipazione($me) ) {
    redirect('attivita.scheda&id=' . $a->id);
}

/* Crea la partecipazione */
$p = new Partecipazione();
$p->turno =          $t;
$p->volontario =     $me;
$p->generaAutorizzazioni();


/* Crea la email */

redirect('attivita.storico&okpending&id=' . $a->id);