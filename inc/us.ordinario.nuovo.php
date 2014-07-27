<?php  

/*
* ©2013 Croce Rossa Italiana
*/

paginaApp([APP_SOCI , APP_PRESIDENTE]);
caricaSelettoreComitato();
$t = Tesseramento::by('anno', date('Y'));
?>
<form action="?p=us.ordinario.nuovo.ok" method="POST">
    <div class="modal fade automodal">

        <div class="modal-header">
            <h3><i class="icon-plus"></i> Inserisci un nuovo Socio Ordinario</h3>
        </div>

        <div class="modal-body">
            <div class="row-fluid">
                <?php if ( isset($_GET['e']) ) { ?>
                <div class="alert alert-danger">
                    <i class="icon-ban-circle"></i> <strong>Codice Fiscale errato</strong>.
                    Il formato del codice fiscale inserito non risulta valido.
                </div>
                <?php }elseif ( isset($_GET['c']) ) { ?>
                <div class="alert alert-danger">
                    <i class="icon-ban-circle"></i> <strong>Scegli un comitato valido</strong>.
                    Seleziona un comitato di appartenenza che rientra nel tuo ruolo di presidente/ufficio soci.
                </div>
                <?php }elseif ( isset($_GET['q']) ) { ?>
                <div class="alert alert-danger">
                    <i class="icon-ban-circle"></i> <strong>La registrazione deve avvenire nell'anno in corso</strong>.
                    Non puoi registrare soci in anni passati o nel futuro.
                </div>
                <?php }elseif ( isset($_GET['i']) ) { ?>
                <div class="alert alert-danger">
                    <i class="icon-ban-circle"></i> <strong>Importo inserito errato</strong>.
                    Devi inserire un importo uguale o superiore a quello previsto dal regolamento.
                </div>
                <?php }elseif ( isset($_GET['gia']) ) { ?>
                <div class="alert alert-danger">
                    <i class="icon-ban-circle"></i> <strong>Socio Ordinario già presente</strong>.
                    Il Socio Ordinario che stai provando ad aggiungere è già presente.
                </div>
                <?php }elseif ( isset($_GET['mail']) ) { ?>
                <div class="alert alert-danger">
                    <i class="icon-ban-circle"></i> <strong>Mail già presente</strong>.
                    La mail che stai provando ad aggiungere è già presente nel sistema.
                </div>
                <?php }?>
                <div class="alert alert-info">
                    <i class="icon-pencil"></i> <strong>Alcuni campi sono obbligatori</strong>.
                    <p>I campi contrassegnati dall'asterisco (*) sono obbligatori. Potrai compilare
                    gli altri campi anche in un secondo momento dalla scheda anagrafica del Socio Ordinario.</p>
                    <p>Se non inserisci l'indirizzo email del Socio Ordinario <strong>non</strong> sarà attivato
                    il suo account su Gaia.</p>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputNome">Nome * </label>
                </div>
                <div class="span8">
                    <input type="text" name="inputNome" id="inputNome" required/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputCognome">Cognome * </label>
                </div> 
                <div class="span8">
                    <input type="text" name="inputCognome" id="inputCognome"  required/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputSesso">Sesso * </label>
                </div>
                <div class="span8">
                    <select class="input-small" id="inputSesso" name="inputSesso" required>
                        <?php
                        foreach ( $conf['sesso'] as $numero => $tipo ) { ?>
                        <option value="<?php echo $numero; ?>"><?php echo $tipo; ?></option>
                        <?php } ?>
                    </select>  
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputCodiceFiscale">Codice Fiscale * </label>
                </div>
                <div class="span8">
                    <input type="text" name="inputCodiceFiscale" id="inputCodiceFiscale" required pattern="[A-Za-z]{6}[0-9]{2}[A-Za-z][0-9]{2}[A-Za-z][0-9]{3}[A-Za-z]" />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputDataNascita">Data di nascita * </label>
                </div>
                <div class="span8">
                    <input type="text" name="inputDataNascita" id="inputDataNascita" required />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputComuneNascita">Comune di nascita * </label>
                </div>
                <div class="span8">
                    <input type="text" name="inputComuneNascita" id="inputComuneNascita" required />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputProvinciaNascita">Provincia di nascita * </label>
                </div>
                <div class="span8">
                    <input type="text" name="inputProvinciaNascita" id="inputProvinciaNascita" required />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputComuneResidenza">Comune di residenza</label>
                </div>
                <div class="span8">
                    <input  type="text" id="inputComuneResidenza" name="inputComuneResidenza" />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputProvinciaResidenza">Provincia di residenza</label>
                </div>
                <div class="span8">
                    <input type="text" id="inputProvinciaResidenza" name="inputProvinciaResidenza" pattern="[A-Za-z]{2}" />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputCAPResidenza">CAP di residenza</label>
                </div>
                <div class="span8">
                    <input type="text" id="inputCAPResidenza" name="inputCAPResidenza" pattern="[0-9]{5}" />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputIndirizzo">Indirizzo di residenza</label>
                </div>
                <div class="span8">
                    <input type="text" id="inputIndirizzo" name="inputIndirizzo" />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputCivico">Numero civico</label>
                </div>
                <div class="span8">
                    <input type="text" id="inputCivico" name="inputCivico" />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputEmail">Email</label>
                </div>
                <div class="span8 input-prepend">
                    <span class="add-on"><i class="icon-envelope"></i></span>
                    <input type="email" id="inputEmail" name="inputEmail"  />
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputCellulare">Cellulare</label>
                </div>
                <div class="span8 input-prepend">
                    <span class="add-on">+39</span>
                    <input   type="text" id="inputCellulare" name="inputCellulare" pattern="[0-9]{9,11}" />
                </div>
            </div>       
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputComitato">Comitato * </label>
                </div>
                <div class="span8">
                    <a class="btn btn-inverse" data-selettore-comitato="true" data-input="inputComitato">
                        Seleziona un Comitato... <i class="icon-pencil"></i>
                    </a>

                </div>
            </div>
            <br/>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputQuota" >Importo quota * </label>
                </div>
                <div class="span8 input-prepend">
                    <span class="add-on">€</span>
                    <input type="number" name="inputQuota" 
                    id="inputQuota" step="0.01" min="<?php echo $t->ordinario ?>" 
                    value="<?php echo $t->ordinario ?>" required />
                </div>
            </div>
            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputDataQuota" >Data versamento quota * </label>
                </div>
                <div class="span8">
                    <input type="text" name="inputDataQuota" id="inputDataQuota" required />
                </div>
            </div>          
            <hr />
        </div>
        <div class="modal-footer">
            <a href="?p=us.dash" class="btn">Annulla</a>
            <button type="submit" class="btn btn-success">
                <i class="icon-plus"></i> Aggiungi Socio Ordinario
            </button>
        </div>
    </div>
</form>
