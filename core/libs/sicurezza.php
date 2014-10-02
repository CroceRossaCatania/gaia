<?php

/*
 * ©2012 Croce Rossa Italiana
 */

function criptaPassword ( $password ) {
    $password = sha1 ( md5 ( $password ) . '@CroceRossa' );
    return $password;
}

function debugOnly() {
    global $conf;
    if (!$conf['debug']) {
        throw new Errore(1009);
    }
}

/*
 * Usare per proteggere in una pagina i dati sensibili
 * di un volontario
 */
function proteggiDatiSensibili( $volontario, $app = [APP_PRESIDENTE] ) {
    global $me;
    if ( $me->admin() ) { return true; }
    if ( $volontario->modificabileDa($me) ) { return true; }
    $comitati = $me->comitatiApp($app);
    $comitatiVolontario = $volontario->comitati(SOGLIA_APPARTENENZE);
    if ($comitatiVolontario) {
        foreach ( $comitatiVolontario as $comitato ) {
            if (in_array($comitato, $comitati)) {
                return true;
            }
        }
    }
    $ultimoComitato = $volontario->ultimaAppartenenza(MEMBRO_DIMESSO);
    if ($ultimoComitato) {
        $ultimoComitato = $ultimoComitato->comitato();
        if (in_array($ultimoComitato, $comitati)) {
            return true;
        }
    }

    redirect('errore.permessi&cattivo');
}

/**
 * Usare per proteggere in una pagina i veicoli
 * @param $veicolo id del veicolo
 * @param $app di riferimento
 * @return ritorna true or false
 */
function proteggiVeicoli( $veicolo, $app = [APP_PRESIDENTE] ) {
    global $me;
    if ( $me->admin() ) { return true; }

    $comitati = $me->comitatiApp($app,false);
    $comitato = $veicolo->comitato;
    $comitato = GeoPolitica::daOid($comitato);
    if (in_array($comitato, $comitati)) {
        return true;
    }

    redirect('errore.permessi&cattivo');
}

/**
 * Usare per proteggere in una pagina gli autoparchi
 * @param $autoparco id dell'autoparco
 * @param $app di riferimento
 * @return ritorna true or false
 */
function proteggiAutoparco( $autoparco, $app = [APP_PRESIDENTE] ) {
    global $me;
    if ( $me->admin() ) { return true; }

    $comitati = $me->comitatiApp($app,false);
    $comitato = $autoparco->comitato;
    $comitato = GeoPolitica::daOid($comitato);
    if (in_array($comitato, $comitati)) {
        return true;
    }

    redirect('errore.permessi&cattivo');
}