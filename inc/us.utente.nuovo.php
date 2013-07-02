<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>
<form action="?" method="GET">
    <input type="hidden" name="p" value="us.utente.nuovo.ok">
<div class="modal fade automodal">
    
    <div class="modal-header">
        <h3><i class="icon-plus"></i> Inserisci un nuovo volontario</h3>
    </div>
    
    <div class="modal-body">
        <div class="row-fluid">
            <?php if ( isset($_GET['e']) ) { ?>
        <div class="alert alert-danger">
            <i class="icon-ban-circle"></i> <strong>Codice Fiscale errato</strong>.
            Il formato del codice fiscale inserito non risulta valido.
        </div>
        <?php }elseif ( isset($_GET['gia']) ) { ?>
        <div class="alert alert-danger">
            <i class="icon-ban-circle"></i> <strong>Volontario già presente</strong>.
            Il volontario che stai provando ad aggiungere è già presente.
        </div>
        <?php }elseif ( isset($_GET['mail']) ) { ?>
        <div class="alert alert-danger">
            <i class="icon-ban-circle"></i> <strong>Mail già presente</strong>.
            La mail che stai provando ad aggiungere è già presente nel sistema.
        </div>
        <?php }?>
            <div class="span4 centrato">
                <label class="control-label" for="inputNome">Nome</label>
            </div>
            <div class="span8">
                <input type="text" name="inputNome" id="inputNome" />
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span4 centrato">
                <label class="control-label" for="inputCognome">Cognome</label>
            </div> 
            <div class="span8">
                <input type="text" name="inputCognome" id="inputCognome"  />
            </div>
        </div>
              
        <div class="row-fluid">
            <div class="span4 centrato">
              <label class="control-label" for="inputCodiceFiscale">Codice Fiscale</label>
            </div>
            <div class="span8">
                <input type="text" name="inputCodiceFiscale" id="inputCodiceFiscale"  />
            </div>
        </div>
              
        <div class="row-fluid">            
            <div class="span4 centrato">
                <label class="control-label" for="inputDataNascita">Data di Nascita</label>
        </div>
            <div class="span8">
                <input type="text" name="inputDataNascita" id="inputDataNascita" />
            </div>
        </div>

        <div class="row-fluid">            
            <div class="span4 centrato">
            <label class="control-label" for="inputProvinciaNascita">Provincia di Nascita</label>
        </div>
        <div class="span8">
            <input type="text" name="inputProvinciaNascita" id="inputProvinciaNascita" />
        </div>
            </div>

        <div class="row-fluid">            
            <div class="span4 centrato">
                <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
            </div>
            <div class="span8">
                <input type="text" name="inputComuneNascita" id="inputComuneNascita" />
            </div>
      </div>
        
    <div class="row-fluid">            
        <div class="span4 centrato">
            <label class="control-label" for="inputIndirizzo">Indirizzo</label>
    </div>
       <div class="span8">
         <input type="text" id="inputIndirizzo" name="inputIndirizzo" required />
       </div>
    </div>
        
     <div class="row-fluid">            
        <div class="span4 centrato">
        <label class="control-label" for="inputCivico">Civico</label>
        </div>
       <div class="span8">
         <input type="text" id="inputCivico" name="inputCivico" required />
       </div>
    </div>
        
     <div class="row-fluid">            
        <div class="span4 centrato">
            <label class="control-label" for="inputComuneResidenza">Comune di residenza</label>
        </div>
        <div class="span8">
            <input  type="text" id="inputComuneResidenza" name="inputComuneResidenza" required />
       </div>
    </div>
        
     <div class="row-fluid">            
         <div class="span4 centrato">
            <label class="control-label" for="inputCAPResidenza">CAP di residenza</label>
        </div>
        <div class="span8">
         <input type="text" id="inputCAPResidenza" name="inputCAPResidenza" required pattern="[0-9]{5}" />
       </div>

     <div class="row-fluid">            
         <div class="span4 centrato">
            <label class="control-label" for="inputProvinciaResidenza">Provincia di residenza</label>
        </div>
        <div class="span8">
         <input type="text" id="inputProvinciaResidenza" name="inputProvinciaResidenza" required pattern="[A-Za-z]{2}" />
        </div>
</div>
         
    <div class="row-fluid">            
        <div class="span4 centrato">
            <label class="control-label" for="inputEmail">Email</label>
        </div>
        <div class="span8">
            <input type="email" id="inputEmail" name="inputEmail" required  />
        </div>
</div>
         
         <div class="row-fluid">
     <div class="span4 input-prepend centrato">
       <label class="control-label" for="inputCellulare">Cellulare</label>
     </div>
       <div class="span8">
           <span class="add-on">+39</span>
         <input   type="text" id="inputCellulare" name="inputCellulare" required pattern="[0-9]{9,11}" />
        </div>
</div>
        
         <div class="row-fluid">
    <div class="span4 input-prepend centrato">
       <label class="control-label" for="inputCellulareServizio">Cellulare Servizio</label>
    </div>
       <div class="span8">
           <span class="add-on">+39</span>
         <input   type="text" id="inputCellulareServizio" name="inputCellulareServizio" pattern="[0-9]{9,11}" />
        </div>
         </div>

    <div class="row-fluid">            
        <div class="span4 centrato">
        <label class="control-label" for="inputgruppoSanguigno">Gruppo Sanguigno</label>
    </div>
    <div class="span8">
        <select id="inputgruppoSanguigno" name="inputgruppoSanguigno"  required class="disabled">
        <?php
            foreach ( $conf['sangue_gruppo'] as $numero => $gruppo ) { ?>
            <option value="<?php echo $numero; ?>"><?php echo $gruppo; ?></option>
            <?php } ?>
        </select>   
    </div>
        
        <div class="row-fluid">
        <div class="span4 centrato">
            <label class="control-label" for="inputComitato">Comitato</label>
        </div>
            <div class="span8">
                <select required name="inputComitato" id="inputComitato" class="span11">
                    <option value="" selected="selected">[ Seleziona un Comitato ]</option>
                    <?php foreach ( $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]) as $c ) { ?>
                        <option value="<?php echo $c->id; ?>"><?php echo $c->nomeCompleto(); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        
            <div class="row-fluid">            
            <div class="span4 centrato">
                <label class="control-label" for="inputDataIngresso">Data ingresso CRI</label>
        </div>
            <div class="span8">
                <input type="text" name="inputDataIngresso" id="inputDataIngresso" />
            </div>
        </div>          
        
              <hr />
        </div>
    </div>
        <div class="modal-footer">
          <a href="?p=us.dash" class="btn">Annulla</a>
          <button type="submit" class="btn btn-success">
              <i class="icon-plus"></i> Aggiungi volontario
          </button>
        </div>
</div>
</form>
