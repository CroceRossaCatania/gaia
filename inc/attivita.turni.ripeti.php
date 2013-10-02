<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();

$t = $_GET['t'];
$t = Turno::id($t);
?>
<form action="?p=attivita.turni.ripeti.ok&t=<?= $t; ?>" method="POST">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-time"></i> Ripeti turno</h3>
        </div>
    <div class="modal-body">
        <?php if ( isset($_GET['max']) ) { ?>
            <div class="alert alert-danger">
                <i class="icon-ban-circle"></i> Puoi ripetere il turno per un tempo <strong>massimo di 15 giorni</strong>
            </div>
        <?php }else{ ?>
        <p>Con questo strumento è possibile ripetere un turno fino a 15 giorni consecutivi.</p>
        <hr />
        <?php } ?>
          <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputGiorni">Numero giorni da ripetere il turno </label>
                </div>
                <div class="span8">
                  <input class="input-large" type="text" name="inputGiorni" id="inputGiorni" required pattern="[0-9]{1,}" placeholder='Massimo 15' />
                </div>
        </div>
    </div>
        <div class="modal-footer">
          <a href="?p=attivita.turni&id=<?= $t->attivita(); ?>" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary" data-attendere="Attendere, operazione in corso...">
              <i class="icon-copy"></i> Ripeti turno
          </button>
        </div>
</div>
    
</form>
