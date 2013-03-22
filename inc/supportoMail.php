<?php

/*
 * ©2013 Croce Rossa Italiana
 */

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
       <h2><i><center>Supporto GAIA</center></i></h2>
        <div class="alert alert-block alert-info">
            <h4><i class="icon-question-sign"></i> Hai bisogno di assistenza ?</h4>
            <p>Con questo modulo puoi richiedere supporto per GAIA.</p>
        </div>
           <form class="form-horizontal" action="?p=supportoMail.ok" method="POST">
            <div class="control-group">
              <label class="control-label" for="inputDestinatario">Destinatario</label>
              <div class="controls">
                <input type="text" class="input-xxlarge" name="inputDestinatario" id="inputDestinatario" readonly value="Servizi Informatici CRI Catania - <informatica@cricatania.it>">
              </div>
            </div>    
            <div class="control-group">
              <label class="control-label" for="inputOggetto">Oggetto</label>
              <div class="controls">
                <input type="text" class="input-xxlarge" name="inputOggetto" id="inputOggetto" required>
              </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTesto">Testo</label>
            <div class="controls">
              <textarea rows="8" class="input-xxlarge" type="text" id="inputTesto" name="inputTesto" placeholder="Inserisci il testo della tua mail qui..." required><?php echo $a->descrizione; ?></textarea>
            </div>
          </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success btn-large">
                    <i class="icon-envelope"></i>
                    Invia richiesta
                </button>
            </div>
          </form>

    </div>
</div>