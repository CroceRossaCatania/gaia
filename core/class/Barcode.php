<?php

/*
 * ©2013 Croce Rossa Italiana
 */

require_once 'core/libs/barcode/Barcode2.php';

class Barcode extends File {
    
    public 
        $larghezza  = 5,
        $altezza    = 200,
        $testo      = true,
        $tipo       = 'ean13';

    public function genera($codice) {


        $this->nome = "Codice{$codice}.png";
        $this->mime = 'image/png';
        
        $i = Image_Barcode2::draw(
            $codice,
            $this->tipo,
            Image_Barcode2::IMAGE_PNG,
            false,
            $this->altezza,
            $this->larghezza
        );

        return imagepng($i, $this->percorso());
    }
    
}