<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(['turno']);
$t = Turno::id($_GET['turno']);
$a = $t->attivita();

/* Se non posso partecipare torna alla scheda... */
if ( !$t->chiediPartecipazione($me) ) {
    redirect("attivita.scheda&id={$a->id}");
}

redirect("attivita.storico&okpending&id={$a->id}");