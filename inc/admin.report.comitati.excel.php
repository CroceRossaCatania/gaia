<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();

$excel = new Excel();

$excel->intestazione([
        'N.',
        'Comitato',
        'Estensione',
        'Indirizzo',
        'eMail',
        'Telefono',
        'P. Iva',
        'C. F.'
        ]);
$i=0;

foreach ( Nazionale::elenco() as $naz ) {
    $i++;
    $excel->aggiungiRiga([
        $i,
        $naz->nome,
        $conf['est_obj'][$naz->_estensione()],
        $naz->formattato,
        $naz->email,
        $naz->telefono,
        $naz->piva(),
        $naz->cf()
        ]);

    foreach ( Regionale::elenco() as $reg ) {
        $i++;
        $excel->aggiungiRiga([
            $i,
            $reg->nome,
            $conf['est_obj'][$reg->_estensione()],
            $reg->formattato,
            $reg->email,
            $reg->telefono,
            $reg->piva(),
            $reg->cf()
            ]);
    }

    foreach ( Provinciale::elenco() as $pro ) {
        if ( Regionale::by('nome', $pro->nome)) { continue; }
        $i++;
        $excel->aggiungiRiga([
            $i,
            $pro->nome,
            $conf['est_obj'][$pro->_estensione()],
            $pro->formattato,
            $pro->email,
            $pro->telefono,
            $pro->piva(),
            $pro->cf()
            ]);
    }

    foreach ( Locale::elenco() as $com ) {
        if ( Provinciale::by('nome', $com->nome)) { continue; }
        $i++;
        $excel->aggiungiRiga([
            $i,
            $com->nome,
            $conf['est_obj'][$com->_estensione()],
            $com->formattato,
            $com->email,
            $com->telefono,
            $com->piva(),
            $com->cf()
            ]);
    }

}
        
$excel->genera("Report comitati .xls");
$excel->download();

?>
