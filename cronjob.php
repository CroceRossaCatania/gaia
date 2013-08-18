<?php

/*
 * ©2013 Croce Rossa Italiana
 * CRONJOB - Esegue le operazioni pianificate,
 * Giornaliere e settimanali
 */

require './core.inc.php';
set_time_limit(0);

/*
 * ====== SICUREZZA ======
 * Evita lancio cronjob troppo frequente
 */
$limite = 3600 * 23; // 23 ore
$ora 	= (int) time(); $leggibile = date('d-m-Y H:i:s');
$ultimo = (int) @file_get_contents('upload/log/cronjob.giornaliero.timestamp');
if ( $ultimo && ($ora - $ultimo) < $limite ) {
     // 1. Memorizza tentativo negato nel log
     file_put_contents('upload/log/cronjob.log',
         "\n\nERRORE: Tentativo negato alle {$leggibile}",
	FILE_APPEND);
     // 2. Memorizza dati di connessione sul log
     file_put_contents('upload/log/cronjob.errori',
	"\n\n{$leggibile}, ACCESSO BLOCCATO" .
	    print_r($_SERVER, true),
	FILE_APPEND);
     die("Non posso lanciare il cronjob più spesso di ogni 23 ore." .
         "L'incidente verrà segnalato.");
}
// Aggiorna il timestamp dell'ultima esecuzione
file_put_contents('upload/log/cronjob.giornaliero.timestamp', $ora);
// Controlla se sia il caso di eseguire il settimanale...
$limite = (3600 * 24 * 7) - 3600; // 7 giorni meno un'ora
$settimanale = (int) @file_get_contents('upload/log/cronjob.settimanale.timestamp');
if ( !$settimanale || ($ora - $settimanale) > $limite ) {
    $logS .= "[!] ESECUZIONE SETTIMANALE PROGRAMMATA (son passati 7 giorni)\n";
    $settimanale = true;
} else {
    $logS = '';
    $settimanale = false;
}

/*
 * ====== AVVIO DEL CRONJOB ======
 */
$start = microtime(true);
$log = date('d-m-Y H:i:s') . " CRONJOB INIZIATO\n{$logS}";


// =========== INIZIO CRONJOB GIORNALIERO
function cronjobGiornaliero()  {
    global $log, $db;

    /* === 1. CANCELLA FILE SCADUTI DA DISCO E DATABASE */
    $n = 0;
    foreach ( File::scaduti() as $f ) {
        $f->cancella(); $n++;
    }
    $log .= "Cancellati $n file scaduti\n";


    /* === 2. CANCELLA SESSIONI SCADUTE DA DATABASE */
    $n = 0;
    foreach ( Sessione::scadute() as $s ) {
        $s->cancella(); $n++;
    }
    $log .= "Cancellate $n sessioni scadute\n";


};
// =========== FINE CRONJOB GIORNALIERO


// =========== INIZIO CRONJOB SETTIMANALE
function cronjobSettimanale() {
    global $log, $db;

    /* === 1. PATENTI CRI IN SCADENZA */
    /* Le patenti in scadenza tra qui e 15 gg */
    $patenti = TitoloPersonale::inScadenza(2700, 2709, 15); // Minimo id titolo, Massimo id titolo, Giorni
    $n = 0;
    $giaInsultati = [];
    foreach ( $patenti as $patente ) {
        $_v = $patente->volontario();
        if ( in_array($_v->id, $giaInsultati ) ) {
            continue; // Il prossimo...
        }
        $giaInsultati[] = $_v->id;
        $m = new Email('patenteScadenza', 'Avviso patente CRI in scadenza');
        $m->a           = $_v;
        $m->_NOME       = $_v->nome;
        $m->_SCADENZA   = date('d-m-Y', $patente->fine);
        $m->invia();
        $n++;
    }
    $log .= "Inviate $n notifiche di scadenza patente\n";

    /* === 2. PATENTI CRI IN SCADENZA */
    /* Patenti civili in scadenza da qui a 15 giorni*/
    $patenti = TitoloPersonale::inScadenza(70, 77, 15); // Minimo id titolo, Massimo id titolo, Giorni
    $n = 0;
    $giaInsultati = [];
    foreach ( $patenti as $patente ) {
        $_v = $patente->volontario();
        if ( in_array($_v->id, $giaInsultati ) ) {
            continue; // Il prossimo...
        }
        $giaInsultati[] = $_v->id;
        $m = new Email('patenteScadenzaCivile', 'Avviso patente Civile in scadenza');
        $m->a = $_v;
        $m->_NOME = $_v->nome;
        $m->_SCADENZA = date('d-m-Y', $patente->fine);
        $m->invia();
        $n++;
    }
    $log .= "Inviate $n notifiche di scadenza patente civili\n";

    /* === 3. RIEPILOGO PRESIDENTE */
    $n = 0;
    foreach ( Comitato::elenco() as $comitato ) {
        $a = count($comitato->appartenenzePendenti());
        $b = count($comitato->titoliPendenti());    
        $c = $a + $b;
        if ( $c == 0 ) { continue; }
        foreach ( $comitato->volontariPresidenti() as $presidente ) {
            $m = new Email('riepilogoPresidente', "Promemoria: Ci sono {$c} azioni in sospeso");
            $m->a       = $presidente;
            $m->_NOME       = $presidente->nomeCompleto();
            $m->_COMITATO   = $comitato->nomeCompleto();
            $m->_APPPENDENTI= $a;
            $m->_TITPENDENTI= $b;
            $m->invia();
            $n++;
        }
    }
    $log .= "Inviati $n promemoria ai presidenti\n";

};
// =========== FINE CRONJOB SETTIMANALE

// Vera e propria esecuzione del cronjob...
cronjobGiornaliero();
if ( $settimanale ) {
    cronjobSettimanale();
    file_put_contents('upload/log/cronjob.settimanale.timestamp', $ora);
}

/* FINE CRONJOB */
$end = microtime(true);
$tempo = $end - $start;
$log .= "FINE (eseguito in {$tempo} secondi)\n";

/* Stampa il log a video */
echo "<pre>$log</pre>";

/* Appende il file al log */
file_put_contents('upload/log/cronjob.txt', "\n" . $log, FILE_APPEND);

/* Invia per email il log */
$m = new Email('mailTestolibero', 'Report cronjob');
$dest = new stdClass();
$dest->nome     = 'Servizi';
$dest->email    = 'supporto@gaiacri.it';
$m->a = $dest;
$m->_TESTO = nl2br($log);
$m->invia();
