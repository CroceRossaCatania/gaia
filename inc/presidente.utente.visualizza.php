<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$f = $_GET['id']; 
$t = new Volontario($f);
$g = $v = $t;

proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);

$a=TitoloPersonale::filtra([['volontario',$f]]);
?>
<!--Visualizzazione e modifica anagrafica utente-->
<div class="row-fluid">
    <div class="span6">
    <?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Salvato</strong>.
            Le modifiche richieste sono state memorizzate con successo.
        </div>
        <?php }  ?>
  <!--Visualizzazione e modifica avatar utente-->
        <div class="span12">
        <h3><i class="icon-edit muted"></i> Anagrafica</h3>
            <div class="span6 allinea-centro">
        <?php if ( isset($_GET['aok']) ) { ?>
            <div class="alert alert-success">
                <i class="icon-ok"></i> Fotografia modificata!
            </div>
        <?php } elseif ( isset($_GET['aerr']) ) { ?>
            <div class="alert alert-error">
                <i class="icon-warning-sign"></i>
                <strong>Errore</strong> &mdash; File troppo grande o non valido.
            </div>
        <?php } else { ?>
            
        <?php } ?>
        <img src="<?php echo $g->avatar()->img(20); ?>" class="img-polaroid" />
               <br/><br/></div>
            <div class="span5 allinea-sinistra"> 
               <br/>
        <form id="caricaFoto" action="?p=utente.avatar.ok&id=<?php echo $f; ?>&pre" method="POST" enctype="multipart/form-data" class="allinea-sinistra">
            <p>Per modificare la foto:</p>
          <p>1. <strong>Scegli</strong>: <input type="file" name="avatar" required /></p>
          <p>2. <strong>Clicca</strong>:<br />
              <button type="submit" class="btn btn-block btn-success">
              <i class="icon-save"></i> Salva la foto
          </button></p>
        </form>
            <br/>   
            </div> 
            </div>
            
<form class="form-horizontal" action="?p=presidente.utente.modifica.ok&t=<?php echo $f; ?>" method="POST">
        <hr />
        <div class="control-group">
              <label class="control-label" for="inputNome">Nome</label>
              <div class="controls">
                <input type="text" name="inputNome" id="inputNome" <?php if(!$me->admin()){?> readonly <?php } ?> value="<?php echo $v->nome; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputCognome">Cognome</label>
              <div class="controls">
                <input type="text" name="inputCognome" id="inputCognome" <?php if(!$me->admin()){?> readonly <?php } ?> value="<?php echo $v->cognome; ?>">
              </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputSesso">Sesso</label>
            <div class="controls">
              <?php if(!$me->admin()){?> <input class="input-mini" type="text" name="inpuSesso" id="inpuSesso" readonly value="<?php echo $conf['sesso'][$v->sesso]; ?>"> <?php }else{ ?>
              <select class="input-small" id="inputSesso" name="inputSesso" required>
                <?php
                    foreach ( $conf['sesso'] as $numero => $tipo ) { ?>
                    <option value="<?php echo $numero; ?>" <?php if ( $numero == $v->sesso ) { ?>selected<?php } ?>><?php echo $tipo; ?></option>
                    <?php } ?>
                </select>  
              <?php } ?>
            </div>
          </div>
            <div class="control-group">
              <label class="control-label" for="inputCodiceFiscale">Codice Fiscale</label>
              <div class="controls">
                <input type="text" name="inputCodiceFiscale" id="inputCodiceFiscale"  <?php if(!$me->admin()){?> readonly <?php } ?> value="<?php echo $v->codiceFiscale; ?>">
                
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputDataNascita">Data di Nascita</label>
              <div class="controls">
                <input type="text" class="input-small" name="inputDataNascita" id="inputDataNascita" value="<?php echo date('d/m/Y', $v->dataNascita); ?>">
              </div>
            </div>
    <div class="control-group">
              <label class="control-label" for="inputProvinciaNascita">Provincia di Nascita</label>
              <div class="controls">
                <input class="input-mini" type="text" name="inputProvinciaNascita" id="inputProvinciaNascita" value="<?php echo $v->provinciaNascita; ?>" pattern="[A-Za-z]{2}">
             </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
              <div class="controls">
                <input type="text" name="inputComuneNascita" id="inputComuneNascita" value="<?php echo $v->comuneNascita; ?>">
              </div>
            </div>

            <div class="control-group">
               <label class="control-label" for="inputIndirizzo">Indirizzo</label>
               <div class="controls">
                 <input value="<?php echo $v->indirizzo; ?>" type="text" id="inputIndirizzo" name="inputIndirizzo" required />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputCivico">Civico</label>
               <div class="controls">
                 <input value="<?php echo $v->civico; ?>" type="text" id="inputCivico" name="inputCivico" class="input-small" required />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputComuneResidenza">Comune di residenza</label>
               <div class="controls">
                 <input value="<?php echo $v->comuneResidenza; ?>" type="text" id="inputComuneResidenza" name="inputComuneResidenza" required />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputCAPResidenza">CAP di residenza</label>
               <div class="controls">
                 <input value="<?php echo $v->CAPResidenza; ?>" class="input-small" type="text" id="inputCAPResidenza" name="inputCAPResidenza" required pattern="[0-9]{5}" />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputProvinciaResidenza">Provincia di residenza</label>
               <div class="controls">
                 <input value="<?php echo $v->provinciaResidenza; ?>" class="input-mini" type="text" id="inputProvinciaResidenza" name="inputProvinciaResidenza" required pattern="[A-Za-z]{2}" />
                </div>
             </div>
            <div class="control-group">
               <label class="control-label" for="inputEmail">Email</label>
               <div class="controls">
                 <input value="<?php echo $v->email; ?>"  type="email" id="inputEmail" name="inputEmail" />
                </div>
             </div>
             <div class="control-group input-prepend">
               <label class="control-label" for="inputCellulare">Cellulare</label>
               <div class="controls">
                   <span class="add-on">+39</span>
                 <input value="<?php echo $v->cellulare; ?>"  type="text" id="inputCellulare" name="inputCellulare" pattern="[0-9]{9,11}" />
                </div>
             </div>
            <div class="control-group input-prepend">
               <label class="control-label" for="inputCellulareServizio">Cellulare Servizio</label>
               <div class="controls">
                   <span class="add-on">+39</span>
                 <input value="<?php echo $v->cellulareServizio; ?>"  type="text" id="inputCellulareServizio" name="inputCellulareServizio" pattern="[0-9]{9,11}" />
                </div>
             </div>
            <div class="control-group">
            <label class="control-label" for="inputgruppoSanguigno">Gruppo Sanguigno</label>
            <div class="controls">
                <select class="input-small" id="inputgruppoSanguigno" name="inputgruppoSanguigno"  required class="disabled">
                <?php
                    foreach ( $conf['sangue_gruppo'] as $numero => $gruppo ) { ?>
                    <option value="<?php echo $numero; ?>" <?php if ( $numero == $v->grsanguigno ) { ?>selected<?php } ?>><?php echo $gruppo; ?></option>
                    <?php } ?>
                </select>   
            </div>
          </div>
        <hr />
         
        <div class="form-actions">
                <button type="submit" class="btn btn-success btn-large">
                    <i class="icon-save"></i>
                    Salva modifiche
                </button>
            </div>
          </form>    
    </div>
        <h4><i class="icon-folder-open"></i> Documenti volontario</h4>
        
        <?php if ( $v->documenti() ) { ?>
            <a href="?p=presidente.utente.documenti&id=<?php echo $v->id; ?>" data-attendere="Generazione in corso...">
                <i class="icon-download-alt"></i>
                Scarica documenti del volontario in ZIP
            </a>
        <?php } else { ?>
            <span class="text-info">
                <i class="icon-warning-sign"></i>
                Il volontario non ha caricato documenti.
            </span>
        <?php } ?>
        <hr />
    <!--Visualizzazione e modifica appartenenze utente -->
    <div class="span6">
        <div class="row-fluid">
            <h4>
                <i class="icon-time muted"></i>
                Appartenenze
            </h4>
            
        </div>
        
        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Ruolo</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Azioni</th>
                </thead>
                
                <?php foreach ( $v->storico() as $app ) { ?>
                    <tr<?php if ($app->attuale()) { ?> class="success"<?php } ?>>
                        <td>
                            <?php if ($app->attuale()) { ?>
                                Attuale
                            <?php } else { ?>
                                Passato
                            <?php } ?>
                        </td>
                        
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
                            <?php if ($app->attuale()) { 
                              $sessione->a= $app;?>
                                <a href="?p=us.appartenenza.modifica" title="Modifica appartenenza" class="btn btn-small btn-info">
                                    <i class="icon-edit"></i>
                                </a>
                            <?php } 
                              if($me->admin()){ ?>
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
            <form action='?p=presidente.titolo.nuovo&id=<?php echo $v->id; ?>' method="POST">
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
            
        </div>    
  
     <?php $ttt = $a; ?>
                <table class="table table-striped">
                    <?php foreach ( $ttt as $titolo ) { ?>
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
                                <div class="btn-group">
                                    <a href="?p=presidente.titolo.modifica&t=<?php echo $titolo->id; ?>&v=<?php echo $v->id; ?>" title="Modifica il titolo" class="btn btn-small btn-info">
                                        <i class="icon-edit"></i>
                                    </a>
                                    <a onclick="return confirm('Cancellare il titolo utente?');" href="?p=utente.titolo.cancella&id=<?php echo $titolo->id; ?>&pre" title="Cancella il titolo" class="btn btn-small btn-danger">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </td>
                    </tr>
                    <?php } ?>
                </table>
    </div>
</div>
