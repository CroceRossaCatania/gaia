<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale();

controllaParametri(['id','direttore'], 'admin.corsi.crea&err');

$c = $direttore = null;
try {
    $c = Corso::id(intval($_POST['id']));
    
    if (!$c->modificabile() || !$c->modificabileDa($me)) {
        redirect('formazione.corsi.riepilogo&id='.$c->id);
    }

    $direttore = Volontario::id(intval($_POST['direttore']));
    
    if (empty($c) || empty($direttore)) {
        throw new Exception('Manomissione');
    }
} catch (Exception $e) {
    redirect('admin.corsi.crea&err');
}

$c->direttore = $direttore->id;

if (empty($_POST['modifica']))
    redirect('formazione.corsi.insegnanti&id='.$c->id);
else
    redirect('formazione.corsi.riepilogo&id='.$c->id);

?>
