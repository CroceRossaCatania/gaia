<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE,APP_CO, APP_OBIETTIVO]);

$zip = new Zip();

foreach ( $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE,APP_CO, APP_OBIETTIVO ]) as $c ) {

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
}elseif(isset($_GET['mass'])){
    $excel->intestazione([
        'Nome',
        'Cognome',
        'Data Nascita',
        'E-Mail',
        'Cellulare',
        'Cell. Servizio'
    ]);
}elseif(isset($_GET['riserva'])){
    $excel->intestazione([
        'Nome',
        'Cognome',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'C. Fiscale',
        'Inizio Riserva',
        'Fine Riserva',
        'Numero Protocollo',
        'Data Protocollo',
        'Motivazione'
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
    }elseif(isset($_GET['quoteno'])){
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
    $excel->genera("Volontari mancato pagamento quota {$c->nome}.xls");
    }elseif(isset($_GET['quotesi'])){
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
    $excel->genera("Volontari quota pagata {$c->nome}.xls");
    }elseif(isset($_GET['mass'])){
        $f = $_GET['t'];
        $f= new Titolo($f);
        $volontari =  $c->ricercaMembriTitoli([$f]);
            foreach($volontari as $volontario){
                $excel->aggiungiRiga([
                    $volontario->nome,
                    $volontario->cognome,
                    date('d/m/Y', $volontario->dataNascita),
                    $volontario->email,
                    $volontario->cellulare,
                    $volontario->cellulareServizio
                ]);
            }
       $excel->genera("Risultati in {$c->nomeCompleto()}.xls");
    }elseif(isset($_GET['riserva'])){
        foreach ( $c->membriRiserva() as $v ) {
        $r = $v->inRiserva();
        $r = $r[0];
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->codiceFiscale,
            date('d/m/Y',$r->inizio),
            date('d/m/Y',$r->fine),
            $r->protNumero,
            date('d/m/Y',$r->protData),
            $r->motivo
        ]);

    }
    $excel->genera("Volontari riserva {$c->nome}.xls");
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
   $zip->comprimi("Anagrafica volontari dimessi.zip"); 
}elseif(isset($_GET['giovani'])){
   $zip->comprimi("Anagrafica volontari giovani.zip"); 
}elseif(isset($_GET['eleatt'])){
   $zip->comprimi("Elettorato attivo.zip"); 
}elseif(isset($_GET['elepass'])){
   $zip->comprimi("Elettorato passivo.zip"); 
}elseif(isset($_GET['quoteno'])){
   $zip->comprimi("volontari quota non versata.zip"); 
}elseif(isset($_GET['quotesi'])){
   $zip->comprimi("Volontari quota versata.zip"); 
}elseif(isset($_GET['mass'])){
   $zip->comprimi("Volontari con titolo {$f->nome}.zip"); 
}elseif(isset($_GET['riserva'])){
   $zip->comprimi("Volontari in riserva {$f->nome}.zip"); 
}else{
    $zip->comprimi("Anagrafica_volontari.zip");
}
$zip->download();