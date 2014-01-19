<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(['turno']);
$t = $_GET['turno'];
$t = Turno::id($t);
$a = $t->attivita();

/* Se non posso partecipare torna alla scheda... */
if ( !$t->chiediPartecipazione($me) ) {
    redirect("attivita.scheda&id={$a->id}");
}

redirect("attivita.storico&okpending&id={$a->id}");