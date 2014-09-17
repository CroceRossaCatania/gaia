<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));

$a = $_GET['id'];
$a = Attivita::id($a);

paginaAttivita($a);

$zip = new Zip();


/*
 * 1. Creo un resonoconto, elenco dei turni 
 */
$t = new Excel();
$t->intestazione([
    "Attività", "Nome turno", "Inizio", "Fine", "Partecipanti"
]);

/*
 * 2. Creo un resoconto dettagliato con partecipanti
 */
$r = new Excel();
$r->intestazione([
    "Attività", "Nome turno", "Inizio", "Fine", "Elenco Partecipanti"
]);

/*
 * 3. Per ogni turno, creo il resoconto
 */
$i = 0;
foreach ( $a->turni() as $turno ) {
    
    $i++;
    $partecipazioni = $turno->partecipazioniStato();
    
    $t->aggiungiRiga([
        $a->nome,
        $turno->nome,
        $turno->inizio()->format('d-m-Y H:i'),
        $turno->fine()  ->format('d-m-Y H:i'),
        count($partecipazioni)
    ]);
    
    $f = new Excel();
    $f->intestazione([
       "Nome", "Cognome", "D. Nascita", "Email", "Cellulare", "Firma"
    ]);

    $ri = '';
    foreach ( $partecipazioni as $p ) {
        $v = $p->volontario();
        $f->aggiungiRiga([
            $v->nome,
            $v->cognome,
            date('d-m-Y', $v->dataNascita),
            $v->email,
            $v->cellulare()
        ]);
        $ri .= '<li>' . $v->nomeCompleto() . ' (' . $v->cellulare() . ")</li>";
    }

    $r->aggiungiRiga([
        $a->nome,
        $turno->nome,
        $turno->inizio()->format('d-m-Y H:i'),
        $turno->fine()  ->format('d-m-Y H:i'),
        "<ul>{$ri}</ul>"
    ], true);

    $f->genera("{$i}. {$turno->nome}, {$turno->inizio()->format('d-m-Y H.i')}.xls");
    $zip->aggiungi($f);
    
}

$t->genera("0. Elenco dei turni.xls");
$zip->aggiungi($t);

$r->generaHTML("0. Elenco dei turni con partecipanti.html");
$zip->aggiungi($r);

$ora = new DT;
$zip->comprimi("Attivita {$a->nome} aggiornata al {$ora->format('d-m-Y H.i')}.zip");

$zip->download();