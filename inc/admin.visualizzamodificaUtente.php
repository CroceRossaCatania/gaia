<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

?>
<?php 

$f = $_GET['id']; 
$t= Persona::filtra([
  ['id', $f]
]);
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
        
<form class="form-horizontal" action="?p=admin.modificaUtente.ok&t=<?php echo $f; ?>" method="POST">
    <h2><i class="icon-edit muted"></i> Anagrafica</h3>
        <div class="control-group">
              <label class="control-label" for="inputNome">Nome</label>
              <div class="controls">
                <input type="text" name="inputNome" id="inputNome"  value="<?php echo $t[0]->nome; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputCognome">Cognome</label>
              <div class="controls">
                <input type="text" name="inputCognome" id="inputCognome"  value="<?php echo $t[0]->cognome; ?>">
                
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputCodiceFiscale">Codice Fiscale</label>
              <div class="controls">
                <input type="text" name="inputCodiceFiscale" id="inputCodiceFiscale"  value="<?php echo $t[0]->codiceFiscale; ?>">
                
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputDataNascita">Data di Nascita</label>
              <div class="controls">
                <input type="text" class="input-small" name="inputDataNascita" id="inputDataNascita" value="<?php echo date('d-m-Y', $t[0]->dataNascita); ?>">
              </div>
            </div>
    <div class="control-group">
              <label class="control-label" for="inputProvinciaNascita">Provincia di Nascita</label>
              <div class="controls">
                <input class="input-mini" type="text" name="inputProvinciaNascita" id="inputProvinciaNascita"  value="<?php echo $t[0]->provinciaNascita; ?>">
             </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
              <div class="controls">
                <input type="text" name="inputComuneNascita" id="inputComuneNascita" value="<?php echo $t[0]->comuneNascita; ?>">
              </div>
            </div>

            <div class="control-group">
               <label class="control-label" for="inputIndirizzo">Indirizzo</label>
               <div class="controls">
                 <input value="<?php echo $t[0]->indirizzo; ?>" type="text" id="inputIndirizzo" name="inputIndirizzo" required />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputCivico">Civico</label>
               <div class="controls">
                 <input value="<?php echo $t[0]->civico; ?>" type="text" id="inputCivico" name="inputCivico" class="input-small" required />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputComuneResidenza">Comune di residenza</label>
               <div class="controls">
                 <input value="<?php echo $t[0]->comuneResidenza; ?>" type="text" id="inputComuneResidenza" name="inputComuneResidenza" required />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputCAPResidenza">CAP di residenza</label>
               <div class="controls">
                 <input value="<?php echo $t[0]->CAPResidenza; ?>" class="input-small" type="text" id="inputCAPResidenza" name="inputCAPResidenza" required pattern="[0-9]{5}" />
               </div>
             </div>
             <div class="control-group">
               <label class="control-label" for="inputProvinciaResidenza">Provincia di residenza</label>
               <div class="controls">
                 <input value="<?php echo $t[0]->provinciaResidenza; ?>" class="input-mini" type="text" id="inputProvinciaResidenza" name="inputProvinciaResidenza" required pattern="[A-Za-z]{2}" />
                </div>
             </div>
            <div class="control-group">
               <label class="control-label" for="inputEmail">Email</label>
               <div class="controls">
                 <input value="<?php echo $t[0]->email; ?>"  type="email" id="inputEmail" name="inputEmail" required  />
                </div>
             </div>
             <div class="control-group input-prepend">
               <label class="control-label" for="inputCellulare">Cellulare</label>
               <div class="controls">
                   <span class="add-on">+39</span>
                 <input value="<?php echo $t[0]->cellulare; ?>"  type="text" id="inputCellulare" name="inputCellulare" required pattern="[0-9]{9,11}" />
                </div>
             </div>
            <div class="control-group input-prepend">
               <label class="control-label" for="inputCellulareServizio">Cellulare Servizio</label>
               <div class="controls">
                   <span class="add-on">+39</span>
                 <input value="<?php echo $t[0]->cellulareServizio; ?>"  type="text" id="inputCellulareServizio" name="inputCellulareServizio" pattern="[0-9]{9,11}" />
                </div>
             </div>
            <div class="control-group">
            <label class="control-label" for="inputgruppoSanguigno">Gruppo Sanguigno</label>
            <div class="controls">
                <select class="input-small" id="inputgruppoSanguigno" name="inputgruppoSanguigno"  required>
                <?php
                    foreach ( $conf['sangue_gruppo'] as $numero => $gruppo ) { ?>
                    <option value="<?php echo $numero; ?>" <?php if ( $numero == $t[0]->grsanguigno ) { ?>selected<?php } ?>><?php echo $gruppo; ?></option>
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
    <!--Visualizzazione e modifica titoli utente-->
    <div class="span6">
   
  
     <?php $ttt = $a; ?>
                <h3><i class="icon-list muted"></i> Curriculum <span class="muted"><?php echo count($ttt); ?> inseriti</span></h3>
                <table class="table table-striped">
                    <?php foreach ( $ttt as $titolo ) { ?>
                    <tr <?php if (!$titolo->tConferma) { ?>class="warning"<?php } ?>>
                        <td><strong><?php echo $titolo->titolo()->nome; ?></strong></td>
                        <td><?php echo $conf['titoli'][$titolo->titolo()->tipo][0]; ?></td>
                        <?php if ($titolo->tConferma) { ?>
                            <td>
                                <abbr title="<?php echo date('d-m-Y H:i', $titolo->tConferma); ?>">
                                    <i class="icon-ok"></i> Confermato
                                </abbr>
                            </td>    
                        <?php } else { ?>
                            <td><i class="icon-time"></i> Pendente</td>
                        <?php } ?>
                        
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
                            
                            <td><a  href="?p=cancellaTitolo&id=<?php echo $titolo->id; ?>" title="Cancella il titolo" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i>
                            </a></td>
                    </tr>
                    <?php } ?>
                    
                </table>   
   
    </div>

</div>
