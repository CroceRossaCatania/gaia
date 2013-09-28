<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$anno = date('Y', $_GET['time']);
$mese = date('m', $_GET['time']);
$inizio = mktime(0, 0, 0, $mese, 1, $anno);
$giorno = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);
$fine = mktime(0, 0, 0, $mese, $giorno, $anno);

if (isset($_GET['com'])){
    $zip = new Zip();
    $comitati = $me->comitatiApp (APP_PRESIDENTE);
        foreach($comitati as $comitato){
            $excel = new Excel();
            $excel->intestazione([
                'Nome',
                'Cognome',
                'Data nascita',
                'Comitato'
            ]);
            $volontari = $comitato->membriAttuali();
            foreach($volontari as $v){
                $partecipazioni = $v->partecipazioni();
                $x=0;
                foreach ($partecipazioni as $part){
                    if ($x==0){
                        if ( $part->turno()->inizio >= $inizio && $part->turno()->fine <= $fine ){
                            $auts = $part->autorizzazioni();
                            if ($auts[0]->stato == AUT_OK){
                                $x=1;
                            }
                            $turno = $part->turno();
                            $co = Coturno::filtra([['turno', $turno],['volontario', $v]]);
                            if ($co){
                                $x=1;
                            }
                        }
                    }
                }

                if ( $x==0 ){
        
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
    $zip->comprimi("Report volontari zero turni.zip"); 
    $zip->download();
    }elseif (isset($_GET['unit'])){
        $comitato = new Comitato ($_GET['c']);
        $excel = new Excel();
        $excel->intestazione([
            'Nome',
            'Cognome',
            'Data nascita',
            'Comitato'
        ]);
        $volontari = $comitato->membriAttuali();
        foreach($volontari as $v){
            $partecipazioni = $v->partecipazioni();
            $x=0;
            foreach ($partecipazioni as $part){
                if ($x==0){
                    if ( $part->turno()->inizio >= $inizio && $part->turno()->fine <= $fine ){
                        $auts = $part->autorizzazioni();
                        if ($auts[0]->stato == AUT_OK){
                            $x=1;
                        }
                        $turno = $part->turno();
                        $co = Coturno::filtra([['turno', $turno],['volontario', $v]]);
                        if ($co){
                            $x=1;
                        }
                    }
                }
            }

            if ( $x==0 ){
    
                $excel->aggiungiRiga([
                    $v->nome,
                    $v->cognome,
                    date('d/m/Y', $v->dataNascita),
                    $v->unComitato()->nomeCompleto()
                ]);
            }
         
        }  
        $excel->genera("Report volontari zero turni {$comitato->nome}.xls");
        $excel->download();
    }
    