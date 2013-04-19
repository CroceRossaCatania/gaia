<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

/* Invia la mail */
$m = new Email('registrazioneAspirante', 'Grazie futuro volontario');
$m->a = $sessione->utente();
$m->_NOME       = $sessione->utente()->nome;
$m->invia();
$sessione->utente = NULL;
redirect('grazieAspirante');

?>
