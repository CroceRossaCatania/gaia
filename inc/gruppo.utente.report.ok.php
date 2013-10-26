<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$id = $_GET['id'];
$v = Volontario::id($id);
$inizio = DT::createFromFormat('d/m/Y', $_POST['datainizio']);
$fine = DT::createFromFormat('d/m/Y', $_POST['datafine']);
$inizio = $inizio->getTimestamp();
$fine = $fine->getTimestamp();

$excel = new Excel();

$excel->intestazione([
    'Nome',
    'Cognome',
    'Data nascita',
    'Comitato',
    'Attività',
    'Obiettivo',
    'Turno',
    'Inizio',
    'Fine'
]);

$partecipazioni = $v->partecipazioni();
            foreach ( $partecipazioni as $part ) {
                $auts = $part->autorizzazioni();
                if ( !$auts ){ continue; }
                if ( $part->turno()->inizio <= $inizio || $part->turno()->fine >= $fine ){ continue; }
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            date('d/m/Y', $v->dataNascita),
            $v->unComitato()->nomeCompleto(),
            $part->attivita()->nome,
            $part->attivita()->area()->obiettivo,
            $part->turno()->nome,
            date('d/m/Y H:i', $part->turno()->inizio),
            date('d/m/Y H:i', $part->turno()->fine),
        ]);
    }
$excel->genera('Report turni volontario.xls');
$excel->download();
