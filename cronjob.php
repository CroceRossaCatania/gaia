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
    
    $ok = true;

    /* === 0. PERSISTE LA CACHE SU DISCO */
    cronjobEsegui(
        "Persistere la cache di Redis su disco",
        function() use ($cache) {
            if ( $cache ) {
                $cache->save();
            }
            return true;
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Cancellare file scaduti da disco e database",
        function() {
            $n = 0;
            foreach ( File::scaduti() as $f ) {
                $f->cancella(); $n++;
            }
            return "Cancellati $n file scaduti";
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Autorizzare estensioni dopo 30gg, con notifica ai volontari",
        function() {
            $n = 0;
            foreach (Estensione::daAutorizzare() as $e) {
                $e->auto(); $n++;
            }
            return "Concesse $n estensioni";
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Terminare estensioni",
        function() {
            $n = 0;
            foreach (Estensione::daChiudere() as $e) {
                $e->termina(); $n++;
            }
            return "Chiuse $n estensioni";
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Autorizzare trasferimenti dopo 30gg, notifica e chiusura sospesi e turni",
        function() {
            $n = 0;
            foreach (Trasferimento::daAutorizzare() as $t) {
                $t->auto(); $n++;
            }
            return "Autorizzati $n trasferimenti";
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Autorizzare riserve dopo 30gg",
        function() {
            $n = 0;
            foreach (Riserva::daAutorizzare() as $r) {
                $r->auto(); $n++;
            }
            return "Autorizzate $n riserve";
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Pulitura e fix delle attività",
        function() {
            $n = 0;
            $n = Attivita::pulizia();
            return "Fix di $n attività";
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Rigenerazione albero dei comitati",
        function() {
            GeoPolitica::rigeneraAlbero();
            return true;
        },
        $log, $ok
    );

    cronjobEsegui(
        "Chiusura validazioni scadute",
        function() {
            Validazione::chiudi();
            return true;
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Rimozione errori vecchi di una settimana",
        function() {
            $n = MErrore::pulisci();
            return "Cancellati log di {$n} errori in database";
        },
        $log, $ok
    );
    
    return $ok;
    
};
// =========== FINE CRONJOB GIORNALIERO


// =========== INIZIO CRONJOB SETTIMANALE
function cronjobSettimanale() {
    global $log, $db;
    
    $ok = true;
    
    cronjobEsegui(
        "Invio reminder patenti CRI in scadenza nei prossimi 15gg",
        function() {
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
            return "Inviate $n notifiche di scadenza patente";
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Invio reminder patenti civili in scadenza nei prossimi 15gg",
        function() {
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
            return "Inviate $n notifiche di scadenza patente civili";
        },
        $log, $ok
    );

    cronjobEsegui(
        "Invio del riepilogo per i presidenti",
        function() {
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
            return "Inviati $n promemoria ai presidenti";
        },
        $log, $ok
    );

    cronjobEsegui(
        "Invio reminder anniversario riserva a breve",
        function() {
            $n = 0;
            foreach (Riserva::inScadenza() as $r) {
                $n++;
                $m = new Email('promemoriaScadenzaRiserva', "Promemoria: Riserva in scadenza tra pochi giorni");
                $m->a           = $r->volontario();
                $m->_NOME       = $r->volontario()->nome;
                $m->_SCADENZA   = date('d-m-Y', $r->fine);
                $m->invia();
            }
            return "Notificate $n riserve in scadenza";
        },
        $log, $ok
    );
    
    cronjobEsegui(
        "Invio reminder scadenza estensione a breve",
        function() {
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
            return "Notificate $n estensioni in scadenza";
        },
        $log, $ok
    );
    
    return $ok;

};
// =========== FINE CRONJOB SETTIMANALE

// Vera e propria esecuzione del cronjob...
$ok = true;
$ok &= cronjobGiornaliero();
if ( $settimanale ) {
    $ok &= cronjobSettimanale();
    file_put_contents('upload/log/cronjob.settimanale.timestamp', $ora);
}

/* FINE CRONJOB */
$end = microtime(true);
$tempo = round($end - $start, 4);
$log .= "[FINE] Cronjob eseguito in {$tempo} secondi.\n";

if ( !$ok ) {
    $log .= "[:(] Nel log sono stati rilevati errori.\n";
}
/* Stampa il log a video */
echo "<pre>{$log}</pre>";

/* Appende il file al log */
file_put_contents('upload/log/cronjob.txt', "\n" . $log, FILE_APPEND);

/* Invia per email il log */
$m = new Email('mailTestolibero', ($ok ? 'REPORT cronjob' : 'ERRORE nel cronjob'));
$m->_TESTO = nl2br($log);
$m->invia();
