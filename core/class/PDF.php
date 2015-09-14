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

    public
        $orientamento   = ORIENTAMENTO_VERTICALE,
        $formato        = 'a4',
        $estensione     = 'pdf';
       
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
    
    /**
     * @param Comitato default null, se passato inserisce footer con intestazione
     * @param White default null, l'header può essere integrato nel modello
     * @param filename default null, se passo il filename, cerco il file per nome nella tabella e sovrascrivo il file
     */
    public function salvaFile($comitato=null, $white=null) {
        global $conf, $sessione;
        if($comitato){
            $this->_INDIRIZZO  = $comitato->locale()->formattato;
            $this->_PIVA       = $comitato->locale()->piva(true);
            $this->_CF         = $comitato->locale()->cf(true);
            $this->_TEL        = $comitato->locale()->telefono;
            $footer     = file_get_contents('./core/conf/pdf/footerComitato.html');
        }elseif( $white ){
            $footer     = null;
        }else{
            $this->_MARCA_TEMPORALE = date('d-m-Y H:i');
            $this->_VERSIONE_GAIA = $conf['version'];
            $footer     = file_get_contents('./core/conf/pdf/footer.html');
        }
        if ( $white ){
            $header     = null;
        }else{
            $header     = file_get_contents('./core/conf/pdf/header.html');
        }
        $corpo      = file_get_contents('./core/conf/pdf/modelli/' . $this->modello . '.html');
        $corpo  = $header . $corpo . $footer;
        foreach ( $this->sostituzioni as $nome => $valore ) {
            $corpo = str_replace($nome, $valore, $corpo);
        }
        require_once './core/libs/dompdf/dompdf_config.inc.php';
        $files = glob("./pdf/include/*.php");
        foreach($files as $file) include_once($file);
        
        if ( !class_exists('DOMPDF') ) {
            spl_autoload_register('DOMPDF_autoload'); 
        }

        $dompdf = new DOMPDF();
        $dompdf->load_html($corpo);
        $dompdf->set_paper($this->formato, $this->orientamento);
        $dompdf->render();
        
        $f = File::getByNome($this->nome);
        if (empty($f)){
            $f = new File();
        }
        print "<pre>";
        print_r($f);
        print "</pre>";
        
        $f->mime   = 'application/pdf';
        $f->nome   = $this->nome;
        $f->autore = @$sessione->utente()->id;
        
        file_put_contents($f->percorso(), $dompdf->output());
       
        return $f;
        
    }
    
     
}