<?php

/*
 * ©2013 Croce Rossa Italiana
 */


controllaParametri(array('comitato'), 'presidente.utenti&errGen');

$c = $_GET['comitato'];
$c = Comitato::id($c);
$i=0;
paginaApp([APP_SOCI , APP_PRESIDENTE, APP_OBIETTIVO], [$c]);


if(isset($_GET['dimessi'])){
    
    $excel = new Excel();

    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'Data Nascita',
        'Luogo Nascita',
        'eMail',
        'Cellulare',
        'Cell. Servizio'
        ]);

    foreach ( $c->membriDimessi(MEMBRO_DIMESSO) as $v ) {
        
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->email,
            $v->cellulare,
            $v->cellulareServizio
            ]);
        
    }

    $excel->genera('Volontari_dimessi.xls');
    $excel->download();

}elseif(isset($_GET['giovani'])){
    
    $excel = new Excel();

    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'Data Nascita',
        'Luogo Nascita',
        'eMail',
        'Cellulare',
        'Cell. Servizio'
        ]);

    foreach ( $c->membriGiovani as $v ) {
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->email,
            $v->cellulare,
            $v->cellulareServizio
            ]);
        
    }

    $excel->genera('Volontari_giovani.xls');
    $excel->download();

}elseif(isset($_GET['eleatt'])){
    $time = $_GET['time'];
    $time = DT::daTimestamp($time);

    $excel = new Excel();

    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'Ingresso in CRI'
        ]);

    foreach ( $c->elettoriAttivi($time) as $v ) {
        
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->ingresso()->format("d/m/Y")
            ]);
        
    }

    $excel->genera("Elettorato_attivo.xls");
    $excel->download();

}elseif(isset($_GET['elepass'])){
    $time = $_GET['time'];
    $time = DT::daTimestamp($time);

    $excel = new Excel();

    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'Ingresso in CRI'
        ]);

    foreach ( $c->elettoriPassivi($time) as $v ) {
        
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->ingresso()->format("d/m/Y")
            ]);
        
    }

    $excel->genera("Elettorato_passivo.xls");
    $excel->download();

}elseif(isset($_GET['quoteno'])){
    
    $excel = new Excel();

    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'Ingresso in CRI'
        ]);

    foreach ( $c->quoteNo() as $v ) {
        
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->ingresso()->format("d/m/Y")
            ]);
        
    }

    $excel->genera('Volontari_quoteNo.xls');
    $excel->download();

}elseif(isset($_GET['quotesi'])){
    
    $excel = new Excel();

    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'Ingresso in CRI'
        ]);

    foreach ( $c->quoteSi() as $v ) {
        
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->ingresso()->format("d/m/Y")
            ]);
        
    }

    $excel->genera('Volontari_quoteSi.xls');
    $excel->download();

}elseif(isset($_GET['riserva'])){
    $excel = new Excel();
    
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
    
    foreach ( $c->membriRiserva() as $r ) {
        $v = $r->volontario();
        
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
    $excel->genera("Volontari riserva.xls");
    $excel->download();
    
}elseif(isset($_GET['estesi'])){
    $excel = new Excel();
    
    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita'
        ]);
    $estesi = array_diff( $c->membriAttuali(MEMBRO_ESTESO), $c->membriAttuali(MEMBRO_VOLONTARIO) );
    foreach ( $estesi as $v ) {

        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita
            ]);

    }
    $excel->genera("Volontari estesi.xls");
    $excel->download();
    
}elseif(isset($_GET['soci'])){
    $excel = new Excel();
    $excel->intestazione([
            'N.',
            'Nome',
            'Cognome',
            'Data Nascita',
            'Luogo Nascita',
            'Provincia Nascita',
            'C. Fiscale',
            'Indirizzo Res.',
            'Civico',
            'Comune Res.',
            'Cap Res.',
            'Provincia Res.',
            'eMail',
            'eMail Servizio',
            'Cellulare',
            'Cell. Servizio',
            'Data ingresso CRI'
            ]);
    foreach ( $c->membriAttuali(MEMBRO_VOLONTARIO) as $v ) {

        $i++; 
        $excel->aggiungiRiga([
            $i,
            $v->nome,
            $v->cognome,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->codiceFiscale,
            $v->indirizzo,
            $v->civico,
            $v->comuneResidenza,
            $v->CAPResidenza,
            $v->provinciaResidenza,
            $v->email,
            $v->emailServizio,
            $v->cellulare,
            $v->cellulareServizio,
            $v->ingresso()->format("d/m/Y")
            ]);

    }
    $excel->genera("Elenco Soci.xls");
    $excel->download();
    
}elseif(isset($_GET['ordinari'])){
    $excel = new Excel();
    $excel->intestazione([
            'N.',
            'Nome',
            'Cognome',
            'Data Nascita',
            'Luogo Nascita',
            'Provincia Nascita',
            'C. Fiscale',
            'Indirizzo Res.',
            'Civico',
            'Comune Res.',
            'Cap Res.',
            'Provincia Res.',
            'eMail',
            'eMail Servizio',
            'Cellulare',
            'Cell. Servizio',
            'Data ingresso CRI'
            ]);
    foreach ( $c->membriOrdinari() as $v ) {

        $i++; 
        $excel->aggiungiRiga([
            $i,
            $v->nome,
            $v->cognome,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->codiceFiscale,
            $v->indirizzo,
            $v->civico,
            $v->comuneResidenza,
            $v->CAPResidenza,
            $v->provinciaResidenza,
            $v->email,
            $v->emailServizio,
            $v->cellulare,
            $v->cellulareServizio,
            $v->ingresso()->format("d/m/Y")
            ]);

    }
    $excel->genera("Elenco Soci Ordinari.xls");
    $excel->download();
    
}elseif(isset($_GET['ordinaridimessi'])){
    $excel = new Excel();
    $excel->intestazione([
            'N.',
            'Nome',
            'Cognome',
            'Data Nascita',
            'Luogo Nascita',
            'Provincia Nascita',
            'C. Fiscale',
            'Indirizzo Res.',
            'Civico',
            'Comune Res.',
            'Cap Res.',
            'Provincia Res.',
            'eMail',
            'eMail Servizio',
            'Cellulare',
            'Cell. Servizio',
            'Data ingresso CRI'
            ]);
    foreach ( $c->membriOrdinariDimessi() as $v ) {

        $i++; 
        $excel->aggiungiRiga([
            $i,
            $v->nome,
            $v->cognome,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->codiceFiscale,
            $v->indirizzo,
            $v->civico,
            $v->comuneResidenza,
            $v->CAPResidenza,
            $v->provinciaResidenza,
            $v->email,
            $v->emailServizio,
            $v->cellulare,
            $v->cellulareServizio,
            $v->ingresso()->format("d/m/Y")
            ]);

    }
    $excel->genera("Elenco Soci Ordinari Dimessi.xls");
    $excel->download();
    
}else{
    
    $excel = new Excel();

    $excel->intestazione([
        'Nome',
        'Cognome',
        'C. Fiscale',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'eMail',
        'Cellulare',
        'Cell. Servizio'
        ]);

    foreach ( $c->membriAttuali() as $v ) {
        
        $excel->aggiungiRiga([
            $v->nome,
            $v->cognome,
            $v->codiceFiscale,
            date('d/m/Y', $v->dataNascita),
            $v->comuneNascita,
            $v->provinciaNascita,
            $v->email,
            $v->cellulare,
            $v->cellulareServizio
            ]);
        
    }

    $excel->genera('Volontari.xls');
    $excel->download();
}