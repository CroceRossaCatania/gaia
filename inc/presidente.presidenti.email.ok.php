<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(['comitato', 'inputTesto', 'inputOggetto'], 'us.dash&err');

paginaApp([APP_PRESIDENTE, APP_SOCI]);
$d = $me->delegazioneAttuale();

if (!$me->admin && $d->estensione == EST_UNITA) {
    redirect('errore.permessi&cattivo');
}

$comitato = $_GET['comitato'];

$livello = 10;
if(isset($_POST['inputLivello'])) {
   $livello = $_POST['inputLivello']; 
}

$oggetto= $_POST['inputOggetto']; 
$testo = $_POST['inputTesto'];
if($me->admin()) {
    $comitato = Nazionale::elenco()[0];
} else {
    $comitato = GeoPolitica::daOid($comitato);
}

$ramo = new RamoGeoPolitico($comitato, ESPLORA_RAMI, $livello);

$destinatari = [];
foreach($ramo as $com) {
    $v = $com->unPresidente();
    if($v) {
        $destinatari[] = $v;
    }
}

$destinatari = array_unique($destinatari);

$m = new Email('mailTestolibero', ''.$oggetto);
$m->a = $destinatari;
$m->da = $me;
$m->_TESTO = $testo;
$m->accoda();

redirect('us.dash&email');

?>
