<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Email {
    
    private
            $sostituzioni   = [],
            $allegati       = [],
            $modello        = '';
    
    public
            $a          = null,
            $oggetto    = '',
            $da         = null;
    
    public function __construct ( $modello, $oggetto ) {
        if ( !file_exists(static::_file_modello($modello)) ) {
            throw new Errore(1012);
        }
        $this->oggetto = $oggetto;
        $this->modello = $modello;
    }

    protected static function _file_modello($modello) {
        return "./core/conf/mail/modelli/{$modello}.html";
    }
    
    public function __set($nome, $valore) {
        $this->sostituzioni[$nome] = $valore;
    }
    
    public function allega(File $f) {
        $this->allegati[] = $f;
    }

    /**
     * Costruisce il corpo, effettua sostituzioni e ritorna
     * @return string Corpo del messaggio in HTML
     */
    protected function _costruisci_corpo() {
        $header     = file_get_contents('./core/conf/mail/header.html');
        $footer     = file_get_contents('./core/conf/mail/footer.html');
        $corpo      = file_get_contents(static::_file_modello($this->modello));
        foreach ( $this->sostituzioni as $nome => $valore ) {
            $corpo = str_replace($nome, $valore, $corpo);
        }
        $corpo  = 
            "<html>
                {$header}
                {$corpo}
                {$footer}
            </html>\n";
        return $corpo;
    }

    /** 
     * Costruisce il destinatario (come oggetto) e ritorna
     * @return Object Oggetto del destinatario
     */
    protected function _costruisci_destinatari() {
        if ( is_array($this->a) ) {
            // DESTINATARI MULTIPLI

        } else {
            // SINGOLO DESTINATARIO?
            $this->a = [$this->a];
            return $this->_costruisci_destinatari();
        }
    }

    public function invia() {
        return $this->accoda()->invia();


        global $conf; 
        $oggetto    = $this->oggetto;
        if ( !$this->a ) {
            $this->a = new stdClass;
            $this->a->nome = $conf['default_email_nome'];
            $this->a->email = $conf['default_email_email'];
        }
        $email = $this->a->email;
        $corpo = $this->_costruisci_corpo();        

        if ( $this->da ) {
            if ( $this->da instanceOf Persona ) {
                $da = $this->da->nome . ' ' . $this->da->cognome . ' <' . $this->da->email() . '>';
            } else {
                $da = $this->da;
            }
        } else {
            $da = 'Croce Rossa Italiana <supporto@gaia.cri.it>';
        }
        $toHash = $corpo . $email . time();
        $hash = hash('md5', $toHash);
        $header =[
            'Subject'       =>  $oggetto,
            'From'          =>  'Croce Rossa Italiana <noreply@gaia.cri.it>',
            'Reply-to'      =>  $da,
            'MIME-Version'  =>  '1.0',
            'Date'          =>  date('r', time()),
            'Message-ID'    => '<' . $hash . '@gaia.cri.it>',
            'To'            =>  $this->a->nome . ' <' . $email . '>'
        ];
        require_once './core/class/Mail/mime.php';
        require_once './core/class/Mail/mimePart.php';
        $mailer = Mail::factory('smtp', $conf['smtp']);
        $mime = new Mail_mime("\n");
        $mime->setHTMLBody($corpo);
        foreach ( $this->allegati as $allegato ) {
            if (!$quoted) {
                $mime->addAttachment($allegato->percorso(), $allegato->mime, $allegato->nome);
            } else {
                $mime->addAttachment($allegato->percorso(), $allegato->mime, $allegato->nome, true, 'quoted-printable');
            }
        }
        $corpo = $mime->get();
        $header = $mime->headers($header);
        return $mailer->send($email, $header, $corpo);
        
    }

    /**
     * Salva questa Email sul database (relativa MEntita)
     * @return MEmail creata
     */
    public function accoda() {

    }

     
}
