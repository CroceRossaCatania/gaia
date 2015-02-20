<?php

/*
 * ©2013 Croce Rossa Italiana
 */

//paginaApp([APP_SOCI, APP_PRESIDENTE]);
paginaApp([APP_SOCI, APP_PRESIDENTE, APP_OBIETTIVO]);

controllaParametri(array('id'), 'presidente.utenti&errGen');

$id = $_GET['id']; 
$u = Utente::id($id);

$IveGotThePower = ( $me && ($me->admin() || $me->delegazioneAttuale()->applicazione == APP_PRESIDENTE ) || (!$me->admin() && $me->delegazioneAttuale()->applicazione == APP_SOCI) || ($me->delegazioneAttuale()->applicazione == APP_OBIETTIVO)) ? true : false;

if ($IveGotThePower && !$me->delegazioneAttuale()->applicazione == APP_OBIETTIVO) {
	$hoPotere = $u->modificabileDa($me);
	$t  = TitoloPersonale::filtra([['volontario', $u]]);
	$admin = $me->admin();
	if ($u->stato == PERSONA) {
		$attivo = false;
	}
}
$do = DonazionePersonale::filtra([['volontario', $u]]);

//proteggiDatiSensibili($u, [APP_SOCI, APP_PRESIDENTE]);
proteggiDatiSensibili($u, [APP_SOCI, APP_PRESIDENTE,APP_OBIETTIVO]);
die;
?>
<!--Visualizzazione e modifica anagrafica utente-->
<div class="row-fluid">
  <div class="span6">
    <?php if ( isset($_GET['ok']) ) { ?>
      <div class="alert alert-success">
        <i class="icon-save"></i> <strong>Salvato</strong>.
        Le modifiche richieste sono state memorizzate con successo.
      </div>
    <?php } elseif(isset($_GET['att'])) {?>
      <div class="alert alert-success">
        <i class="icon-user"></i> <strong>Account attivato</strong>.
        L'account dell'utente è stato attivato con successo.
      </div>
    <?php } elseif(isset($_GET['email'])) {?>
      <div class="alert alert-danger">
        <i class="icon-warning-sign"></i> <strong>Email già presente</strong>.
        L'email che si sta tentando di sostituire appartiene già ad un altro utente.
      </div>
    <?php } elseif(isset($_GET['roba'])) {?>
      <div class="alert alert-danger">
        <i class="icon-warning-sign"></i> <strong>Non posso ordinarizzare</strong>.
        L'utente ha roba in sospeso (deleghe, nomine, attività referenziate, ecc).
      </div>
    <?php } elseif(isset($_GET['err'])) {?>
      <div class="alert alert-danger">
        <i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.
        L'operazione che hai tentato di eseguire non è andata a buon fine. Per favore riprova
      </div>
    <?php } elseif(isset($_GET['cf'])) {?>
      <div class="alert alert-danger">
        <i class="icon-warning-sign"></i> <strong>Codice Fiscale già presente</strong>.
        Il codice fiscale che vorresti inserire risulta già presente
      </div>
    <?php } ?>

    <!-- Attivazione account -->

    <?php 
      if ($hoPotere && !$u->email) { ?>
      <div class="row-fluid">
        <div class="span12">
          <div class="alert alert-block alert-info">
            <h3><i class="icon-user"></i> Attivazione account</h3>
            <p>
              L'account di <?php echo $u->nome ?> su Gaia <strong>non è ancora attivo</strong> e quindi non può
              ricevere informazioni e non può partecipare alle attività. Per attivare un account basta inserire l'indirizzo email
              del volontario.
            </p>
            <br/>
            <a class="btn btn-info btn-large" data-toggle="modal" data-target="#attiva_account"> Attiva account</a>
          </div>
        </div>
      </div>

    <!-- inizio modale -->

    <div id="attiva_account" class="modal hide fade">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><i class="icon-user"></i> Attiva l'account di <?php echo $u->nome ?></h3>
      </div>
      <div class="modal-body">
        <div class="row-fluid">
          <div class="span12">
            <p>Con questa procedura è possibile attivare l'account di un volontario che ancora non può accedere a Gaia
            in quanto non risulta avere un indirizzo email.</p>
            <p>Per attivare l'account del volontario inserisci nei campi sottostanti l'indirizzo email del volontario. Verrà
            generata dal sistema un'email contenente le credenziali di accesso a Gaia e tutte le informazioni necessarie.</p>
            <p>Una volta inserita l'email non ti sarà possibile modificarla, in caso di errori rivolgiti a
            <a href="mailto:supporto@gaia.cri.it"> supporto@gaia.cri.it</a></p>
            <form class="form-horizontal" action="?p=presidente.attiva.volontario.ok" method="POST">
              <input type="hidden" name="vol" value="<?php echo $u->id; ?>" />
              <div class="control-group">
                <label class="control-label" for="inputEmail">Inserisci email</label>
                <div class="controls">
                  <input value="<?php echo $u->email; ?>" required autocomplete="off" type="email" id="inputEmail" name="inputEmail" />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="inputEmail2">Verifica email</label>
                <div class="controls">
                  <input value="<?php echo $u->email; ?>" required autocomplete="off" type="email" id="inputEmail2" name="inputEmail2" />
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <button type="submit" class="btn btn-success">Attiva account</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Chiudi</a>
      </div>
    </div>

    <!-- fine modale -->

    <?php } ?>

    <!--Visualizzazione e modifica avatar utente-->
    <div class="span12">
      <h3><i class="icon-edit muted"></i> Anagrafica</h3>

      <?php 
      $ctess = false;
      if(isset($_GET['tessok']) || isset($_GET['tesserr'])) {
        $ctess = true;
      } 
      ?>

      <!--Visualizzazione e modifica avatar utente e tesserino -->
      <?php if ($attivo) { ?>
        <div class="tabbable">
          <ul class="nav nav-tabs">
            <li <?php if(!$ctess) echo "class=\"active\" " ; ?> ><a href="#tab_avatar" data-toggle="tab">Avatar</a></li>
            <li <?php if($ctess) echo "class=\"active\" " ; ?>><a href="#tab_tesserino" data-toggle="tab">Tesserino</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if(!$ctess) echo "active" ; ?>" id="tab_avatar">
              <div class="row-fluid">
                <div class="span6 allinea-centro">
                  <?php if ( isset($_GET['aok']) ) { ?>
                    <div class="alert alert-success">
                      <i class="icon-ok"></i> Fotografia modificata!
                    </div>
                  <?php } elseif ( isset($_GET['aerr']) ) { ?>
                    <div class="alert alert-error">
                      <i class="icon-warning-sign"></i>
                      <strong>Errore</strong> &mdash; File non selezionato, troppo grande o non valido.
                    </div>
                  <?php } ?>
                  <img src="<?php echo $u->avatar()->img(20); ?>" class="img-polaroid" />
                  <br/><br/>
                </div>
              <div class="span5 allinea-sinistra"> 
                <br/>
                <form id="caricaFoto" action="?p=utente.avatar.ok&id=<?php echo $u; ?>&pre" method="POST" enctype="multipart/form-data" class="allinea-sinistra">
                  <p>Per modificare l'avatar:</p>
                  <p>1. <strong>Scegli</strong>: <input type="file" name="avatar" required /></p>
                  <p>2. <strong>Clicca</strong>:<br />
                  <button type="submit" class="btn btn-block btn-success">
                    <i class="icon-save"></i> Salva la foto
                  </button></p>
                </form>
                <br/>
              </div>
            </div>
          </div>

          <div class="tab-pane <?php if($ctess) echo "active" ; ?>" id="tab_tesserino">

            <div class="row-fluid">
              <div class="span6 allinea-centro">
                <?php if ( isset($_GET['tessok']) ) { ?>
                  <div class="alert alert-success">
                    <i class="icon-ok"></i> Fototessera modificata!
                  </div>
                <?php } elseif ( isset($_GET['tesserr']) ) { ?>
                  <div class="alert alert-error">
                    <i class="icon-warning-sign"></i>
                    <strong>Errore</strong> &mdash; File non selezionato, troppo grande o non valido.
                  </div>
                <?php } 
                if ($u->fototessera()) { ?>
                  <img src="<?php echo $u->fototessera()->img(20); ?>" class="img-polaroid" />
                <?php } else { ?>
                  <div class="alert alert-info">
                    <p><i class="icon-warning-sign"></i> Potrai caricare foto in formato jpg o png. Ricordati che la foto deve rispettare gli standard riportati <i class="icon-link"></i><a href="http://wiki.gaia.cri.it/index.php?title=Manuale_del_Volontario#Norme_generali" target="_new"> qui</a></a></p>
                  </div>
                  <p><br/>Fototessera non caricata</p>
                <?php } 
                $foto = $u->fototessera();
                ?>

                <br/><br/>
              </div>
              <div class="span5 allinea-sinistra"> 
                <br/>
                <?php 
                if($foto && !$foto->approvata()) { ?>
                  <div class="alert alert-warning">
                    <p><i class="icon-spinner"></i> Fototessera in attesa di approvazione </p>
                  </div>
                  <div class="span12 allinea-centro">
                    <a class="btn btn-success" href="?p=presidente.utente.fototessera.ok&ok&id=<?php echo $u->id; ?>">
                      <i class="icon-ok"></i> Approva
                    </a>
                    <a class="btn btn-danger" href="?p=presidente.utente.fototessera.ok&no&id=<?php echo $u->id; ?>">
                      <i class="icon-trash"></i> Elimina
                    </a>
                </div>
                <?php } 
                if(!$foto || $foto->approvata()) { ?>
                  <form id="caricaFoto" action="?p=presidente.utente.fototessera.ok&id=<?php echo $u; ?>" method="POST" enctype="multipart/form-data" class="allinea-sinistra">
                    <p>Per modificare la foto del tesserino:</p>
                    <p>1. <strong>Scegli</strong>: <input type="file" name="fototessera" required /></p>
                    <p>2. <strong>Clicca</strong>:<br />
                    <button type="submit" class="btn btn-block btn-success">
                      <i class="icon-save"></i> Salva la fototessera
                    </button></p>
                  </form>
                <?php } ?>
                <br/>
              </div>
            </div>
          </div>
        </div>
      </div> 
      <?php } ?>
      <!-- Fine visualizzazione e modifica avatar utente e tesserino -->
    </div>

    <form class="form-horizontal" action="?p=presidente.utente.modifica.ok&t=<?php echo $id; ?>" method="POST">
      <hr />
      <div class="control-group">
        <label class="control-label" for="inputNome">Nome</label>
        <div class="controls">
          <input type="text" name="inputNome" id="inputNome" <?php if(!$admin){?> readonly <?php } ?> value="<?php echo $u->nome; ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputCognome">Cognome</label>
        <div class="controls">
          <input type="text" name="inputCognome" id="inputCognome" <?php if(!$admin){?> readonly <?php } ?> value="<?php echo $u->cognome; ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputSesso">Sesso</label>
        <div class="controls">
          <?php if(!$admin){?> <input class="input-mini" type="text" name="inpuSesso" id="inpuSesso" readonly value="<?php echo $conf['sesso'][$u->sesso]; ?>"> <?php }else{ ?>
            <select class="input-small" id="inputSesso" name="inputSesso" required>
              <?php
                foreach ( $conf['sesso'] as $numero => $tipo ) { ?>
                  <option value="<?php echo $numero; ?>" <?php if ( $numero == $u->sesso ) { ?>selected<?php } ?>><?php echo $tipo; ?></option>
              <?php } ?>
            </select>  
          <?php } ?>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputCodiceFiscale">Codice Fiscale</label>
        <div class="controls">
          <input type="text" name="inputCodiceFiscale" id="inputCodiceFiscale"  <?php if(!$admin){?> readonly <?php } ?> value="<?php echo $u->codiceFiscale; ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputDataNascita">Data di Nascita</label>
        <div class="controls">
          <input type="text" class="input-small" name="inputDataNascita" id="inputDataNascita" <?php if(!$admin){?> required <?php } ?> <?php if(!$hoPotere){?> readonly <?php } ?> value="<?php echo date('d/m/Y', $u->dataNascita); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputProvinciaNascita">Provincia di Nascita</label>
        <div class="controls">
          <input class="input-mini" type="text" name="inputProvinciaNascita" id="inputProvinciaNascita" <?php if(!$admin){?> required <?php } ?> <?php if(!$hoPotere){?> readonly <?php } ?> value="<?php echo $u->provinciaNascita; ?>" pattern="[A-Za-z]{2}">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
        <div class="controls">
          <input type="text" name="inputComuneNascita" id="inputComuneNascita" <?php if(!$admin){?> required <?php } ?> <?php if(!$hoPotere){?> readonly <?php } ?> value="<?php echo $u->comuneNascita; ?>">
        </div>
      </div>

      <div class="control-group">
       <label class="control-label" for="inputIndirizzo">Indirizzo</label>
       <div class="controls">
         <input value="<?php echo $u->indirizzo; ?>" type="text" id="inputIndirizzo" <?php if(!$hoPotere){?> readonly <?php } ?> name="inputIndirizzo" <?php if(!$admin){?> required <?php } ?> />
       </div>
     </div>
     <div class="control-group">
       <label class="control-label" for="inputCivico">Civico</label>
       <div class="controls">
         <input value="<?php echo $u->civico; ?>" type="text" id="inputCivico" <?php if(!$hoPotere){?> readonly <?php } ?> name="inputCivico" class="input-small" <?php if(!$admin){?> required <?php } ?> />
       </div>
     </div>
     <div class="control-group">
       <label class="control-label" for="inputComuneResidenza">Comune di residenza</label>
       <div class="controls">
         <input value="<?php echo $u->comuneResidenza; ?>" type="text" id="inputComuneResidenza" <?php if(!$hoPotere){?> readonly <?php } ?> name="inputComuneResidenza" <?php if(!$admin){?> required <?php } ?> />
       </div>
     </div>
     <div class="control-group">
       <label class="control-label" for="inputCAPResidenza">CAP di residenza</label>
       <div class="controls">
         <input value="<?php echo $u->CAPResidenza; ?>" class="input-small" type="text" id="inputCAPResidenza" <?php if(!$hoPotere){?> readonly <?php } ?> name="inputCAPResidenza" <?php if(!$admin){?> required <?php } ?> pattern="[0-9]{5}" />
       </div>
     </div>
     <div class="control-group">
       <label class="control-label" for="inputProvinciaResidenza">Provincia di residenza</label>
       <div class="controls">
         <input value="<?php echo $u->provinciaResidenza; ?>" class="input-mini" type="text" id="inputProvinciaResidenza" <?php if(!$hoPotere){?> readonly <?php } ?> name="inputProvinciaResidenza" <?php if(!$admin){?> required <?php } ?> pattern="[A-Za-z]{2}" />
       </div>
     </div>
     <div class="control-group">
       <label class="control-label" for="inputEmail">Email</label>
       <div class="controls">
         <input value="<?php echo $u->email; ?>" <?php if(!$admin){?> readonly <?php } ?> type="email" id="inputEmail" name="inputEmail" />
       </div>
     </div>
     <div class="control-group input-prepend">
       <label class="control-label" for="inputCellulare">Cellulare</label>
       <div class="controls">
         <span class="add-on">+39</span>
         <input value="<?php echo $u->cellulare; ?>"  type="text" id="inputCellulare" <?php if(!$hoPotere){?> readonly <?php } ?> name="inputCellulare" pattern="[0-9]{9,11}" />
       </div>
     </div>
     <?php if($attivo) { ?>
       <div class="control-group input-prepend">
         <label class="control-label" for="inputCellulareServizio">Cellulare Servizio</label>
         <div class="controls">
           <span class="add-on">+39</span>
           <input value="<?php echo $u->cellulareServizio; ?>"  type="text" id="inputCellulareServizio" <?php if(!$hoPotere){?> readonly <?php } ?> name="inputCellulareServizio" pattern="[0-9]{9,11}" />
         </div>
       </div>
     <?php } ?>
     <div class="control-group">
      <label class="control-label" for="inputConsenso">Consenso dati personali</label>
      <div class="controls">
       <input value="<?php if($u->consenso()){ echo "Acquisito";}else{ echo "Non Acquisito"; } ?>"  type="text" id="inputConsenso" name="inputConsenso" readonly/>
     </div>
   </div>
   <div class="control-group">
      <label class="control-label" for="ultimoAccesso">Ultimo Accesso a Gaia</label>
      <div class="controls">
       <input value="<?php echo $u->ultimoAccesso(); ?>"  type="text" id="ultimoAccesso" name="ultimoAccesso" readonly/>
     </div>
   </div>

   <?php if($admin) { ?>
      <div class="control-group">
        <label class="control-label" for="inputStato">Stato</label>
        <div class="controls">
          <select class="input-medium" id="inputStato" name="inputStato" required>
            <?php
            foreach ( $conf['statoPersona'] as $numero => $tipo ) { 
              if($tipo != 'Nessuno') {?>
            <option value="<?php echo $numero; ?>" <?php if ( $numero == $u->stato ) { ?>selected<?php } ?>><?php echo $tipo; ?></option>
            <?php }
            } ?>
          </select>  
        </div>
      </div>
   <?php } ?>
      <div class="control-group">
        <label class="control-label">Infermiera Volontaria</label>
        <div class="controls">
          <input type="checkbox" <?php if($u->iv){ ?> checked <?php } ?> id="inputIV" name="inputIV" <?php if(!$me->admin() && $u->iv || $u->cm && !$hoPotere){?> readonly <?php } ?>>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">Corpo Militare volontario</label>
        <div class="controls">
          <input type="checkbox" <?php if($u->cm){ ?> checked <?php } ?> id="inputCM" name="inputCM" <?php if(!$me->admin() && $u->iv || $u->cm && !$hoPotere){?> readonly <?php } ?>>
        </div>
      </div>
   <?php if($hoPotere) { ?>
      <hr />
      <div class="form-actions">
       <div class="btn-group">
          <button type="submit" class="btn btn-success btn-large">
            <i class="icon-save"></i>
            Salva modifiche
          </button>
        </div>
      </div>
    <?php } ?>
  </form>    
</div>
<!--Visualizzazione e modifica appartenenze utente -->
<div class="span6">
<?php if ($admin) { ?>
  <div class="row-fluid">
    <h4><i class="icon-github"></i> Opzioni admin</h4>
    <div class="span12 allinea-centro">
      <a onClick="return confirm('Vuoi veramente cancellare questo utente?');" 
        href="?p=admin.utente.cancella&id=<?php echo $id; ?>" class="btn btn-danger">
        <i class="icon-trash"></i> Cancella
      </a>
      <?php if($attivo) { ?>
        <a onClick="return confirm('Vuoi veramente far diventare un ordinario questo utente?');" 
          href="?p=admin.ordinarizza&id=<?= $id; ?>" class="btn btn-warning">
          <i class="icon-hand-down"></i> Ordinarizza
        </a>
      <?php } else { ?>
        <a onClick="return confirm('Vuoi veramente far diventare un volontario questo utente?');" 
          href="?p=admin.volontarizza&id=<?= $id; ?>" class="btn btn-warning">
          <i class="icon-hand-up"></i> Volontarizza
        </a>
      <?php } ?>
      <a class="btn btn-primary" href="?p=admin.beuser&id=<?= $id; ?>" title="Log in">
        <i class="icon-key"></i> Login
      </a>
      <?php if(!Appartenenza::filtra([['volontario', $id]])) { ?>
      <a class="btn btn-info" href="?p=admin.limbo.comitato.nuovo&id=<?= $id; ?>" title="Assegna a Comitato" target="_new">
        <i class="icon-arrow-right"></i> Assegna a Comitato
      </a>
      <?php } ?>
    </div>
  </div>
<?php }?>
<?php if($attivo) { ?>
  <div class="row-fluid">
    <div class="span12">
      <h4><i class="icon-folder-open"></i> Documenti volontario</h4>
      <?php if(isset($_GET['errDoc'])){?>
        <div class="alert alert-error">
          <i class="icon-warning-sign"></i>
          <strong>Errore</strong> 
          <p>File troppo grande o non valido. Si accettano file come <strong>JPG</strong>, <strong>PNG</strong>, ecc.<br />
          Al momento non sono ancora supportati i <strong>PDF</strong>.</p>
        </div>
      <?php 
      }
      if ( $u->documenti() ) { ?>
      <a href="?p=presidente.utente.documenti&id=<?php echo $u->id; ?>" data-attendere="Generazione in corso...">
        <i class="icon-download-alt"></i>
        Scarica documenti del volontario in ZIP
      </a>
      <span class="text-info">
        <p>Puoi caricare altri documenti o sostituirli usando i pulsanti qua sotto.</p>
      </span>
      <?php } else { ?>
      <span class="text-info">
        <i class="icon-warning-sign"></i>
        Il volontario non ha caricato documenti. Puoi caricarli usando i pulsanti qua sotto.
      </span>
      <?php } ?>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12 centrato">
      <br />
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <?php foreach ( $conf['docs_tipologie'] as $tipo => $nome ) { ?>
          <li><a href="#tab<?=$tipo?>" data-toggle="tab"><?=$nome?></a></li>
          <?php } ?>
        </ul>
        <div class="tab-content">
          <?php foreach ( $conf['docs_tipologie'] as $tipo => $nome ) { ?>
          <div class="tab-pane" id="tab<?=$tipo?>">
            <div class="row-fluid">
            <!-- INIZIO BLOCCO DOCUMENTI-->

            <?php if ( $d = $u->documento($tipo) ) { ?>
            <div class="row-fluid">
              <div class="span5 allinea-centro">
                <div class="alert alert-info allinea-sinistra">
                  <i class="icon-time"></i>
                  Documento caricato il <strong><?php echo date('d-m-Y', $d->timestamp); ?></strong>.
                </div> 
                <p><img src="<?php echo $d->anteprima(); ?>" class="img-polaroid" /></p>
                <p>
                  <a href="<?php echo $d->originale(); ?>" class="btn btn-primary" target="_new">
                    <i class="icon-download"></i>
                    Scarica questo documento
                  </a>
                </p>
              </div>
              <div class="span7">
                <form class="modDocumento" action="?p=presidente.utente.documenti.ok&id=<?php echo $u->id; ?>" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="tipo" value="<?php echo $tipo; ?>" />
                  <h4>
                    <i class="icon-edit"></i>
                    Modifica o carica nuovo documento
                  </h4>
                  <p>Nel caso tu voglia aggiornare o modificare il documento,<br />
                    segui queste istruzioni:</p>
                    <ol>
                      <li>
                        <p>
                          <strong>Seleziona il file</strong> dal tuo computer:<br />
                          <input type="file" name="file" />
                        </p>
                      </li>
                      <li><p>
                        <strong>Clicca sul pulsante</strong>:<br />
                        <button type="submit" class="btn btn-success">
                          <i class="icon-save"></i> Carica documento
                        </button>
                      </p>
                    </li>
                  </ol>
                </form>
              </div>
            </div>
            <?php } else { ?>
            <div class="row-fluid">
              <div class="span5 allinea-centro">
                <div class="alert alert-warning allinea-sinistra">
                  <i class="icon-warning-sign"></i>
                  Non caricato.
                </div> 
                <p>
                </p>
              </div>
              <div class="span7">
                <form class="modDocumento" action="?p=presidente.utente.documenti.ok&id=<?php echo $u->id; ?>" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="tipo" value="<?php echo $tipo; ?>" />
                  <h4>
                    <i class="icon-plus"></i>
                    Aggiungi il documento
                  </h4>
                  <ol>
                    <li>
                      <p>
                        <strong>Seleziona il file</strong> dal tuo computer:<br />
                        <input type="file" name="file" />
                      </p>
                    </li>
                    <li><p>
                      <strong>Clicca sul pulsante</strong>:<br />
                      <button type="submit" class="btn btn-success">
                        <i class="icon-save"></i> Carica documento
                      </button>
                    </p>
                  </li>
                </ol>
              </form>
            </div>
          </div>
          <?php } ?>

            <!-- FINE BLOCCO DOCUMENTI-->
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>

  <div class="row-fluid">
    <h4>
      <i class="icon-time muted"></i>
      Appartenenze attuali
    </h4>

  </div>

  <div class="row-fluid">

    <table class="table table-bordered table-striped">
      <thead>
        <th>Ruolo</th>
        <th>Comitato</th>
        <th>Inizio</th>
        <th>Fine</th>
        <th>Azioni</th>
      </thead>
      <?php 
        if($u->stato == VOLONTARIO) {
          $appartenenze = $u->appartenenzeAttuali();
        } else {
          $appartenenze = $u->appartenenzeAttuali(MEMBRO_ORDINARIO);
        }

      foreach ( $appartenenze as $app ) { ?>
        <tr class="success">
          <td>
            <strong><?php echo $conf['membro'][$app->stato]; ?></strong>
          </td>

          <td>
            <?php echo $app->comitato()->nomeCompleto(); ?>
          </td>

          <td>
            <i class="icon-calendar muted"></i>
            <?php echo $app->inizio()->inTesto(false); ?>
          </td>

          <td>
            <?php if ($app->fine) { ?>
            <i class="icon-time muted"></i>
            <?php echo $app->fine()->inTesto(false); ?>
            <?php } else { ?>
            <i class="icon-question-sign muted"></i>
            Indeterminato
            <?php } ?>
          </td>

          <td>

            <div class="btn-group">
              <?php if($hoPotere) { ?>
              <a href="?p=us.appartenenza.modifica&a=<?php echo $app; ?>" title="Modifica appartenenza" class="btn btn-small btn-info">
                <i class="icon-edit"></i>
              </a>
              <?php } if($me->admin()){ ?>
              <a onClick="return confirm('Vuoi veramente cancellare questa appartenenza ?');" href="?p=us.appartenenza.cancella&a=<?php echo $app; ?>" title="Cancella appartenenza" class="btn btn-small btn-danger">
                <i class="icon-trash"></i>
              </a>
              <?php } ?>
            </div>
          </td>
        </tr>
      <?php } ?>

    </table>
  </div>

  <!-- Blocco storico -->
  <div class="row-fluid">
    <h4>
      <i class="icon-ellipsis-horizontal muted"></i>
      Storico
    </h4>

  </div>
  <div class="span12 allinea-centro">

    <a class="btn btn-small" target="_new" href="?p=presidente.riserva.storico&id=<?php echo $u->id; ?>">
      <i class="icon-pause"></i> Riserve
    </a>
    <a class="btn btn-small" target="_new" href="?p=presidente.appartenenze.storico&id=<?php echo $u->id; ?>">
      <i class="icon-time"></i> Appartenenze
    </a>
    <a class="btn btn-small" target="_new" href="?p=us.quote.visualizza&id=<?php echo $u->id; ?>">
      <i class="icon-money"></i> Quote
    </a>
    <br/>
    <?php if ( $u->corsiBase() ){ ?>
      <a class="btn btn-small" target="_new" href="?p=presidente.utente.corsibase&id=<?php echo $u->id; ?>">
        <i class="icon-certificate"></i> Storico corsi base
      </a>
    <?php } ?>
      <a class="btn btn-small" target="_new" href="?p=presidente.incarichi.visualizza&id=<?php echo $u->id; ?>">
        <i class="icon-briefcase"></i> Storico incarichi
      </a>
      <a class="btn btn-small" target="_new" href="?p=presidente.utente.turni&id=<?php echo $u->id; ?>">
        <i class="icon-list"></i> Storico turni
      </a>
    </div>
  </div>

<!--Visualizzazione e modifica titoli utente-->
<?php $titoli = $conf['titoli']; ?>
  <div class="span6">
    <?php if ( isset($_GET['gia'] ) ) { ?>
      <div class="alert alert-error">
        <i class="icon-warning-sign"></i>
        <strong>Errore</strong> &mdash; Non puoi inserire lo stesso titolo o qualifica due volte.
      </div>
    <?php } ?>
    <h4><i class="icon-list muted"></i> Curriculum </h4>
    <div id="step1">
    <?php if($hoPotere) { ?>
      <div class="alert alert-block alert-success" <?php if ($titoli[2]) { ?>data-richiediDate<?php } ?>>
        <div class="row-fluid">
          <span class="span3">
            <label for="cercaTitolo">
              <span style="font-size: larger;">
                <i class="icon-search"></i>
                <strong>Cerca</strong>
              </span>
            </label>

          </span>
          <span class="span9">
            <input type="text" autofocus required id="cercaTitolo" placeholder="Inserisci un titolo..." class="span12" />
          </span>
        </div>
      </div>
    <?php } ?>

    <table class="table table-striped table-condensed table-bordered" id="risultatiRicerca" style="display: none;">
      <thead>
        <th>Nome risultato</th>
        <th>Cerca</th>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>

  <div id="step2" style="display: none;">
    <form action='?p=presidente.titolo.nuovo&id=<?php echo $u->id; ?>' method="POST">
      <input type="hidden" name="idTitolo" id="idTitolo" />
      <div class="alert alert-block alert-success">
        <div class="row-fluid">
          <h4><i class="icon-question-sign"></i> Quando hai ottenuto...</h4>
        </div>
        <hr />
        <div class="row-fluid">
          <div class="span4 centrato">
            <label for="dataInizio"><i class="icon-calendar"></i> Ottenimento</label>
          </div>
          <div class="span8">
            <input id="dataInizio" class="span12" name="dataInizio" type="text" value="" />
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4 centrato">
            <label for="dataFine"><i class="icon-time"></i> Scadenza</label>
          </div>
          <div class="span8">
            <input id="dataFine" class="span12" name="dataFine" type="text" value="" />
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4 centrato">
            <label for="luogo"><i class="icon-road"></i> Luogo</label>
          </div>
          <div class="span8">
            <input id="luogo" class="span12" name="luogo" type="text" value="" />
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4 centrato">
            <label for="codice"><i class="icon-barcode"></i> Codice</label>
          </div>
          <div class="span8">
            <input id="codice" class="span12" name="codice" type="text" value="" />
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4 centrato">
            <label for="codice"><i class="icon-barcode"></i> N. Patente</label>
          </div>
          <div class="span8">
            <input id="codice" class="span12" name="codice" type="text" value="" />
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4 offset8">
            <button type="submit" class="btn btn-success">
              <i class="icon-plus"></i>
              Aggiungi il titolo
            </button>
          </div>
        </div>
      </div>
	</form>
  </div> 

    <table class="table table-striped">
      <?php foreach ( $t as $titolo ) { ?>
        <tr <?php if (!$titolo->tConferma) { ?>class="warning"<?php } ?>>
          <td>
            <?php if ($titolo->tConferma) { ?>
            <abbr title="Confermato: <?php echo date('d-m-Y H:i', $titolo->tConferma); ?>">
              <i class="icon-ok"></i>
            </abbr>
            <?php } else { ?>
            <abbr title="Pendente">
              <i class="icon-time"></i>
            </abbr>
            <?php } ?> 

            <strong><?php echo $titolo->titolo()->nome; ?></strong><br />
            <small><?php echo $conf['titoli'][$titolo->titolo()->tipo][0]; ?></small>
          </td>
          <?php if ( $titolo->inizio ) { ?>
          <td><small>
            <i class="icon-calendar muted"></i>
            <?php echo date('d-m-Y', $titolo->inizio); ?>

            <?php if ( $titolo->fine ) { ?>
            <br />
            <i class="icon-time muted"></i>
            <?php echo date('d-m-Y', $titolo->fine); ?>
            <?php } ?>
            <?php if ( $titolo->luogo ) { ?>
            <br />
            <i class="icon-road muted"></i>
            <?php echo $titolo->luogo; ?>
            <?php } ?>
            <?php if ( $titolo->codice ) { ?>
            <br />
            <i class="icon-barcode muted"></i>
            <?php echo $titolo->codice; ?>
            <?php } ?>
          </small></td>
          <?php } else { ?>
          <td>&nbsp;</td>
          <?php } ?>

          <td>
            <?php if($hoPotere) { ?>
            <div class="btn-group">
              <a href="?p=presidente.titolo.modifica&t=<?php echo $titolo->id; ?>&v=<?php echo $u->id; ?>" title="Modifica il titolo" class="btn btn-small btn-info">
                <i class="icon-edit"></i>
              </a>
              <a onclick="return confirm('Cancellare il titolo utente?');" href="?p=utente.titolo.cancella&id=<?php echo $titolo->id; ?>&pre" title="Cancella il titolo" class="btn btn-small btn-danger">
                <i class="icon-trash"></i>
              </a>
            </div>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>


	<!--Visualizzazione e modifica donazioni utente-->
	<?php 

	$donazioni = $conf['donazioni']; ?>
	<div class="span6">
		<h4><i class="icon-list muted"></i> Donazioni </h4>

		<?php $anagrafica = DonazioneAnagrafica::filtra([['volontario',$u]]); ?>
		<form class="form-horizontal" action="?p=presidente.donazione.anagrafica.ok&id=<?php echo $u->id; ?>" method="POST">
			<div class="control-group">
				<label class="control-label" for="inputSangueGruppo">Gruppo Sanguigno</label>
				<div class="controls">
					<select id="inputSangueGruppo" name="inputSangueGruppo" required <?php if(!$admin){?> readonly <?php } ?>>
						<option selected="selected" disabled=""></option>
						<?php
						foreach($conf['anagrafica_donatore']['sangue_gruppo'] as $key => $value){
							if ( $value !== null ) {
								echo "<option value=\"".$key."\"";
								if(count($anagrafica) AND $anagrafica[0]->sangue_gruppo == $key) echo " selected";
								echo ">".$value."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputFattoreRH">Fattore RH</label>
				<div class="controls">
					<select id="inputFattoreRH" name="inputFattoreRH" <?php if(!$admin){?> readonly <?php } ?>>
						<option selected="selected"></option>
						<?php
						foreach($conf['anagrafica_donatore']['fattore_rh'] as $key => $value){
							if ( $value !== null ) {
								echo "<option value=\"".$key."\"";
								if(count($anagrafica) AND $anagrafica[0]->fattore_rh == $key) echo " selected";
								echo ">".$value."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputFenotipoRH">Fenotipo RH</label>
				<div class="controls">
					<select id="inputFenotipoRH" name="inputFenotipoRH" <?php if(!$admin){?> readonly <?php } ?>>
						<option selected="selected"></option>
						<?php
						foreach($conf['anagrafica_donatore']['fanotipo_rh'] as $key => $value){
							if ( $value !== null ) {
								echo "<option value=\"".$key."\"";
								if(count($anagrafica) AND $anagrafica[0]->fanotipo_rh == $key) echo " selected";
								echo ">".$value."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputKell">Kell</label>
				<div class="controls">
					<select id="inputKell" name="inputKell" <?php if(!$admin){?> readonly <?php } ?>>
						<option selected="selected"></option>
						<?php
						foreach($conf['anagrafica_donatore']['kell'] as $key => $value){
							if ( $value !== null ) {
								echo "<option value=\"".$key."\"";
								if(count($anagrafica) AND $anagrafica[0]->kell == $key) echo " selected";
								echo ">".$value."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputCodiceSIT">Codice SIT</label>
				<div class="controls">
					<input type="text" class="input-small" name="inputCodiceSIT" id="inputCodiceSIT" value="<?php if(count($anagrafica) AND $anagrafica[0]->codice_sit) echo $anagrafica[0]->codice_sit; ?>">
				</div>
			</div>

			<?php
			$sedeSIT = (count($anagrafica) AND $anagrafica[0]->sede_sit) ? new DonazioneSede($anagrafica[0]->sede_sit) : false;
			?>
			<div class="control-group">
				<label class="control-label" for="inputSedeSIT">Regione Sede SIT</label>
				<div class="controls">
					<select id="inputSedeSITRegione" name="inputSedeSITRegione" <?php if(!$admin){?> readonly <?php } ?>>
						<option selected="selected"></option>
						<?php
						foreach(DonazioneSede::filtraDistinctSedi('regione') as $value){
							echo "<option value=\"".$value."\"";
							if(($sedeSIT !== false) AND ($sedeSIT->regione == $value)) echo " selected";
							echo ">".$value."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div id="SedeSITProvincia" class="control-group" <?php if($sedeSIT === false) echo 'style="display: none;"'; ?>>
				<label class="control-label" for="inputSedeSIT">Provincia Sede SIT</label>
				<div class="controls">
					<select id="inputSedeSITProvincia" name="inputSedeSITProvincia" <?php if(!$admin){?> readonly <?php } ?>>
					<?php
					if($sedeSIT !== false){
						foreach(DonazioneSede::filtraDistinctSedi("provincia",[["regione",$sedeSIT->regione]]) as $value){
							echo "<option value=\"".$value."\"";
							if($sedeSIT->provincia == $value) echo " selected";
							echo ">".$value."</option>";
						}
					}
					?>
					</select>
				</div>
			</div>
			<div id="SedeSITCitta" class="control-group" <?php if($sedeSIT === false) echo 'style="display: none;"'; ?>>
				<label class="control-label" for="inputSedeSIT">Città Sede SIT</label>
				<div class="controls">
					<select id="inputSedeSITCitta" name="inputSedeSITCitta" <?php if(!$admin){?> readonly <?php } ?>>
					<?php
					if($sedeSIT !== false){
						foreach(DonazioneSede::filtraDistinctSedi("citta",[["provincia",$sedeSIT->provincia]]) as $value){
							echo "<option value=\"".$value."\"";
							if($sedeSIT->citta == $value) echo " selected";
							echo ">".$value."</option>";
						}
					}
					?>
					</select>
				</div>
			</div>
			<div id="SedeSITOspedale" class="control-group" <?php if($sedeSIT === false) echo 'style="display: none;"'; ?>>
				<label class="control-label" for="inputSedeSIT">Unit&agrave; di raccolta</label>
				<div class="controls">
					<select id="inputSedeSIT" name="inputSedeSIT" <?php if(!$admin){?> readonly <?php } ?>>
					<?php
					if($sedeSIT !== false){
						foreach(DonazioneSede::filtraDistinctSedi("nome",[["citta",$sedeSIT->citta]]) as $key => $value){
							echo "<option value=\"".$key."\"";
							if($anagrafica[0]->sede_sit == $key) echo " selected";
							echo ">".$value."</option>";
						}
					}
					?>
					</select>
				</div>
			</div>
			<?php if($admin){?>
				<div class="form-actions">
					<?php if($a!=1){ ?>
						<button type="submit" class="btn btn-success btn-large">
							<i class="icon-save"></i>
							Salva modifiche
						</button>
					<?php }?>
				</div>
			<?php } ?>
		</form>

		<div id="step1Donazione">
			<?php if($hoPotere) { ?>
				<div class="alert alert-block alert-success" <?php if ($donazioni[2]) { ?>data-richiediDate<?php } ?>>      
					<div class="row-fluid">
						<span class="span3">
							<label for="cercaTitolo">
								<span style="font-size: larger;">
									<i class="icon-search"></i>
									<strong>Cerca</strong>
								</span>
							</label>
						</span>
						<span class="span9">
							<select id="tipo" name="tipo" class="span12" required>
								<option selected="selected" disabled=""></option>
								<?php
								foreach(Donazione::elenco() as $value){
									echo "<option value=\"".$value."\">".$value->nome."</option>";
								}
								?>
							</select>
						</span>
					</div>
				</div>
			<?php } ?>
		</div>

		<div id="step2Donazione" style="display: none;">
			<form action="?p=presidente.donazione.nuovo&id=<?php echo $u->id; ?>" method="POST">
				<input type="hidden" name="idDonazione" id="idDonazione" />
				<div class="alert alert-block alert-success">
					<div class="row-fluid">
						<h4><i class="icon-question-sign"></i> Quando e dove ha donato...</h4>
					</div>
					<hr />
					<div class="row-fluid">
						<div class="span4 centrato">
							<label for="data"><i class="icon-calendar"></i> Donazione</label>
						</div>
						<div class="span8">
							<input id="data" class="span12" name="data" type="text" value="" required/>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span4 centrato">
							<label for="sedeRegione">Regione</label>
						</div>
						<div class="span8">
							<select id="sedeRegione" name="sedeRegione" class="span12" required>
								<option selected="selected" disabled=""></option>
								<?php
								foreach(DonazioneSede::filtraDistinctSedi('regione') as $value){
									echo "<option value=\"".$value."\">".$value."</option>";
								}
								?>
							</select>
						</div>
					</div>

					<div id="provincia" class="row-fluid" style="display: none;">
						<div class="span4 centrato">
						<label for="sedeProvincia">Provincia</label>
						</div>
						<div class="span8">
						<select id="sedeProvincia" name="sedeProvincia" class="span12" required></select>
						</div>
					</div>

					<div id="citta" class="row-fluid" style="display: none;">
						<div class="span4 centrato">
						<label for="sedeCitta">Città</label>
						</div>
						<div class="span8">
						<select id="sedeCitta" name="sedeCitta" class="span12" required></select>
						</div>
					</div>

					<div id="ospedale" class="row-fluid" style="display: none;">
						<div class="span4 centrato">
						<label for="sede"><i class="icon-road"></i> Unit&agrave; di raccolta</label>
						</div>
						<div class="span8">
						<select id="sede" name="sede" class="span12" required></select>
						</div>
					</div>

					<div class="row-fluid">
						<div class="span4 offset8">
							<button type="submit" class="btn btn-success" onclick="">
								<i class="icon-plus"></i>
								Aggiungi la donazione
							</button>
						</div>
					</div>
				</div>
			</form>
		</div> 

		<table class="table table-striped">
			<?php foreach ( $do as $donazione ) { ?>
			<tr <?php if (!$donazione->tConferma) { ?>class="warning"<?php } ?>>
				<td>
					<?php if ($donazione->tConferma) { ?>
						<abbr title="Confermato: <?php echo date('d-m-Y H:i', $donazione->tConferma); ?>">
							<i class="icon-ok"></i>
						</abbr>
					<?php } else { ?>
						<abbr title="Pendente">
							<i class="icon-time"></i>
						</abbr>
					<?php } ?> 
					<strong><?php echo $donazione->donazione()->nome; ?></strong><br />
					<small><?php echo $conf['donazioni'][$donazione->donazione()->tipo][0]; ?></small>
				</td>
				<td>
					<small>
						<i class="icon-calendar muted"></i>
						<?php echo date('d-m-Y', $donazione->data); ?>
						<br />
						<i class="icon-road muted"></i>
						<?php echo DonazioneSede::by('id',$donazione->luogo)->provincia.' - '.DonazioneSede::by('id',$donazione->luogo)->nome; ?>
					</small></td>
				<td>
					<?php if($hoPotere) { ?>
						<div class="btn-group">
							<a href="?p=presidente.donazione.modifica&t=<?php echo $donazione->id; ?>&v=<?php echo $u->id; ?>" title="Modifica la donazione" class="btn btn-small btn-info">
								<i class="icon-edit"></i>
							</a>
							<a onclick="return confirm('Cancellare la donazione utente?');" href="?p=utente.donazione.cancella&id=<?php echo $donazione->id; ?>&pre" title="Cancella la donazione" class="btn btn-small btn-danger">
								<i class="icon-trash"></i>
							</a>
						</div>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
  </div>
<!--</div>-->