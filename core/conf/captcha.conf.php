<?php

/*
 * (c)2013 Croce Rossa Italiana
 */

/*
 * Configurazione Recaptcha
 * ============================
 * 1. Andare su google.com/recaptcha ed ottenere una coppia di chiavi per il sito
 * 2. Inserire qui la coppia di chiavi ottenute
 * 3. Enjoy!
 */

$conf['recaptcha'] = [
	'private_key'	=>	'chiave_privata',
	'public_key'	=>	'chiave_pubblica'
];

/*
 * Configurazione SweetCaptcha
 * ============================
 * 1. Andare su http://sweetcaptcha.com/ ed ottenere una coppia di chiavi per il sito
 * 2. Inserire qui la coppia di chiavi ottenute
 * 3. Enjoy!
 */


define('SWEETCAPTCHA_APP_ID', 40115); // your application id (change me)
define('SWEETCAPTCHA_KEY', 'fcd594b67b534179d4de6150419080c6'); // your application key (change me)
define('SWEETCAPTCHA_SECRET', '54141ecc62b95f71f303f5f8f43755b7'); // your application secret (change me)
define('SWEETCAPTCHA_PUBLIC_URL', 'sweetcaptcha.php'); // public http url to this file

?>
