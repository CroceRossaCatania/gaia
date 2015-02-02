<?php

/*
 * (c)2013 Croce Rossa Italiana
 */

/*
 * Libreria RECAPTCHA
 */

function captcha_mostra() {
    global $conf;
    if ($conf['debug']) {
        echo '<p>Captcha disattivo in modalita\' debug.';
        return true;
    }
    echo "<div class='g-recaptcha' data-sitekey='{$conf['recaptcha']['public_key']}' data-callback='cc'></div>";
}

function captcha_controlla($risposta = false) {
    global $conf;

    if ( !$risposta ) {
        $risposta = $_REQUEST['g-recaptcha-response'];
    }

    // In debug, ritorna sempre OK
    if ($conf['debug'])
        return true;

    $key        = $conf['recaptcha']['private_key'];
    $risposta   = urlencode($risposta);
    $ip         = urlencode($_SERVER['REMOTE_ADDR']);
    $url = "https://www.google.com/recaptcha/api/siteverify?secret={$key}&response={$risposta}&remoteip={$ip}";

    $r = file_get_contents($url);
    if ( !$r ) {
        return false;
    }

    $r = json_decode($r);
    return $r->success;
}
