<?php
 
/*
 * ©2014 Croce Rossa Italiana
 */

/*
 * === INSTALLAZIONE DI GAIA ===
 * Questa è una configurazione di esempio per Gaia.
 */
 
/* Configurazione del server SMTP */
$conf['email'] = [
 
 	// Usare SMTP?
	// true  => SMTP (vedi dettagli sotto)
	// false => php funzione mail()
 	'smtp'			=>	false,

 	// Configurazione SMTP
 	'host'			=>	'localhost',
    'username'      =>  'SMTP_USERNAME',
    'password'      =>  'SMTP_PASSWORD',
    'auth'			=>	true,
    'secure'		=>	'tls',

    // Debug?
    'debug'			=>	false

];