<?php

paginaPrivata();

global $sessione;
if ( !$sessione->utente()->supporto) {
        redirect('errore.permessi');
    }

/* Entra nella magica supporto mode... */
$sessione->supportMode = time();
$sessione->ambito = null;

redirect();

?>
