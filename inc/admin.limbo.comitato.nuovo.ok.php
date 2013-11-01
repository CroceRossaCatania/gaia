<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$v = $_GET['id'];
$c = $_POST['inputComitato'];
$t = DT::createFromFormat('d/m/Y', $_POST['dataingresso']);

$a = new Appartenenza();
$a->volontario  = $v;
$a->comitato    = $c;
$a->inizio      = $t->getTimestamp();
$a->fine        = PROSSIMA_SCADENZA;
$a->timestamp = time();
$a->stato     = MEMBRO_PENDENTE;
$a->conferma  = $me;
$v = new Volontario($v);
$v->stato = VOLONTARIO;

/* Genera e cambia la password casuale */
$password = Validazione::generaPassword();
$v->cambiaPassword($password);

$m = new Email('registrazioneFormatpass', 'Registrato su Gaia');
$m->a = $v;
$m->_NOME       = $v->nome;
$m->_PASSWORD   = $password;
$m->invia();

redirect('admin.limbo&nasp');