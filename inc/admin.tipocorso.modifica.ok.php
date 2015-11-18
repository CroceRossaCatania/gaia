<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.tipocorso&err');
$t = $_GET['id'];

$t = TipoCorso::id($t);
$t->nome = maiuscolo( $_POST['inputNome'] );
$t->minimoPartecipanti = intval($_POST['inputMinimoPartecipanti']);
$t->massimoPartecipanti = intval($_POST['inputMassimoPartecipanti']);
$t->durata = intval($_POST['inputDurata']);
$t->giorni = intval($_POST['inputGiorni']);

$t->limitePerIscrizione = intval($_POST['inputLimitePerIscrizione']);
$t->qualifica =  $_POST['inputAttestato'];
$t->proporzioneAffiancamento =  intval($_POST['inputProporzioneAffiancamento']);
$t->punizione = intval($_POST['inputPunizione']);
$t->proporzioneIstruttori =  intval($_POST['inputProporzioneIstruttori']);

$t->ruoloAttestato = $_POST['inputRuoloAttestato'];
$t->ruoloDirettore = $_POST['inputRuoloDirettore'];
$t->ruoloDocenti = $_POST['inputRuoloDocenti'];
$t->ruoloAffiancamento = $_POST['inputRuoloAffiancamento'];
$t->ruoloDiscenti = $_POST['inputRuoloDiscenti'];

$t->abilitaNazionale = $_POST['abilitaNazionale'];
$t->abilitaRegionale = $_POST['abilitaRegionale'];
$t->abilitaProvinciale = $_POST['abilitaProvinciale'];
$t->abilitaLocale = $_POST['abilitaLocale'];

redirect('admin.tipocorso&mod');

?>
