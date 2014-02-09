<?php
 
/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * === INSTALLAZIONE DI GAIA ===
 * Questa è una configurazione di esempio per Gaia.
 * 1. Copiare il file in /core/conf/smtp.conf.php.
 * 2. Modificare SMTP_USERNAME e SMTP_PASSWORD.
 */
 
/* Configurazione del server SMTP */
$conf['smtp'] = [
 
 	'host'			=>	'localhost',
    'username'      =>  'SMTP_USERNAME',
    'password'      =>  'SMTP_PASSWORD',
    'auth'			=>	true,
    'debug'     	=>  false
 
];