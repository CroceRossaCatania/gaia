<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();

if (!isset($_POST['partecipazione'])) {
    redirect('attivita');
}

$pk = $_POST['partecipazione'];
$pk = Partecipazione::id($pk);
$pk->ritira();

?>

<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-ok"></i> Partecipazione annullata</h3>
        </div>
        <div class="modal-body">
          <p>La tua partecipazione è stata correttamente annullata.</p>
          <p>Abbiamo provveduto a informare il referente dell'attività.</p>
        </div>
        <div class="modal-footer">
          <a href="?p=attivita" class="btn">Torna alle attività</a>
        </div>
</div>

