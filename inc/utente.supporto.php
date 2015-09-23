<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaPrivata();
caricaSelettore();

?>
<div class="row-fluid">
  <div class="span3">
    <?php menuVolontario(); ?>
  </div>
  <div class="span9">
    <h2 class="allinea-centro"><i class="icon-comments-alt text-warning"></i> Supporto Gaia</h2>
    <?php if ( isset($_GET['len']) ) { ?>
      <div class="alert alert-error">
        <i class="icon-warning-sign"></i>
        <strong>Errore</strong> &mdash; Il testo deve essere lungo almeno 10 caratteri.
      </div>
    <?php } ?>
    <div class="alert alert-block alert-info">
      <h4><i class="icon-question-sign"></i> Hai bisogno di assistenza?</h4>
      <br/>
      <div class="allinea-centro">
        <a class="btn btn-info" href="?p=private.tesserini" target="_new" title="Informazioni tesserini">
          <i class="icon-credit-card"></i> Hai dei dubbi o vuoi maggiori informazioni sui tesserini ? Prima di scrivere al supporto clicca qui
        </a>
      </div>
      <br/>
      <?php if($me->presiede()){?>
      <p>Ti informiamo che il supporto telefonico <strong></strong>NON</strong> è attualmente attivo, se avessi necessità di contattarci compila il form sottostante.</p>
      <!--
        <p>Siamo qui per aiutare. </p>
        <p>Puoi contattarci allo <i class="icon-phone"></i><strong> +39 0692928574</strong>, attenzione questo numero è riservato solo a voi Presidenti pertanto vi invitiamo a non diffonderlo tra i volontari del vostro Comitato. </p>
        <p>Ti ricordiamo che questa tipologia di assistenza telefonica nasce per aiutare gli utenti nell'utilizzo di GAIA.</p>
        <p>Qualsiasi <strong>modifica</strong> dei dati presenti in Gaia dovrà avvenire mediante supporto ticket e <strong>NON</strong> tramite telefono!</p>
        <p>Oppure con questo modulo potete richiedere supporto per Gaia.</p>
        -->
      <?php }else{ ?>
        <p>Siamo qui per aiutare. Con questo modulo puoi richiedere supporto per Gaia.</p>
      <?php } ?>
    </div>
    <?php if($me->delegazioneAttuale()->applicazione == APP_SOCI
    or $me->delegazioneAttuale()->applicazione == APP_PRESIDENTE) { 
    $assistiAltroVolontario = true; ?>
      <div class="alert alert-block alert-info">
        <h4><i class="icon-user"></i> Sei un Presidente o un responsabile Ufficio Soci?</h4>
        <p>Puoi richiedere assistenza per un volontario di un tuo comitato. </p>
        <p>Selezione un volontario tramite il pulsante qui sotto nel caso in cui tu voglia segnalare un'anomalia (codice fiscale errato, data di nascita errata, ecc) per noi sarà più facile risolvere il problema.</p>
      </div>
    <?php } ?>
    <form class="form-horizontal" action="?p=utente.mail.nuova.ok&supp" method="POST">
      <div class="control-group">
        <label class="control-label" for="inputOggetto">Oggetto</label>
        <div class="controls">
          <input type="text" class="input-xxlarge" name="inputOggetto" autofocus id="inputOggetto" required placeholder="es.: Dubbio sul Curriculum">
        </div>
      </div>
      <?php if($assistiAltroVolontario) { ?>
        <div class="control-group">
          <label class="control-label" for="inputOggetto">Assistenza per</label>
          <div class="controls">
            <a data-selettore="true" data-input="inputVolontario" data-stato="[<?= MEMBRO_VOLONTARIO ?>, <?= MEMBRO_ORDINARIO ?>]"
            class="btn btn-inverse btn-small">
              Seleziona un volontario... <i class="icon-pencil"></i>
            </a>
          </div>
        </div>
      <?php } ?>
      <div class="control-group">
        <label class="control-label" for="inputTesto">Testo</label>
        <div class="controls">
          <textarea rows="8" class="input-xlarge conEditor" type="text" id="inputTesto" name="inputTesto" placeholder="Descrivi il tuo problema. Sii descrittivo!"><?php
            if ( isset($_GET['errore']) ) {
            echo "(Descrivi qui il problema. Per favore sii descrittivo.)<br/><br/>Rif. errore codice {$_GET['errore']} ";
            } ?>
          </textarea>
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
