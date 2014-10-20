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
$i=1;

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
    if($me->admin() || $me->presidenziante()) {
        $area = $_GET['id'];
    } else {
        $area = $d->dominio;
        if($area != $_GET['id']) {
            redirect('errore.permessi&cattivo');
        }
    }

    if($me->admin()) {
        $comitato = Nazionale::elenco()[0];
    } else {
        $comitato = $d->comitato();
    }

    $ramo = new RamoGeoPolitico($comitato);

    foreach ( $ramo as $com ) {

        $delegato = null;
        $delegati = Delegato::filtra([
            ['comitato', $com->oid()],
            ['dominio', $area],
            ['applicazione', APP_OBIETTIVO]
            ]);
        foreach($delegati as $_d) {
            if($_d->attuale()) {
                $delegato = $_d->volontario();
                break;
            }
        }

        if($delegato) {
            $excel->aggiungiRiga([
                $i,
                $com->nome,
                $conf['est_obj'][$com->_estensione()],
                $com->formattato,
                $com->email,
                $com->telefono,
                $delegato->nome,
                $delegato->cognome,
                $delegato->cellulare(),
                $delegato->email()
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
    $excel->genera("Delegati Area {$area} {$comitato->nomeCompleto()}.xls");
    
} else {
    $comitato = $_GET['id'];
    if ($admin) {
        $comitato = Nazionale::elenco()[0];
    } else {
        $comitato = GeoPolitica::daOid($comitato);
    }
    $ramo = new RamoGeoPolitico($comitato, ESPLORA_RAMI, EST_LOCALE);
    foreach ( $ramo as $com ) {
        if($com->superiore() && $com->superiore()->nomeCompleto() == $com->nomeCompleto()) {
            continue;
        }
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
