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


global $db;

$db->beginTransaction();

try {
    $l = new GiornataCorso();
    $l->corso 	= $id;
    $l->nome 	= normalizzaNome($_POST['nome']);
    $data     = DT::createFromFormat('d/m/Y H:i', $_POST["data"]);
    $l->data = $data->getTimestamp();
    $l->luogo 	= normalizzaNome($_POST['luogo']);
    $l->note 	= addslashes($_POST['note']);
    $l->docente 	= intval($_POST['docenti'][0]);
    
    $docente = Volontario::id(intval($_POST['docenti'][0]));
    $part = new PartecipazioneCorso();
    $part->aggiungi(Corso::id($id), $docente, CORSO_RUOLO_DOCENTE);

    $db->commit();
} catch(Exception $e) {
    $db->rollBack();
    redirect("formazione.corsi.lezioni&id={$id}&err");
    die;
}

redirect("formazione.corsi.lezioni&id={$id}");
