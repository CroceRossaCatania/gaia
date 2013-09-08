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
            <?php if($me->presiede()){?>
            <p>Siamo qui per aiutare. </p>
            <p>Puoi contattarci allo <i class="icon-phone"></i><strong> +39 0692928574</strong>, attenzione questo numero è riservato solo a voi Presidenti pertanto vi invitiamo a non diffonderlo tra i volontari del vostro Comitato. </p>
            <p>Oppure con questo modulo potete richiedere supporto per Gaia.</p>
            <?php }else{ ?>
            <p>Siamo qui per aiutare. Con questo modulo puoi richiedere supporto per Gaia.</p>
            <?php } ?>
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
                <button onclick="$('#b1').toggle(1000); $('#a1').toggle(1000);" type="submit" id="b1" class="btn btn-success btn-large">
                    <i class="icon-envelope"></i>
                    Invia richiesta
                </button>
                <div id="a1" class="alert alert-block alert-success nascosto">
                    <h4><i class="icon-warning-sign"></i> <strong>Attendere...</strong>.</h4>
                </div>
                <p>Risponderemo appena possibile.</p>
            </div>
          </form>

    </div>
</div>