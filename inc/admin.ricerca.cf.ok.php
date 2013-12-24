<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri($_POST['inputCF'], 'admin.ricerca.cf&err');
$u = Utente::by('codiceFiscale', $_POST['inputCF']);
redirect('presidente.utente.visualizza&id='.$u);
?>
