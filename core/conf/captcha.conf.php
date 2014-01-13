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
	'private_key'	=>	'6LfSLOoSAAAAACnzayjuZvzaShgnZSF2r5I3qsgy',
	'public_key'	=>	'6LfSLOoSAAAAAJY6lJL0IVSLg-ZYdFpZfFiTOW_F'
];

/*
 * Configurazione SweetCaptcha
 * ============================
 * 1. Andare su http://sweetcaptcha.com/ ed ottenere una coppia di chiavi per il sito
 * 2. Inserire qui la coppia di chiavi ottenute
 * 3. Enjoy!
 */


define('SWEETCAPTCHA_APP_ID', 40003); // your application id (change me)
define('SWEETCAPTCHA_KEY', '20895eb5d86e336b0309e2c6d49d8c3a'); // your application key (change me)
define('SWEETCAPTCHA_SECRET', '6dae5e70dc91be03f3efd80fbec90f27'); // your application secret (change me)
define('SWEETCAPTCHA_PUBLIC_URL', 'sweetcaptcha.php'); // public http url to this file

?>
