<?php

    /*
     * ©2013 Croce Rossa Italiana
     */

    paginaPresidenziale();

    controllaParametri(array('id'));

    $e     = $_GET['id'];
    $e = Estensione::id($e);

    

    if (isset($_GET['si'])) {
        $v = $e->volontario()->id;
        if (!$e->volontario()->modificabileDa($me)) {
            redirect('presidente.estensione&err');
        }
        $e->concedi();
        $a = $e->appartenenza;
        
        $a = Appartenenza::id($a);

        $m = new Email('richiestaEstensioneok', 'Richiesta estensione approvata: ' . $a->comitato()->nome);
        $m->da = $me; 
        $m->a = $a->volontario();
        $m->_NOME       = $a->volontario()->nome;
        $m->_COMITATO   = $a->comitato()->nomeCompleto();
        $m-> _TIME = date('d-m-Y', $e->appartenenza()->timestamp);
        $m->invia();
      
        redirect('presidente.estensione&ok');  
    } elseif (isset($_GET['no'])) {
        $v = $e->volontario()->id;
        $e->nega($_POST['motivo']);
        
        $a = $e->appartenenza;
        $a = Appartenenza::id($a);
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
    redirect('utente.me&err');
?>
