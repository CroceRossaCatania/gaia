<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class PDF {
    
    private
            $db = null,
            $sostituzioni = [],
            $modello = '',
            $nome = 'File';
       
    public function __construct ( $modello, $nome ) {
        global $db;
        $this->db = $db;
        if ( !file_exists('./core/conf/pdf/modelli/' . $modello .'.html') ) {
            throw new Errore(1012);
        }
        $this->modello = $modello;
        $this->nome    = trim($nome);
    }
    
    public function __set($nome, $valore) {
        $this->sostituzioni[$nome] = $valore;
    }
    
    public function salvaFile($comitato=null) {
        global $conf, $sessione;
        if($comitato){
            $this->_INDIRIZZO  = $comitato->locale()->formattato;
            $this->_PIVA       = $comitato->locale()->piva();
            $this->_CF         = $comitato->locale()->cf();
            $footer     = file_get_contents('./core/conf/pdf/footerComitato.html');
        }else{
            $this->_MARCA_TEMPORALE = date('d-m-Y H:i');
            $this->_VERSIONE_GAIA = $conf['version'];
            $footer     = file_get_contents('./core/conf/pdf/footer.html');
        }
        $header     = file_get_contents('./core/conf/pdf/header.html');
        $corpo      = file_get_contents('./core/conf/pdf/modelli/' . $this->modello . '.html');
        $corpo  = $header . $corpo . $footer;
        foreach ( $this->sostituzioni as $nome => $valore ) {
            $corpo = str_replace($nome, $valore, $corpo);
        }
        require_once './core/inc/dompdf/dompdf_config.inc.php';
        $files = glob("./pdf/include/*.php");
        foreach($files as $file) include_once($file);
        
        if ( !class_exists('DOMPDF') ) {
            spl_autoload_register('DOMPDF_autoload'); 
        }

        $dompdf = new DOMPDF();
        $dompdf->load_html($corpo);
        $dompdf->render();
        
        $f = new File();
        $f->mime   = 'application/pdf';
        $f->nome   = $this->nome;
        $f->autore = @$sessione->utente()->id;
        file_put_contents($f->percorso(), $dompdf->output());
        return $f;
        
    }
    
     
}