<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$zip = new Zip();

foreach ( $me->comitatiDiCompetenza() as $c ) {

    $excel = new Excel();

    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'EMail',
        'Cellulare',
        'Cell. Servizio'
    ]);

    if(isset($_GET['dimessi'])){
        foreach ( $c->membriDimessi as $v ) {

        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            $v->email,
            $v->cellulare,
            $v->cellulareServizio
        ]);

    }
    $excel->genera("Volontari dimessi {$c->nome}.xls");
    }elseif(isset($_GET['giovani'])){
        foreach ( $c->membriAttuali() as $v ) {
            $t = time()-GIOVANI;
            if ($t <=  $v->dataNascita){

        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            $v->email,
            $v->cellulare,
            $v->cellulareServizio
        ]);

    }
        }
    $excel->genera("Volontari giovani {$c->nome}.xls");
    }else{ 
        foreach ( $c->membriAttuali() as $v ) {

        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            $v->email,
            $v->cellulare,
            $v->cellulareServizio
        ]);

    }
    $excel->genera("Volontari {$c->nome}.xls");
    }
    
    
    $zip->aggiungi($excel);

}
if(isset($_GET['dimessi'])){
   $zip->comprimi("Anagrafica_volontari_dimessi.zip"); 
}elseif(isset($_GET['giovani'])){
   $zip->comprimi("Anagrafica_volontari_giovani.zip"); 
}else{
    $zip->comprimi("Anagrafica_volontari.zip");
}
$zip->download();