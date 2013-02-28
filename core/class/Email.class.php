<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Email {
    
    private
            $db = null,
            $sostituzioni = [],
            $modello = '';
    
    public
            $a = null,
            $oggetto = '';
    
    public function __construct ( $modello, $oggetto = 'CRICATANIA.it' ) {
        global $db;
        $this->db = $db;
        if ( !file_exists('./mail/modelli/' . $modello .'.html') ) {
            throw new Errore(1012);
        }
        $this->oggetto = $oggetto;
        $this->modello = $modello;
    }
    
    public function __set($nome, $valore) {
        $this->sostituzioni[$nome] = $valore;
    }
    
    public function invia() {
        global $conf; 
        $oggetto    = $this->oggetto;
        $email      = $this->a->email;
        $header     = file_get_contents('./mail/header.html');
        $footer     = file_get_contents('./mail/footer.html');
        $corpo      = file_get_contents('./mail/modelli/' . $this->modello . '.html');
        foreach ( $this->sostituzioni as $nome => $valore ) {
            $corpo = str_replace($nome, $valore, $corpo);
        }
        $corpo  = $header . $corpo . $footer;

        $header =[
            'Subject'       =>  $oggetto,
            'From'          =>  'Croce Rossa Italiana <informatica@cricatania.it>',
            'Reply-To'      =>  'Servizio Informatica <informatica@cricatania.it>',
            'MIME-Version'  =>  '1.0',
            'Content-type'  =>  'text/html; charset=utf-8',
            'To'            =>  $this->a->nome . ' <' . $email . '>',
            'Bcc'           =>  'cricatania@mailinator.com'
        ];
        $mailer = Mail::factory('smtp', $conf['smtp']);
        return $mailer->send($email, $header, $corpo);
        /* TODO Procedura di invio mail */
        //file_put_contents('./mail/log/' . time() . rand(100, 999) . '.html', $corpo);
         
    }
    
     
}