<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(['turno']);
$t = Turno::id($_GET['turno']);
$a = $t->attivita();
$c = $a->comitato();
$anno = (int) $t->inizio()->format('Y');

// Se quota non pagata e obbligo quota impostato
if ( ($c instanceOf Comitato or $c instanceOf Locale) 
	and $c->obbligoQuota and !$me->quota($anno) ) {
	redirect("attivita.errore.quota&id={$a->id}");
}

/* Se non posso partecipare torna alla scheda... */
if ( !$t->chiediPartecipazione($me) ) {
    redirect("attivita.scheda&id={$a->id}");
}

redirect("attivita.storico&okpending&id={$a->id}");
