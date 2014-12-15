<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();


$ctess = false;
if(isset($_GET['tessok']) || isset($_GET['tesserr'])) {
  $ctess = true;
}


?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span6">
        <h2><i class="icon-edit muted"></i> Anagrafica</h3>
        
        <?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Salvato</strong>.
            Le modifiche richieste sono state memorizzate con successo.
        </div>
        <?php } else { ?>
        <div class="alert alert-block alert-info">
            <h4><i class="icon-question-sign"></i> Qualcosa è sbagliato?</h4>
            <p>Se qualche informazione è errata e non riesci a modificarla,
                <a href="?p=utente.supporto"><i class="icon-envelope-alt"></i> clicca qui </a> per ricevere supporto.</p>
        </div>
        <?php } ?>
        <?php foreach ( $me->storico() as $app ) {
                         if($app->stato == MEMBRO_DIMESSO){ $a=1;}} ?>
        <form class="form-horizontal" action="?p=utente.anagrafica.ok" method="POST">
            <div class="control-group">
              <label class="control-label" for="inputNome">Nome</label>
              <div class="controls">
                <input type="text" name="inputNome" id="inputNome" readonly value="<?php echo $me->nome; ?>">
                <acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputCognome">Cognome</label>
              <div class="controls">
                <input type="text" name="inputCognome" id="inputCognome" readonly value="<?php echo $me->cognome; ?>">
                <acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>
              </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputSesso">Sesso</label>
            <div class="controls">
              <input class="input-mini" type="text" name="inpuSesso" id="inpuSesso" readonly value="<?php echo $conf['sesso'][$me->sesso]; ?>"> 
              <acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>
            </div>
          </div>
            <div class="control-group">
              <label class="control-label" for="inputCodiceFiscale">Codice Fiscale</label>
              <div class="controls">
                <input type="text" name="inputCodiceFiscale" id="inputCodiceFiscale" readonly value="<?php echo $me->codiceFiscale; ?>">
                <acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputDataNascita">Data di Nascita</label>
              <div class="controls">
                <input type="text" class="input-small" name="inputDataNascita" id="inputDataNascita" readonly value="<?php echo date('d/m/Y', $me->dataNascita); ?>">
                <acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>

              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputProvinciaNascita">Provincia di Nascita</label>
              <div class="controls">
                <input class="input-mini" type="text" name="inputProvinciaNascita" id="inputProvinciaNascita" readonly value="<?php echo $me->provinciaNascita; ?>" pattern="[A-Za-z]{2}">
                <acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
              <div class="controls">
                <input type="text" name="inputComuneNascita" id="inputComuneNascita" readonly value="<?php echo $me->comuneNascita; ?>">
                <acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>
              </div>
            </div>

            <div class="control-group">
               <label class="control-label" for="inputIndirizzo">Indirizzo</label>
               <div class="controls">
                 <input value="<?php echo $me->indirizzo; ?>" type="text" id="inputIndirizzo" name="inputIndirizzo" required <?php if($a==1){ ?>readonly<?php }?> />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputCivico">Civico</label>
               <div class="controls">
                 <input value="<?php echo $me->civico; ?>" type="text" id="inputCivico" name="inputCivico" class="input-small" required <?php if($a==1){ ?>readonly<?php }?> />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputComuneResidenza">Comune di residenza</label>
               <div class="controls">
                 <input value="<?php echo $me->comuneResidenza; ?>" type="text" id="inputComuneResidenza" name="inputComuneResidenza" required <?php if($a==1){ ?>readonly<?php }?> />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputCAPResidenza">CAP di residenza</label>
               <div class="controls">
                 <input value="<?php echo $me->CAPResidenza; ?>" class="input-small" type="text" id="inputCAPResidenza" name="inputCAPResidenza" required pattern="[0-9]{5}" <?php if($a==1){ ?>readonly<?php }?> />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputProvinciaResidenza">Provincia di residenza</label>
               <div class="controls">
                 <input value="<?php echo $me->provinciaResidenza; ?>" class="input-mini" type="text" id="inputProvinciaResidenza" name="inputProvinciaResidenza" required pattern="[A-Za-z]{2}" <?php if($a==1){ ?>readonly<?php }?> />
                 &nbsp; <span class="muted">ad es.: CT</span>
               </div>
             </div>
            <div class="form-actions">
                <?php if($a!=1){ ?>
                <button type="submit" class="btn btn-success btn-large">
                    <i class="icon-save"></i>
                    Salva modifiche
                </button>
               <?php }?>
            </div>
          </form>

    </div>
    
    <div class="span3 allinea-centro">
      <?php if($me->appartenenzaAttuale()) { ?>
        <h3>Fotografia</h3>
        <div class="tabbable">
          <ul class="nav nav-tabs">
            <li <?php if(!$ctess) echo "class=\"active\" " ; ?> ><a href="#tab_avatar" data-toggle="tab">Avatar</a></li>
            <li <?php if($ctess) echo "class=\"active\" " ; ?>><a href="#tab_tesserino" data-toggle="tab">Tesserino</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if(!$ctess) echo "active" ; ?>" id="tab_avatar">
              <div class="row-fluid">
                <?php if ( isset($_GET['aok']) ) { ?>
                <div class="alert alert-success">
                  <i class="icon-ok"></i> Fotografia modificata!
                </div>
                <?php } elseif ( isset($_GET['aerr']) ) { ?>
                <div class="alert alert-error">
                  <i class="icon-warning-sign"></i>
                  <strong>Errore</strong> &mdash; File non selezionato, troppo grande o non valido.
                </div>
                <?php } else { ?>
                <p>Questa è il tuo avatar</p>
                <?php } ?>
              
                <img src="<?php echo $me->avatar()->img(20); ?>" class="img-polaroid" />
                <hr />
                <?php if($a!=1){ ?>
                <form id="caricaFoto" action="?p=utente.avatar.ok" method="POST" enctype="multipart/form-data" class="allinea-sinistra">
                  <p>Per modificare la foto:</p>
                  <p>1. <strong>Scegli</strong> un file <strong>JPG,PNG</strong>: <input type="file" name="avatar" required /></p>
                  <p>2. <strong>Clicca</strong>:<br />
                  <button type="submit" class="btn btn-block btn-success">
                    <i class="icon-save"></i> Salva la foto
                  </button></p>
                </form>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane <?php if($ctess) echo "active" ; ?>" id="tab_tesserino">

              <div class="row-fluid">
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
                if ($me->fototessera()) { ?>
                  <img src="<?php echo $me->fototessera()->img(20); ?>" class="img-polaroid" />
                <?php } else { ?>
                  <div class="alert alert-info">
                    <!-- Manca link alle norme ICAO nostre standard -->
                    <p><i class="icon-warning-sign"></i> Potrai caricare foto in formato jpg o png. Ricordati che la foto deve rispettare gli standard riportati <i class="icon-link"></i><a href="http://wiki.gaia.cri.it/index.php?title=Manuale_del_Volontario#Norme_generali" target="_new"> qui</a></p>
                  </div>
                  <p><br />Fototessera non caricata</p>
                <?php } ?>
                <br/>
                <hr />
                <?php 
                $foto = $me->fototessera();
                if($foto && !$foto->approvata()) { ?>
                  <div class="alert alert-warning">
                    <p><i class="icon-spinner"></i> Fototessera in attesa di approvazione </p>
                  </div>
                <?php } 
                if(!$foto || !$foto->approvata()) { ?>
                <form id="caricaFoto" action="?p=utente.fototessera.ok" method="POST" enctype="multipart/form-data" class="allinea-sinistra">
                  <p>Per modificare la foto del tesserino:</p>
                  <p>1. <strong>Scegli</strong> un file <strong>JPG,PNG</strong>: <input type="file" name="fototessera" required /></p>
                  <p>2. <strong>Clicca</strong>:<br />
                  <button type="submit" class="btn btn-block btn-success">
                    <i class="icon-save"></i> Salva la fototessera
                  </button></p>
                </form>
                <?php } else { ?>
                  <br />
                  <div class="alert alert-success">
                    <p><i class="icon-ok"></i> Fototessera valida! </p>
                    <p>Per modificarla rivolgiti al tuo ufficio soci. </p>
                  </div>
                <?php } ?>
                <br/>
              </div>

            </div>
          </div>
        </div>
       <?php } ?> 
    </div>
</div>
