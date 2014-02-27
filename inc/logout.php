<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/* Svuota eventuali variabili di sessioni */
$sessione->attenzione 				= null;
$sessione->adminMode  				= null;
$sessione->barcode	  				= null;
$sessione->ambito		  			= null;
$sessione->rimandaPrivatizzazione 	= null;
$sessione->logout();

?>

<div class="alert alert-block alert-success">
    <h4>Logout effettuato</h4>
    <p>A presto.</p>
</div>

<a href='?p=home'>Torna alla home</a>.

<?php 
    header("Refresh: 2; URL=/");
?>