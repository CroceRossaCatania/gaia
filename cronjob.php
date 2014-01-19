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
	"\n\n{$leggibile}, ACCESSO BLOCCATO\n" .
	    print_r($_SERVER, true),
	FILE_APPEND);
     die("Non posso lanciare il cronjob più spesso di ogni 23 ore. " .
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
    global $log, $db, $cache;

    /* === 0. PERSISTE LA CACHE SU DISCO */
    if ( $cache ) {
        $cache->save();
    }
    $log .= "Persiste la cache di Redis sul disco\n";

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


    /* === 3. AUTORIZZO ESTENSIONI DOPO 30 GG E NOTIFICO AL VOLONTARIO*/
    $n = 0;
    foreach (Estensione::daAutorizzare() as $e) {
        $e->auto(); $n++;
    }
    $log .= "Concesse $n estensioni\n";


    /* === 4. TERMINO ESTENSIONI */
    $n = 0;
    foreach (Estensione::daChiudere() as $e) {
        $e->termina(); $n++;
    }
    $log .= "Chiuse $n estensioni\n";


    /* === 5. AUTORIZZO TRASFERIMENTI DOPO 30GG - NOTIFICO E CHIUDO SOSPESI E TURNI */
    $n = 0;
    foreach (Trasferimento::daAutorizzare() as $t) {
        $t->auto(); $n++;
    }
    $log .= "Autorizzati $n trasferimenti\n";


    /* === 6. DIMETTO DOPO 1 ANNO DI RISEVA SENZA RIENTRO */


    /* === 7. AUTORIZZO RISERVE DOPO 30GG */
    $n = 0;
    foreach (Riserva::daAutorizzare() as $r) {
        $r->auto(); $n++;
    }
    $log .= "Autorizzate $n riserve\n";

    /* === 8. PULITURA E FIX ATTIVITA' */
    $n = 0;
    $n = Attivita::pulizia();
    $log .= "Fix di $n attività\n";

    /* === 9. RIGENERO L'ALBERO DEI COMITATI */
    GeoPolitica::rigeneraAlbero();
    $log .= "Rigenerato l'albero dei comitati\n";

    /* === 10. CHIUDE LE VALIDAZIONI SCADUTE */
    Validazione::chiudi();
    $log .= "Chiuse le validazioni scadute\n";

    /* === 11. RESETTA CONTATORI PER API KEYS */
    $n = 0;
    foreach ( APIKey::elenco() as $c ) {
        $n++;
        $c->oggi = 0;
    }
    $log .= "Resettati limiti giornalieri di {$n} chiavi API\n";
    
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
        $z = $a + $b;
        if ( $z == 0 ) { continue; }
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


    /* === 4. REMINDER 1 ANNO DI RISERVA TRA POCHI GG */
    $n = 0;
    foreach (Riserva::inScadenza() as $r) {
        $n++;
        $m = new Email('promemoriaScadenzaRiserva', "Promemoria: Riserva in scadenza tra pochi giorni");
        $m->a           = $r->volontario();
        $m->_NOME       = $r->volontario()->nome;
        $m->_SCADENZA   = date('d-m-Y', $r->fine);
        $m->invia();
    }
    $log .= "Notificate $n riserve in scadenza\n";


    /* === 5. REMINDER SCADENZA ESTENSIONE TRA POCHI GG */
    $n = 0;
    foreach (Estensione::inScadenza() as $e) {
        $n++;
        $m = new Email('promemoriaScadenzaEstensione', "Promemoria: Estensione in scadenza tra pochi giorni");
        $m->a           = $e->volontario();
        $m->_NOME       = $e->volontario()->nome;
        $m->_COMITATO   = $e->appartenenza()->comitato()->nomeCompleto();
        $m->_SCADENZA   = date('d-m-Y', $e->appartenenza()->fine);
        $m->invia();
    }
    $log .= "Notificate $n estensioni in scadenza\n";

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
$m->_TESTO = nl2br($log);
$m->invia();
