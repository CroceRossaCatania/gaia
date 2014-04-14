<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Excel extends File {
    
    private 
            $intestazione = [],
            $righe        = [];

    
    public function intestazione( $array ) {
        $this->intestazione = $array;
    }
    
    public function aggiungiRiga( $array ) {
        $this->righe[] = $array;
    }
    
    public function genera($nome) {

        global $conf;

        $this->nome = $nome;
        $this->mime = 'application/vnd.ms-excel';
        
        $s  = "<meta charset='utf-8'>";
        $s .= "<head><style>.excel-text{ mso-number-format: \"\@\"; } </style></head>";
        $s .= '<table border="0">';
        $s .= '<thead>';
        foreach ( $this->intestazione as $int) {
            $s .= "<th class='excel-text'><strong>{$int}</strong></th>";
        }
        $s .= '</thead>';
        $s .= '<tbody>';
        foreach ( $this->righe as $riga ) {
            $s .= '<tr>';
            foreach ( $riga as $cont ) {
                $s .= '<td style="min-width: 200px;" class="excel-text">';
                $s .= htmlentities($cont);
                $s .= '</td>';
            }
            $s .= '</tr>';
        }
        $s  .= '</tbody>';
        $s  .= '</table>';
        file_put_contents($this->percorso(), $s);
    }
    
}