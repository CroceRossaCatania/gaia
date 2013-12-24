<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();

controllaParametri(array('id'));

if (!isset($_GET['id'])) {
    redirect('attivita');
}

$pk = $_GET['id'];
$pk = Partecipazione::id($pk);


?>
<form action="?p=attivita.ritirati.ok" method="POST">

<input type="hidden" name="partecipazione" value="<?php echo $pk->id; ?>" />

<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-warning-sign"></i> Vuoi davvero ritirarti?</h3>
        </div>
        <div class="modal-body">
          <p>Confermando ritirerai la tua richiesta di partecipazione al turno seguente:</p>
          <p class="allinea-centro">
              <strong><?php echo $pk->turno()->nome; ?></strong><br />
              <?php echo $pk->attivita()->nome; ?><br />
              (<?php echo $pk->turno()->inizio()->inTesto(); ?>)
          </p>
          <hr />
          <p class="text-error">
              <i class="icon-info-sign"></i>
              <strong>Nota bene</strong>: 
              Il referente dell'attività 
              (<?php echo $pk->attivita()->referente()->nomeCompleto(); ?>)
              riceverà notifica.
          </p>
          
        </div>
        <div class="modal-footer">
          <a href="javascript:history.go(-1);" class="btn">Annulla</a>
          <button type="submit" class="btn btn-danger">
              <i class="icon-remove"></i> Ritirati dal turno
          </button>
        </div>
</div>
    
</form>
