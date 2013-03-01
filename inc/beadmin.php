<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/* Se c'è già un admin */
if ( Utente::listaAdmin() ) {
    redirect('me&spiacenteAdminEsistente');
} else {
    $me->admin = time();
    redirect('me&okTuttoFatto');
}
