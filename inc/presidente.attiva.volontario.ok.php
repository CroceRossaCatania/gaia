<?php
/*
* ©2013 Croce Rossa Italiana
*/
 
paginaApp([APP_SOCI, APP_PRESIDENTE]);

$admin = $me->admin();

$parametri = array('inputEmail', 'inputEmail2', 'vol');
controllaParametri($parametri, 'presidente.utenti&err');

$vol = Utente::id($_POST['vol']);
proteggiDatiSensibili($vol, [APP_SOCI, APP_PRESIDENTE]);

if ($vol->email) {
    redirect('presidente.utenti&emailGia');
}

$email = $_POST['inputEmail'];
$email = minuscolo($email);
$emailCheck = $_POST['inputEmail2'];
$emailCheck = minuscolo($emailCheck);

if ($email != $emailCheck) {
    redirect('presidente.utenti&emailDiff');
}

$vol->email = $email;
$password = generaStringaCasuale(8, DIZIONARIO_ALFANUMERICO);
$vol->cambiaPassword($password);

$e = new Email('registrazioneAttivazioneAccount', 'Attivazione account su Gaia');
$e->a           = $vol;
$e->_NOME       = $vol->nome;
$e->_PASSWORD   = $password;
$e->_ATTIVATORE = $me->nomeCompleto();
$e->invia();

redirect("presidente.utente.visualizza&att&id=$vol->id");


