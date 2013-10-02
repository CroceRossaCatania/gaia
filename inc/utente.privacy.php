<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
if (isset($_GET['first'])){
  $v = new Volontario($me);
  $v->consenso = time();
}

?>
<div class="row-fluid">
  <div class="span3">
    <?php menuVolontario(); ?>
  </div>
  <div class="span9">
    <h2><i class="icon-cog muted"></i> Privacy</h2>
        
    <?php if ( isset($_GET['ok']) ) { ?>
    <div class="alert alert-success">
        <i class="icon-save"></i> <strong>Salvata</strong>.
        Le impostazioni sulla privacy sono state memorizzate con successo.
    </div>
    <?php } ?>

    <div class="alert alert-block alert-info">
      <h4><i class="icon-question-sign"></i> A cosa serve?</h4>
      <p>Al fine di tutelare la tua <strong>Privacy</strong>, da questo menù potrai impostare la visibilità dei tuoi contatti; seleziona le impostazioni e clicca su salva modifiche.</p>
      <?php if($me->pri_delegato()){ ?>
        <p>Attenzione! Se sei un Presidente, un Delegato o un Referente la tua email di servizio e il tuo numero di cellulare di servizio saranno in ogni caso visibili ai volontari della tua Unità Territoriale o del tuo Comitato. Nel caso in cui tu non abbia indicato telefono o email di servizio verranno resi visibili quelli personali.</p>
      <?php } ?>
    </div>
    <br/>
    <form class="form-horizontal" action="?p=utente.privacy.ok" method="POST">
      <ul>
        <li><h4><i class="icon-phone"></i> <i class="icon-envelope"></i> Telefono e Mail</h4></li>
        <p>Mostra il mio numero di telefono e il mio indirizzo email:</p>
        <?php if(!$me->pri_delegato()){ ?>
          <label class="radio">
            <input type="radio" name="phoneradio" id="phoneradio1" value="10" <?php if($me->privacy()->mailphone==PRIVACY_PRIVATA){ ?> checked <?php } ?>>
              Solo ad ufficio soci, presidente e responsabili delle attività di cui faccio parte
          </label>
        <?php } ?>
        <label class="radio">
          <input type="radio" name="phoneradio" id="phoneradio2" value="20" <?php if($me->privacy()->mailphone==PRIVACY_COMITATO){ ?> checked <?php } ?>>
            A tutti i volontari del mio Comitato
        </label>
        <label class="radio">
          <input type="radio" name="phoneradio" id="phoneradio3" value="30" <?php if($me->privacy()->mailphone==PRIVACY_VOLONTARI){ ?> checked <?php } ?>>
            A tutti i volontari iscritti a Gaia
        </label>
        <hr/>
        <!--
        <li><h4><i class="icon-envelope-alt"></i> Messaggi privati</h4></li>
        <p>Consenti l'invio di messaggi privati all'interno di Gaia (Attenzione l'indirizzo email non verrà mostrato):</p>
        <?php if(!$me->pri_delegato()){ ?>
          <label class="radio">
            <input type="radio" name="messradio" id="messradio1" value="10" <?php if($me->privacy()->mess==PRIVACY_PRIVATA){ ?> checked <?php } ?>>
              Solo ad ufficio soci, presidente e responsabili delle attività di cui faccio parte
          </label>
        <?php } ?>
        <label class="radio">
          <input type="radio" name="messradio" id="omessradio2" value="20" <?php if($me->privacy()->mess==PRIVACY_COMITATO){ ?> checked <?php } ?>>
            A tutti i volontari del mio Comitato
        </label>
        <label class="radio">
          <input type="radio" name="messradio" id="messradio3" value="30" <?php if($me->privacy()->mess==PRIVACY_VOLONTARI){ ?> checked <?php } ?>>
            A tutti i volontari iscritti a Gaia
        </label>
        <hr/>
        -->
        <li><h4><i class="icon-briefcase"></i> Curriculum</h4></li>
        <p>Consenti la visione del mio curriculum (Competenze pers., Patenti Civili, Patenti CRI, Titoli di studio, Titoli CRI) :</p>
        <?php if(!$me->pri_delegato()){ ?>
          <label class="radio">
            <input type="radio" name="curriculumradio" id="curriculumradio1" value="10" <?php if($me->privacy()->curriculum==PRIVACY_PRIVATA){ ?> checked <?php } ?>>
              Solo ad ufficio soci, presidente e responsabili delle attività di cui faccio parte
          </label>
        <?php } ?>
        <label class="radio">
          <input type="radio" name="curriculumradio" id="curriculumradio2" value="20" <?php if($me->privacy()->curriculum==PRIVACY_COMITATO){ ?> checked <?php } ?>>
            A tutti i volontari del mio Comitato
        </label>
        <label class="radio">
          <input type="radio" name="curriculumradio" id="curriculumradio3" value="30" <?php if($me->privacy()->curriculum==PRIVACY_VOLONTARI){ ?> checked <?php } ?>>
            A tutti i volontari iscritti a Gaia
        </label>
        <label class="radio">
          <input type="radio" name="curriculumradio" id="curriculumradio4" value="40" <?php if($me->privacy()->curriculum==PRIVACY_PUBBLICA){ ?> checked <?php } ?>>
            Anche a chi non è iscritto a Gaia
        </label>
        <hr/>

        <li><h4><i class="icon-time"></i> Incarichi</h4></li>
        <p>Consenti la visione dello storico dei miei incarichi :</p>
        <?php if(!$me->pri_delegato()){ ?>
          <label class="radio">
            <input type="radio" name="incarichiradio" id="incarichiradio1" value="10" <?php if($me->privacy()->incarichi==PRIVACY_PRIVATA){ ?> checked <?php } ?>>
              Solo ad ufficio soci, presidente e responsabili delle attività di cui faccio parte
          </label>
        <?php } ?>
        <label class="radio">
          <input type="radio" name="incarichiradio" id="incarichiradio2" value="20" <?php if($me->privacy()->incarichi==PRIVACY_COMITATO){ ?> checked <?php } ?>>
            A tutti i volontari del mio Comitato
        </label>
        <label class="radio">
          <input type="radio" name="incarichiradio" id="incarichiradio3" value="30" <?php if($me->privacy()->incarichi==PRIVACY_VOLONTARI){ ?> checked <?php } ?>>
            A tutti i volontari iscritti a Gaia
        </label>
        <label class="radio">
          <input type="radio" name="incarichiradio" id="incarichiradio4" value="40" <?php if($me->privacy()->incarichi==PRIVACY_PUBBLICA){ ?> checked <?php } ?>>
            Anche a chi non è iscritto a Gaia
        </label>
        <hr/>
      </ul>
      <div class="form-actions">
        <button type="submit" class="btn btn-success btn-large">
          <i class="icon-save"></i>
          Salva modifiche
        </button>
      </div>
    </form>
  </div>
</div>
