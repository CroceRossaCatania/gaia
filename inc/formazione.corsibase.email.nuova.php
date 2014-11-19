<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(['id'], 'formazione.corsibase&err');
$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);

?>

<div class="row-fluid">
  <div class="span3">
    <?php        menuVolontario(); ?>
  </div>
  <div class="span9">
    <h2><i class="icon-envelope muted"></i> Invio Mail</h3>
    <div class="alert alert-block alert-info">
      <h4><i class="icon-question-sign"></i> Pronto a mandare la mail ?</h4>
      <p>Modulo per l'invio mail agli utenti di Gaia</p>
    </div>
    <?php if (isset($_GET['iscrizioni'])) { ?><form class="form-horizontal" action="?p=formazione.corsibase.email.nuova.ok&iscrizioni&id=<?= $corso->id; ?>" method="POST">
    <?php }elseif (isset($_GET['preiscrizioni'])) { ?><form class="form-horizontal" action="?p=formazione.corsibase.email.nuova.ok&preiscrizioni&id=<?= $corso->id; ?>" method="POST">
    <?php } ?>
      <div class="control-group">
        <label class="control-label" for="inputV">Destinatari</label>
        <div class="controls">
          <input type="text" class="span5" name="inputV" id="inputV" readonly value="Destinatari Multipli">
        </div>
      </div>        
      <div class="control-group">
        <label class="control-label" for="inputOggetto">Oggetto</label>
        <div class="controls">
          <input type="text" class="span6" name="inputOggetto" id="inputOggetto" required>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputTesto">Testo</label>
        <div class="controls">
          <textarea rows="10" class="input-xxlarge conEditor" type="text" id="inputTesto" name="inputTesto" placeholder="Inserisci il testo della tua mail qui..."></textarea>
        </div>
      </div>
      <div class="form-actions">
        <button onclick="$('#b1').toggle(1000); $('#a1').toggle(1000);" id="b1" type="submit" class="btn btn-success btn-large">
          <i class="icon-envelope"></i>
            Invia mail
        </button>
        <div id="a1" class="alert alert-block alert-success nascosto">
          <h4><i class="icon-warning-sign"></i> <strong>Attendere...</strong>.</h4>
        </div>
      </div>
    </form>
  </div>
</div>
