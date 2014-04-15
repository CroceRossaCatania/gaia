<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
paginaModale();

controllaParametri(array('id'), 'gruppi.dash&err');

$gruppo = Gruppo::id($_GET['id']);

proteggiClasse($gruppo, $me);

if ( $gruppo->comitato()->_estensione()>=EST_PROVINCIALE ){
  redirect('gruppi.dash&err');
}

?>
<form action="?p=gruppo.estensione.ok" method="POST">

<input type="hidden" name="id" value="<?= $gruppo->id; ?>" />

<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-random"></i> Estensione per il gruppo di lavoro</h3>
        </div>
        <div class="modal-body">
          <p><strong>Cosa è l'estensione ?</strong>
          <p>Permette di estendere il gruppo di lavoro dall'Unità Territoriale a tutto il Comitato Locale</p>
          <select class="input-large" id="inputEstensione" name="inputEstensione"  required>
                <?php
                    foreach ( $conf['est_grp'] as $numero => $est ) { 
                      if ( $numero >= EST_GRP_PROVINCIALE ) { continue; } ?>
                    <option value="<?php echo $numero; ?>" <?php if ( $numero == $gruppo->estensione() ) { ?>selected<?php } ?>><?php echo $est; ?></option>
                    <?php } ?>
                </select>
        </div>
        <div class="modal-footer">
          <a href="?p=gruppi.dash" class="btn">Annulla</a>
          <button type="submit" class="btn btn-success">
              <i class="icon-save"></i> Salva cambiamenti
          </button>
        </div>
</div>
    
</form>
