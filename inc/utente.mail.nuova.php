<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
$f = $_GET['id'];
$t=utente::by('id',$f);
?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <h2><i class="icon-envelope muted"></i> Invio Mail</h3>
        <div class="alert alert-block alert-info">
            <h4><i class="icon-question-sign"></i> Pronto a mandare la mail ?</h4>
            <p>Modulo per l'invio mail agli utenti di GAIA</p>
        </div>
        <?php if (isset($_GET['mass'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&mass&t=<?php echo $_GET['t']; ?>" method="POST"><?php }else{ ?> <form class="form-horizontal" action="?p=utente.mail.nuova.ok" method="POST"><?php } ?>
        <?php if (isset($_GET['mass'])) { ?> 
            <div class="control-group">
              <label class="control-label" for="inputDestinatari">Destinatari</label>
              <div class="controls">
                <input type="text" class="span5" name="inputDestinatari" id="inputDestinatari" readonly value="Destinatari Multipli">
              </div>
            </div>
           <?php }else{ ?>     
            <div class="control-group">
              <label class="control-label" for="inputDestinatario">Destinatario</label>
              <div class="controls">
                <input type="text" class="span5" name="inputDestinatario" id="inputDestinatario" readonly value="<?php echo $t->nome, " "; echo $t->cognome; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputMail">Mail</label>
              <div class="controls">
                <input type="text" class="span5" name="inputMail" id="inputMail" readonly value="<?php echo $t->email; ?>">
              </div>
            </div>
          <?php } ?>      
            <div class="control-group">
              <label class="control-label" for="inputOggetto">Oggetto</label>
              <div class="controls">
                <input type="text" class="span6" name="inputOggetto" id="inputOggetto" required>
              </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTesto">Testo</label>
            <div class="controls">
              <textarea rows="10" class="input-xxlarge" type="text" id="inputTesto" name="inputTesto" placeholder="Inserisci il testo della tua mail qui..." required><?php echo $a->descrizione; ?></textarea>
            </div>
          </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success btn-large">
                    <i class="icon-envelope"></i>
                    Invia mail
                </button>
            </div>
          </form>

    </div>
</div>
