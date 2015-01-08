<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
richiediComitato();

controllaParametri(['inputComitato', 'inputMotivo']);

$c = $_POST['inputComitato'];
if ( !$c ) { 
    redirect('utente.estensione');
}

$m = $_POST['inputMotivo'];
if ( !$m ){
	redirect('utente.estensione&motivo');
}
/* Cerco appartenenze al comitato specificato */
$f = Appartenenza::filtra([
  ['volontario',    $me],
  ['comitato',      $c]
]);

/* Se sono già appartenente *ora*,
 * restituisco errore
 */

foreach ( $f as $app ) {
    if ($app->attuale()) { 
        redirect('utente.estensione&e'); 
    } 
}
                                     
/*Se non sono appartenente allora avvio la procedura*/

$a = new Appartenenza();
$a->volontario  = $me->id;
$a->comitato    = $c;
$a->stato =     MEMBRO_EST_PENDENTE;
$a->timestamp = time();
$a->inizio    = time();
$a->fine      = time() + ANNO;

    
$e = new Estensione();
$e->stato = EST_INCORSO;
$e->appartenenza = $a;
$e->volontario = $me->id;
$e->motivo = $m;
$e->timestamp = time();
$e->cProvenienza = $me->unComitato()->id;

$sessione->inGenerazioneEstensione = time();
redirect('utente.estensioneRichiesta.stampa&id=' . $e->id);
