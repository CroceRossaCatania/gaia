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
foreach ( $patenti as $patente ) {
    $m = new Email('patenteScadenza', 'Avviso patente CRI in scadenza');
    $m->a           = $patente->volontario();
    $m->_NOME       = $patente->volontario()->nome;
    $m->_PATENTE    = $patente->titolo()->nome;
    $m->_SCADENZA   = date('d-m-Y', $patente->fine);
    $m->invia();
    $n++;
}

$log .= "Inviate $n notifiche di scadenza patente\n";

/* Appende il file al log */
file_put_contents('log/cronjob.txt', $log, FILE_APPEND);

/* Stampa il log a video */
echo "<pre>$log</pre>";