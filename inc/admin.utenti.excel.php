<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$zip = new Zip();

foreach ( $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]) as $c ) {

    $excel = new Excel();
    
if(isset($_GET['eleatt'])||isset($_GET['elepass'])||isset($_GET['quoteno'])||isset($_GET['quotesi'])){
    $excel->intestazione([
        'Nome',
        'Cognome',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'C. Fiscale',
        'Ingresso in CRI'
    ]);
}else{
    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'EMail',
        'Cellulare',
        'Cell. Servizio'
    ]);
}
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
    }elseif(isset($_GET['eleatt'])){
        $time = $_GET['time'];
        $time = DT::daTimestamp($time);
        
        foreach ( $c->elettoriAttivi($time) as $v ) {
            
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->codiceFiscale,
            $v->ingresso()->format("d/m/Y")
        ]);
            
        }
    $excel->genera("Elettorato attivo {$c->nome}.xls");
    }elseif(isset($_GET['elepass'])){
        $time = $_GET['time'];
        $time = DT::daTimestamp($time);
        
        foreach ( $c->elettoriPassivi($time) as $v ) {
            
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->codiceFiscale,
            $v->ingresso()->format("d/m/Y")
        ]);
            
        }
    $excel->genera("Elettorato passivo {$c->nome}.xls");
    }if(isset($_GET['quoteno'])){
        foreach ( $c->quoteNo() as $v ) {

        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            $v->email,
            $v->cellulare,
            $v->cellulareServizio
        ]);

    }
    $excel->genera("Volontari quoteNo {$c->nome}.xls");
    }if(isset($_GET['quotesi'])){
        foreach ( $c->quoteSi() as $v ) {

        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            $v->email,
            $v->cellulare,
            $v->cellulareServizio
        ]);

    }
    $excel->genera("Volontari quoteSi {$c->nome}.xls");
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
}elseif(isset($_GET['eleatt'])){
   $zip->comprimi("Elettorato_attivo.zip"); 
}elseif(isset($_GET['elepass'])){
   $zip->comprimi("Elettorato_passivo.zip"); 
}elseif(isset($_GET['quoteno'])){
   $zip->comprimi("volontari_non_paganti.zip"); 
}elseif(isset($_GET['quotesi'])){
   $zip->comprimi("Volontari_paganti.zip"); 
}else{
    $zip->comprimi("Anagrafica_volontari.zip");
}
$zip->download();