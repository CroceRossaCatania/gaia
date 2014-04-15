<?php

paginaPrivata();

global $sessione;
if ( !$sessione->utente()->admin) {
        redirect('errore.permessi');
    }

/* Entra nella magica admin mode... */
$sessione->adminMode	= null;
$sessione->ambito 		= null;

redirect();

?>
