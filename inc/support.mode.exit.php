<?php

paginaPrivata();

global $sessione;
if ( !$sessione->utente()->supporto) {
        redirect('errore.permessi');
    }

/* Esci dalla magica support mode... */
$sessione->supportMode	= null;
$sessione->ambito 		= null;

redirect();

?>
