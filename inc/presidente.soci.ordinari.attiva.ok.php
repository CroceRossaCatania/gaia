<?php

paginaApp([APP_SOCI , APP_PRESIDENTE ]);
paginaPrivata();
controllaParametri(['id'], 'presidente.soci.ordinari&err');

$u = Utente::id($_POST['id']);

proteggiDatiSensibili($u, [APP_SOCI , APP_PRESIDENTE]);

if(!$u->modificabileDa($me)) {
    redirect('errore.permessi&cattivo');
}

if($u->stato == VOLONTARIO) {
    redirect('errore.permessi&cattivo');   
}

$attuale = $u->appartenenzaAttuale();

if($attuale->stato != MEMBRO_ORDINARIO) {
    redirect('errore.permessi&cattivo');
}

$data = DT::createFromFormat('d/m/Y', $_POST['inputData']);

if($data < $attuale->inizio()) {
    redirect('presidente.soci.ordinari&err');
}

$comitato = $attuale->comitato;

$attuale->fine = $data->getTimestamp();
$attuale->stato = MEMBRO_ORDINARIO_PROMOSSO;

$u->stato = VOLONTARIO;

$app = new Appartenenza();
$app->stato = MEMBRO_VOLONTARIO;
$app->volontario = $u;
$app->comitato = $comitato;
$app->inizio = $data->getTimestamp();
$app->fine = PROSSIMA_SCADENZA;
$app->timestamp   = time();
$app->conferma  = $me;

if($u->email) {
    $m = new Email('passaggioVolontario', 'Avvenuto passaggio a Socio Attivo');
    $m->a = $u;
    $m->da = $me;
    $m->_NOME       = $u->nome;
    $m->_COMITATO   = $app->comitato()->nomeCompleto();
    $m->_DATA       = $data->format('d/m/Y');
    $m->invia();
}

redirect('presidente.soci.ordinari&attivo');

?>

