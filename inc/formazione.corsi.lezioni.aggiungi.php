<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);
controllaParametri(['nome', 'luogo', 'data', 'docenti']);

$c = $err = null;
$id = intval($_GET['id']);

try {
    $c = Corso::id($id);
    if (empty($c)) {
        throw new Exception('Manomissione');
    }
    $tipoCorso = TipoCorso::by('id', intval($c->tipo));

} catch(Exception $e) {
    redirect('admin.corsi.crea&err');
}


if (!empty($_GET['err']) && is_int($_GET['err'])) {
    if (!empty($conf['errori_corsi'][$_GET['err']])) {
        $err = $conf['errori_corsi'][$_GET['err']];
    } else {
        $err = 'errore sconosciuto';
    }
}


$l = new GiornataCorso();
$l->corso 	= $id;
$l->nome 	= normalizzaNome($_POST['nome']);
$data     = DT::createFromFormat('d/m/Y H:i', $_POST["data"]);
$l->data = $data->getTimestamp();
$l->luogo 	= normalizzaNome($_POST['luogo']);
$l->note 	= addslashes($_POST['note']);
$l->docenti 	= implode(',', $_POST['docenti']);
    
foreach ($_POST['docenti'] as $docente) {
    $docenteId = Volontario::id(intval($docente));
    $part = new PartecipazioneCorso();
    $part->aggiungi(Corso::id($id), $docenteId, CORSO_RUOLO_DOCENTE);
}

redirect("formazione.corsi.lezioni&id={$id}");
