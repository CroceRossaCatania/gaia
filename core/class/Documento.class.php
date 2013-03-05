<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Documento extends Entita {
    
    protected static
            $_t     = 'documenti',
            $_dt    = null;
    
    public function utente() {
        return new Utente($this->utente);
    }
    
    protected function generaId() {
        do {
            $n = sha1( microtime() . rand(100, 999) );
        } while (self::_esiste($n));
        return $n;
    }
    
    public function caricaFile ( $file ) {
    	/* Carica la libreria Imagine */
    	require_once 'phar://./core/phar/imagine.phar';
    	global $conf;

    	$this->timestamp = time();

	$iniziale = new Imagine\Gd\Imagine();
    	$iniziale = $iniziale->open($file['tmp_name']);
    	$mode    = Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

        /* Controlla se ci sono errori */
        if ( is_array($file['error']) ) { 
            foreach ($file['error'] as $error) {
                if ($error != UPLOAD_ERR_OK) {
                    throw new Exception('Errore caricamento immagine');
                }
            }
        }
        
        $size    = new Imagine\Image\Box($conf['docs_t'][0], $conf['docs_t'][1]);
        $iniziale
            ->thumbnail($size, $mode)
            ->save($this->anteprima());
        $iniziale->save($this->originale());
        
	return true;
    }
    
    public function originale() {
        return "./upload/docs/o/{$this->id}.jpg";
    }
    
    public function anteprima() {
        return "./upload/docs/t/{$this->id}.jpg";
    }
    
    public function cancella () {
    	@unlink($this->anteprima());
        @unlink($this->originale());
    	parent::cancella();
    }


}