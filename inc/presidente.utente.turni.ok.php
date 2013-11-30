<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$id = $_GET['id'];
$v = Volontario::id($id);
$anno = date('Y', time());
$mese = date('m', time());
$inizio = mktime(0, 0, 0, $mese, 1, $anno);
$giorno = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);
$fine = mktime(0, 0, 0, $mese, $giorno, $anno);

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
                $turno = $part->turno();
                $co = Coturno::filtra([['turno', $turno],['volontario', $v]]);
                if ( !$auts && !$co ){ 
                    continue; 
                }
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
