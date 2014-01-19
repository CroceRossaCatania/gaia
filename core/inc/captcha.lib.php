<?php

/*
 * (c)2013 Croce Rossa Italiana
 */

/*
 * Libreria SweetCaptcha e ReCaptcha
 * /

/*
 * Genera e mostra il captcha all'interno di un FORM
 */
function recaptcha_mostra() {
    global $conf;
    if ( !isset($conf['recaptcha']) )
        die('Errore: Configurazione captcha mancante.');
    echo <<<RECAPTCHA
         <script type="text/javascript"
                   src="https://www.google.com/recaptcha/api/challenge?k={$conf['recaptcha']['public_key']}">
                </script>
                <noscript>
                   <iframe src="https://www.google.com/recaptcha/api/noscript?k={$conf['recaptcha']['public_key']}"
                       height="300" width="500" frameborder="0"></iframe><br>
                   <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                   </textarea> 
                   <input type="hidden" name="recaptcha_response_field"
                       value="manual_challenge">
                </noscript>
RECAPTCHA;
    return;
}

/*
 * Controlla la validita' del form ricevuto via POST
 * @return bool Valido o meno
 */
function recaptcha_controlla() {
    global $conf;
    if ( !isset($conf['recaptcha']) )
        die('Errore: Configurazione captcha mancante.');
    $result = http_post(
        'http://www.google.com/recaptcha/api/verify',
        [
            'privatekey'    =>  $conf['recaptcha']['private_key'],
            'remoteip'      =>  $_SERVER['REMOTE_ADDR'],
            'challenge'     =>  $_POST['recaptcha_challenge_field'],
            'response'      =>  $_POST['recaptcha_response_field'],
        ]
    );
    $result = explode("\n", $result);
    if ( $result[0] == 'true' ) {
        return true;
    }
    return false;
}


function captcha_mostra() {
    require_once('sweetcaptcha.lib.php');
    echo $sweetcaptcha->get_html() ;
}

function captcha_controlla($sckey, $scvalue) {
    require_once('sweetcaptcha.lib.php');
    if (isset($sckey) 
        and isset($scvalue) 
        and $sweetcaptcha->check(array('sckey' => $sckey, 'scvalue' => $scvalue)) == "true") {
        return true;
    }
    return false;
}

?>
