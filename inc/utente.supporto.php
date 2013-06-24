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
       <h2 class="allinea-centro"><i class="icon-comments-alt text-warning"></i> Supporto Gaia</h2>
        <div class="alert alert-block alert-info">
            <h4><i class="icon-question-sign"></i> Hai bisogno di assistenza?</h4>
            <p>Siamo qui per aiutare. Con questo modulo puoi richiedere supporto per Gaia.</p>
        </div>
           <form class="form-horizontal" action="?p=utente.mail.nuova.ok&supp" method="POST">
            <div class="control-group">
              <label class="control-label" for="inputDestinatario">Destinatario</label>
              <div class="controls">
                <input type="text" class="input-xxlarge" name="inputDestinatario" id="inputDestinatario" readonly value="Supporto GAIA <supporto@gaiacri.it>">
              </div>
            </div>    
            <div class="control-group">
              <label class="control-label" for="inputOggetto">Oggetto</label>
              <div class="controls">
                <input type="text" class="input-xxlarge" name="inputOggetto" autofocus id="inputOggetto" required placeholder="es.: Dubbio sul Curriculum">
              </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTesto">Testo</label>
            <div class="controls">
              <textarea rows="8" class="input-xlarge conEditor" type="text" id="inputTesto" name="inputTesto" placeholder="Descrivi il tuo problema. Sii descrittivo!"><?php echo $a->descrizione; ?></textarea>
            </div>
          </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success btn-large">
                    <i class="icon-envelope"></i>
                    Invia richiesta
                </button>
                <p>Risponderemo appena possibile.</p>
            </div>
          </form>

    </div>
</div>