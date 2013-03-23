<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();

$t     = $_GET['id'];
$t = new Trasferimento($t);

if (isset($_GET['si'])) {
    $v = $t->volontario()->id;
    $t->stato = TRASF_OK;
    $t->pConferma = $me->id;
    $t->tConferma = time();
    $t = Appartenenza::filtra([
        ['volontario', $v],
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
        ['volontario', $v],
        ['stato', TRASF_INCORSO]
    ]);
    foreach ($t as $a ) { 
                            if ($a->attuale()) 
                                    {
                                    $a = new appartenenza($a);
                                    $a->timestamp = time();
                                    $a->stato     = MEMBRO_PENDENTE;
                                    $a->conferma = $me->id;
                                    $a->inizio = time();
                                    $a->fine = PROSSIMA_SCADENZA;
                                    $m = new Email('richiestaTrasferimentook', 'Richiesta trasferimento approvata: ' . $a->comitato()->nome);
                                    $m->a = $a->volontario();
                                    $m->_NOME       = $a->volontario()->nome;
                                    $m->_COMITATO   = $a->comitato()->nome;
                                    $m-> _TIME = date('d-m-Y', $t->protData);
                                    $m->invia();
                                    }
                                    }
redirect('presidente.trasferimento&ok');  
}

if (isset($_GET['no'])) {
    $v = $t->volontario()->id;
    $t->nega($_POST['motivo']);
    $t=Appartenenza::filtra([
        ['volontario', $v],
        ['stato', TRASF_INCORSO]
    ]);
    foreach ($t as $a ) { 
                            if ($a->attuale()) 
                                    {
                                    $a = new appartenenza($a);
                                    $a->timestamp = time();
                                    $a->stato     = TRASF_NEGATO;
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
redirect('presidente.trasferimento&no');   
}
?>