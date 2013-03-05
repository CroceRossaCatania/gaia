<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaAdmin();

$id     = $_GET['id'];

if (isset($_GET['si'])) {
    $t = Appartenenza::filtra([
        ['volontario', $id],
        ['stato', MEMBRO_VOLONTARIO]
    ]);
    foreach ($t as $a ) { 
                            if ($a->attuale()) 
                                    {
                                    $a = new Appartenenza($a);
                                    $a->timestamp = time();
                                    $a->conferma  = $me->id;    
                                    $a->fine = time();
                                    }
                                    }
    $t = Appartenenza::filtra([
        ['volontario', $id],
        ['stato', MEMBRO_TRASF_IN_CORSO]
    ]);
    foreach ($t as $a ) { 
                            if ($a->attuale()) 
                                    {
                                    $a = new appartenenza($a);
                                    $a->timestamp = time();
                                    $a->stato     = MEMBRO_PENDENTE;
                                    $a->conferma = '0';
                                    $a->inizio = time();
                                    $a->fine = strtotime('April 31');
                                    $m = new Email('richiestaTrasferimentook', 'Richiesta trasferimento approvata: ' . $a->comitato()->nome);
                                    $m->a = $a->volontario();
                                    $m->_NOME       = $a->volontario()->nome;
                                    $m->_COMITATO   = $a->comitato()->nome;
                                    $m-> _TIME = date('d-m-Y', $a->timestamp);
                                    $m->invia();
                                    }
                                    }
redirect('admin.trasferimento&ok');  
}

if (isset($_GET['no'])) {
    $t=Appartenenza::filtra([
        ['volontario', $id],
        ['stato', MEMBRO_TRASF_IN_CORSO]
    ]);
    foreach ($t as $a ) { 
                            if ($a->attuale()) 
                                    {
                                    $a = new appartenenza($a);
                                    $a->timestamp = time();
                                    $a->stato     = MEMBRO_TRASF_NEGATO;
                                    $a->conferma  = $me->id;    
                                    $a->inizio = time();
                                    $a->fine = time();
                                    $m = new Email('richiestaTrasferimentono', 'Richiesta trasferimento negata: ' . $a->comitato()->nome);
                                    $m->a = $a->volontario();
                                    $m->_NOME       = $a->volontario()->nome;
                                    $m->_COMITATO   = $a->comitato()->nome;
                                    $m-> _TIME = date('d-m-Y', $a->timestamp);
                                    $m->invia();
                                    }
                                    }
redirect('admin.trasferimento&no');   
}
?>