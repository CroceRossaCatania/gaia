<?php

/*
 * ©2014 Croce Rossa Italiana
 */

define("DEBUG", TRUE);

if (DEBUG) {
    ini_set('display_errors', true);
    error_reporting(E_ALL);
//    error_reporting(E_ALL&~E_NOTICE);
}

/* Modalità manutenzione */
if (file_exists('upload/setup/manutenzione')) {
    header('HTTP/1.1 307 Temporary Redirect');
    header('Location: docs/manutenzione.html');
    exit(0);
}

$_stopwatch = microtime(true);

require('./core.inc.php');

/* Attiva la gestione degli errori */
set_error_handler('gestore_errori');

/* Attiva il caching */
ob_start('ob_gzhandler');
ob_start('impostaTitoloDescrizione');

/* Sessione utente via cookie */
if ( isset($_COOKIE['sessione']) ) {
    $sid = $_COOKIE['sessione'];
} else {
    $sid = null;
}
$sessione = new Sessione($sid);
@setcookie('sessione', $sessione->id, time() + $conf['sessioni']['durata']);

/* Crea eventuale oggetto $me */
$me = $sessione->utente();

/* Registra dati transazione */
if ( $me->admin ) {
    ignoraTransazione();
} else {
    $identificato = (bool) ($me && $me->id);
    registraParametroTransazione('login', (int) $identificato);
    if ( $identificato )
        registraParametroTransazione('uid', $me->id);
}

/* Aggiorna la sessione con i miei dati... */
$sessione->ip       = $_SERVER['REMOTE_ADDR'];
$sessione->agent    = $_SERVER['HTTP_USER_AGENT'];

/* Flag dei selettori */
$_carica_selettore              = false;
$_carica_selettore_comitato     = false;
$_carica_selettore_discente     = false;
$_carica_selettore_docente     = false;
$_carica_selettore_docente_affiancamento     = false;
$_carica_selettore_direttore     = false;

/* Pagina da visualizzare */
$p = $_GET['p'];
if (!$p) { $p = 'home'; }
$_f = "./inc/$p.php";
if ( !file_exists($_f) ) {
	$_f = "./inc/errore.404.php";
}
nomeTransazione($p, 'web');

/*
 * Titolo e descrizione se non ridefiniti
 */
$_titolo        = 'Progetto Gaia - Croce Rossa Italiana';
$_descrizione   = 'Crediamo in una Croce Rossa Italiana che sa muoversi velocemente, più trasparente ed aperta a tutti';

?><!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns#">
  	<meta charset="utf-8" />
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>{_titolo}</title>
    <meta property="og:url" content="http://gaia.cri.it/?p=<?= $p ?>">
    <meta property="og:title" content="{_titolo}">
    <meta property="og:site_name" content="Progetto Gaia - Croce Rossa Italiana">
    <meta property="og:description" content="{_descrizione}">
    <meta property="og:image" content="http://gaia.cri.it/img/Emblema_CRI.png"/>
    <meta name="description" content="{_descrizione}">
    <meta name="author" content="Progetto Gaia - Croce Rossa Italiana">
    <link rel="shortcut icon" href="/img/favicon.ico" />

    <!-- JS e CSS compressi -->
    <link href="/assets/min/20151011/build/build.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="/assets/min/20151011/build/build.js"></script>

    <!-- Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js?hl=it" async defer></script>

	<!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
    
    <!--[if IE]>
        <link href="css/main-ie.css" rel="stylesheet" media="screen">
    <![endif]-->
    <!--[if IE 7]>
      <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
    <![endif]-->


  </head>
  <body>
      <?php /* Qui si include la pagina */ require($_f); ?>
  </body>
</html>
<?php
ob_end_flush(); 
header("Content-length: " . ob_get_length()); 
ob_end_flush();
