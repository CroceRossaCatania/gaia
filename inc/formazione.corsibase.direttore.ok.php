<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();

controllaParametri(['id', 'inputDirettore']);

$id = $_POST['id'];
$corsoBase = CorsoBase::id($id);

paginaCorsoBase($corsoBase);

$id = $_POST['inputDirettore'];
$direttore = Volontario::id($id);

$corsoBase->direttore    = $direttore;

$m = new Email('direttoreCorsoBase', 'Direttore Corso Base');
$m->_NOME       = $direttore->nome;
$m->_ATTIVITA   = $corsoBase->nome();
$m->_COMITATO   = $corsoBase->organizzatore()->nomeCompleto();
$m->a = $direttore;
$m->accoda();


if ( $me->id == $direttore->id ) {
    redirect('formazione.corsibase.modifica&id=' . $corsoBase->id);
}
redirect('formazione.corsibase.grazie&id=' . $corsoBase->id);
