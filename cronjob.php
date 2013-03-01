<?php

/*
 * ©2012 Croce Rossa Italiana
 */

require('./core.inc.php');

/* Sessione di cronjob */
$log = "\n\nCronjob iniziato: " . date('d-m-Y H:i:s') . "\n";

/* Le patenti in scadenza tra qui e 15 gg */
$patenti = TitoloPersonale::inScadenza(2700, 2709, 15); // Minimo id titolo, Massimo id titolo, Giorni

$n = 0;

/* Contiene gli id dei volontari già insuttati */
$giaInsultati = [];

foreach ( $patenti as $patente ) {
   
    $_v = $patente->volontario();
    
    /* Se l'ho già insultato... */
    if ( in_array($_v->id, $giaInsultati ) ) {
        continue; // Il prossimo...
    }
    
    /* Ricordati che l'ho insuttato */
    $giaInsultati[] = $_v->id;
    
    $m = new Email('patenteScadenza', 'Avviso patente CRI in scadenza');
    $m->a           = $_v;
    $m->_NOME       = $_v->nome;
    $m->_SCADENZA   = date('d-m-Y', $patente->fine);
    $m->invia();
    $n++;
}

$log .= "Inviate $n notifiche di scadenza patente\n";

/* Appende il file al log */
file_put_contents('upload/log/cronjob.txt', $log, FILE_APPEND);

/* Stampa il log a video */
echo "<pre>$log</pre>";