<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$anno = date('Y', time());
$mese = date('m', time());
$inizio = mktime(0, 0, 0, $mese, 1, $anno);
$giorno = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);
$fine = mktime(0, 0, 0, $mese, $giorno, $anno);

$zip = new Zip();
$excel = new Excel();

$excel->intestazione([
    'Nome',
    'Cognome',
    'Data nascita',
    'Comitato'
]);

if (isset($_GET['com'])){
    $comitati = $me->comitatiApp (APP_PRESIDENTE);
    foreach($comitati as $comitato){
        $volontari = $comitato->membriAttuali();
        foreach($volontari as $v){
            $partecipazioni = $v->partecipazioni();
                foreach ( $partecipazioni as $part ) {
                    $auts = $part->autorizzazioni();
                    $turno = $part->turno()->id;
                    try { 
                            $t = new Turno($turno); 
                        } catch ( Errore $e ) { 
                            continue; 
                        }
                    $co = Coturno::filtra([['turno', $turno],['volontario', $v]]);
                    if ( $auts || $co ){ 
                        continue; 
                    }
                    if ( $part->turno()->inizio <= $inizio || $part->turno()->fine >= $fine ){ continue; }
                    $excel->aggiungiRiga([
                        $v->nome,
                        $v->cognome,
                        date('d/m/Y', $v->dataNascita),
                        $v->unComitato()->nomeCompleto()
                    ]);
                }
        }
        $excel->genera("Report volontari zero turni {$comitato->nome}.xls");
        $zip->aggiungi($excel);
    }
    
    
}
$zip->comprimi("Report volontari zero turni.zip"); 
$zip->download();