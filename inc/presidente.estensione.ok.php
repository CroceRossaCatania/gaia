<?php

    /*
     * ©2013 Croce Rossa Italiana
     */

    paginaPresidenziale();

    $e     = $_GET['id'];
    $e = new Estensione($e);

    if (isset($_GET['si'])) {
        $v = $e->volontario()->id;
        $e->concedi();
        $a = $e->appartenenza;
        
        $a = new Appartenenza($a);

        $m = new Email('richiestaEstensioneok', 'Richiesta estensione approvata: ' . $a->comitato()->nome);
        $m->da = $me; 
        $m->a = $a->volontario();
        $m->_NOME       = $a->volontario()->nome;
        $m->_COMITATO   = $a->comitato()->nomeCompleto();
        $m-> _TIME = date('d-m-Y', $e->protData);
        $m->invia();
      
        redirect('presidente.estensione&ok');  
    }

    if (isset($_GET['no'])) {
        $v = $e->volontario()->id;
        $e->nega($_POST['motivo']);
        
        $a = $e->appartenenza;
        $a = new Appartenenza($a);
        $a->timestamp = time();
        $a->stato     = MEMBRO_EST_NEGATA;
        $a->conferma  = $me->id;    
        $a->inizio = time();
        $a->fine = time();

        $m = new Email('richiestaEstensioneno', 'Richiesta estensione negata: ' . $a->comitato()->nome);
        $m->da = $me;   
        $m->a = $a->volontario();
        $m->_NOME       = $a->volontario()->nome;
        $m->_COMITATO   = $a->comitato()->nomeCompleto();
        $m-> _TIME = date('d-m-Y', $a->timestamp);
        $m-> _MOTIVO = $_POST['motivo'];
        $m->invia();

        redirect('presidente.estensione&no');   
    }
?>
