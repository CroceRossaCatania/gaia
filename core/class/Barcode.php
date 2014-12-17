<?php

/*
 * ©2013 Croce Rossa Italiana
 */

require_once 'core/libs/barcode/Barcode2.php';

class Barcode extends File {
    
    public 
        $larghezza  = 2,
        $altezza    = 100,
        $testo      = true,
        $tipo       = 'code128';

    public function genera($codice) {


        $this->nome = "Codice{$codice}.png";
        $this->mime = 'image/png';
        
        $i = Image_Barcode2::draw(
            $codice,
            $this->tipo,
            Image_Barcode2::IMAGE_PNG,
            false,
            $this->altezza,
            $this->larghezza,
            $this->testo
        );

        return imagejpeg($i, $this->percorso());
    }
    
}