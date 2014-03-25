<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(['area', 'inputTesto', 'inputOggetto'], 'obiettivo.dash&err');

paginaApp([APP_OBIETTIVO , APP_PRESIDENTE]);
$d = $me->delegazioneAttuale();

if ($d->estensione == EST_UNITA) {
    redirect('errore.permessi&cattivo');
}

if($me->admin() || $me->presidenziante()) {
    $area = $_GET['area'];
} else {
    $area = $d->dominio;
    if($area != $_GET['area']) {
        redirect('errore.permessi&cattivo');
    }
}

$livello = 0;
if(isset($_POST['inputLivello'])) {
   $livello = $_POST['inputLivello']; 
}

$oggetto= $_POST['inputOggetto']; 
$testo = $_POST['inputTesto'];
$comitato = $d->comitato();

$ramo = new RamoGeoPolitico($comitato, ESPLORA_RAMI, $livello);

$destinatari = [];
foreach($ramo as $comitato) {
    $delegati = Delegato::filtra([
        ['comitato', $comitato->oid()],
        ['dominio', $area],
        ['applicazione', APP_OBIETTIVO]
        ]);
    foreach($delegati as $_d) {
        if($_d->attuale()) {
            $destinatari[] = $_d->volontario();
        }
    }
}

$destinatari = array_unique($destinatari);

$m = new Email('mailTestolibero', ''.$oggetto);
$m->a = $destinatari;
$m->da = $me;
$m->_TESTO = $testo;
$m->accoda();

redirect('obiettivo.dash&email');

?>
