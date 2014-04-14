<?php

/*
 * ©2014 Croce Rossa Italiana
 */

controllaParametri(['id'], 'us.dash&err');

paginaApp([APP_SOCI , APP_PRESIDENTE , APP_OBIETTIVO]);

$d = $me->delegazioneAttuale();

$admin = (bool) $me->admin();

if (!$admin && $d->estensione == EST_UNITA) {
    redirect('errore.permessi&cattivo');
}

$excel = new Excel();
$i=0;

// intestazioni

if(isset($_GET['delegati'])){
        $excel->intestazione([
            'N.',
            'Comitato',
            'Estensione',
            'Indirizzo',
            'eMail',
            'Telefono',
            'Nome Delegato',
            'Cognome Delegato',
            'Telefono Delegato',
            'email Delegato'
            ]);
} else {
        $excel->intestazione([
            'N.',
            'Comitato',
            'Estensione',
            'Indirizzo',
            'eMail',
            'Telefono',
            'Nome Presidente',
            'Cognome Presidente',
            'Telefono Presidente',
            'email Presidente'
            ]);
}

if(isset($_GET['delegati'])){
    foreach ( $comitati as $com ) {

        $excel->aggiungiRiga([
            $i,
            $com->nome,
            $conf['est_obj'][$com->_estensione()],
            $com->formattato,
            $com->email,
            $com->telefono
            ]);

        $i++; 
    }
    $excel->genera("Delegati {$com->nomeCompleto()}.xls");
    
} else {
    $comitato = $_GET['id'];
    if ($admin) {
        $comitato = Nazionale::elenco()[0];
    } else {
        $comitato = GeoPolitica::daOid($comitato);
    }
    $ramo = new RamoGeoPolitico($comitato, ESPLORA_RAMI, EST_LOCALE);
    foreach ( $ramo as $com ) {
        $v = $com->unPresidente();
        if($v) {
            $excel->aggiungiRiga([
                $i,
                $com->nome,
                $conf['est_obj'][$com->_estensione()],
                $com->formattato,
                $com->email,
                $com->telefono,
                $v->nome,
                $v->cognome,
                $v->cellulare(),
                $v->email()
                ]);
        } else {
            $excel->aggiungiRiga([
                $i,
                $com->nome,
                $conf['est_obj'][$com->_estensione()],
                $com->formattato,
                $com->email,
                $com->telefono
                ]);
        }

        $i++;
    }
    $excel->genera("Presidenti {$comitato->nomeCompleto()}.xls");
}

    


$excel->download();
