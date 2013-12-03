<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata(false);
if (isset($_GET['first']) && !$me->consenso()){ ?>
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3 class="text-success"><i class="icon-cog"></i> Consenso al trattamento dei dati</h3>
    </div>
    <div class="modal-body">
      <p>Avendo letto l’informativa rilasciata dal Portale Gaia della Croce Rossa Italiana ai sensi dell’art. 13 
        del Decreto legislativo n. 196/2003 "Codice in materia di protezione dei dati personali", </p>
        <p><ul>
        <li>autorizzo la Croce Rossa Italiana al trattamento dei miei dati personali per la gestione del mio rapporto 
        di volontariato e per il loro inserimento sul Portale Gaia; </li>
        <li>autorizzo inoltre l’uso del mio numero telefonico personale come sopra descritto; </li>
        <li>autorizzo l’uso del mio indirizzo e-mail personale; </li>
        <li>chiede di poter ricevere dalla Croce Rossa Italiana comunicazioni e corrispondenza relativa a iniziative, 
        attività, congressi, corsi, manifestazioni, newsletter, rivista sociale, ecc. </li>
        </ul></p>

        <p>Accettando la presente informativa acconsenti all’inserimento e all’utilizzo, esclusivamente per le finalità della Croce Rossa Italiana, 
        della mia foto. </p>

        <p>Accettando la presente informativa accetti inoltre le Condizioni d'uso con cui viene fornito il portale Gaia.</p>

        <p>Il sottoscritto si riserva la facoltà di richiedere alla CRI, in qualunque momento, con comunicazione successiva, 
        di interrompere le comunicazioni richieste con la presente autorizzazione.</p>

        <p>Se il Socio è un minore il consenso <strong>deve essere rilasciato</strong> da un genitore o dal tutore.</p>
    </div>
    <div class="modal-footer">
      <a href="?p=logout" class="btn">
        <i class="icon-remove"></i>
        Logout
      </a>
      <a href="?p=utente.privacy.concedi.ok" class="btn btn-success">
        <i class="icon-ok"></i>
        Ok, Accetto!
      </a>
    </div>
  </div>
<?php }

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
      <p><h4><i class="icon-phone"></i> <i class="icon-envelope"></i> Telefono e Mail</h4>
        <p>Mostra il mio numero di telefono e il mio indirizzo email:</p>
        <?php if(!$me->pri_delegato()){ ?>
          <label class="radio">
            <input type="radio" name="phoneradio" id="phoneradio1" value="10" <?php if($me->privacy()->contatti==PRIVACY_PRIVATA){ ?> checked <?php } ?>>
              Solo ad ufficio soci, presidente e responsabili delle attività di cui faccio parte
          </label>
        <?php } ?>
        <label class="radio">
          <input type="radio" name="phoneradio" id="phoneradio2" value="20" <?php if($me->privacy()->contatti==PRIVACY_COMITATO){ ?> checked <?php } ?>>
            Solo ai volontari del mio Comitato
        </label>
        <label class="radio">
          <input type="radio" name="phoneradio" id="phoneradio3" value="30" <?php if($me->privacy()->contatti==PRIVACY_VOLONTARI){ ?> checked <?php } ?>>
            A tutti i volontari iscritti a Gaia
        </label></p>
        <hr/>
        <p><h4><i class="icon-briefcase"></i> Curriculum</h4>
        <p>Consenti la visione del mio curriculum (Competenze pers., Patenti Civili, Patenti CRI, Titoli di studio, Titoli CRI) :</p>
          <label class="radio">
            <input type="radio" name="curriculumradio" id="curriculumradio1" value="10" <?php if($me->privacy()->curriculum==PRIVACY_PRIVATA){ ?> checked <?php } ?>>
              Solo ad ufficio soci, presidente e responsabili delle attività di cui faccio parte
          </label>
        <label class="radio">
          <input type="radio" name="curriculumradio" id="curriculumradio2" value="20" <?php if($me->privacy()->curriculum==PRIVACY_COMITATO){ ?> checked <?php } ?>>
            Solo ai volontari del mio Comitato
        </label>
        <label class="radio">
          <input type="radio" name="curriculumradio" id="curriculumradio3" value="30" <?php if($me->privacy()->curriculum==PRIVACY_VOLONTARI){ ?> checked <?php } ?>>
            A tutti i volontari iscritti a Gaia
        </label>
        <label class="radio">
          <input type="radio" name="curriculumradio" id="curriculumradio4" value="40" <?php if($me->privacy()->curriculum==PRIVACY_PUBBLICA){ ?> checked <?php } ?>>
            Anche a chi non è iscritto a Gaia
        </label></p>
        <hr/>

        <p><h4><i class="icon-time"></i> Incarichi</h4>
        <p>Consenti la visione dello storico dei miei incarichi :</p>
        <?php if(!$me->pri_delegato()){ ?>
          <label class="radio">
            <input type="radio" name="incarichiradio" id="incarichiradio1" value="10" <?php if($me->privacy()->incarichi==PRIVACY_PRIVATA){ ?> checked <?php } ?>>
              Solo ad ufficio soci, presidente e responsabili delle attività di cui faccio parte
          </label>
        <?php } ?>
        <label class="radio">
          <input type="radio" name="incarichiradio" id="incarichiradio2" value="20" <?php if($me->privacy()->incarichi==PRIVACY_COMITATO || $me->pri_delegato()){ ?> checked <?php } ?>>
            Solo ai volontari del mio Comitato
        </label>
        <label class="radio">
          <input type="radio" name="incarichiradio" id="incarichiradio3" value="30" <?php if($me->privacy()->incarichi==PRIVACY_VOLONTARI){ ?> checked <?php } ?>>
            A tutti i volontari iscritti a Gaia
        </label>
        <label class="radio">
          <input type="radio" name="incarichiradio" id="incarichiradio4" value="40" <?php if($me->privacy()->incarichi==PRIVACY_PUBBLICA){ ?> checked <?php } ?>>
            Anche a chi non è iscritto a Gaia
        </label></p>
        <hr/>
      <div class="form-actions">
        <button type="submit" class="btn btn-success btn-large">
          <i class="icon-save"></i>
          Salva modifiche
        </button>
      </div>
    </form>
  </div>
</div>
