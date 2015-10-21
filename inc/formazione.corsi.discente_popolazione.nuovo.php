<?php
/*
 * ©2013 Croce Rossa Italiana
 */
paginaPresidenziale();

paginaApp([APP_SOCI, APP_PRESIDENTE]);
caricaSelettoreComitato();
?>
<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Anagrafica popolazione</h2>

        <form action="?p=formazione.corsi.discente_popolazione.nuovo.ok" method="POST">
            <div class="row-fluid">
                <?php if (isset($_GET['e'])) { ?>
                    <div class="alert alert-danger">
                        <i class="icon-ban-circle"></i> <strong>Codice Fiscale errato</strong>.
                        Il formato del codice fiscale inserito non risulta valido.
                    </div>
                <?php } elseif (isset($_GET['c'])) { ?>
                    <div class="alert alert-danger">
                        <i class="icon-ban-circle"></i> <strong>Scegli un comitato valido</strong>.
                        Seleziona un comitato di appartenenza che rientra nel tuo ruolo di presidente/ufficio soci.
                    </div>
                <?php } elseif (isset($_GET['gia'])) { ?>
                    <div class="alert alert-danger">
                        <i class="icon-ban-circle"></i> <strong>Volontario già presente</strong>.
                        Il volontario che stai provando ad aggiungere è già presente nel database di GAIA.<br />
                        Questo può significare due cose: <br />
                        <ul>
                            <li>il volontario sì è iscritto in autonomia ma non ha selezionato alcun comitato di destinazione;</li>
                            <li>il volontario è attualmente in forza presso altro comitiato.</li>
                        </ul>
                        Contatta il supporto fornendo il <strong>codice fiscale</strong> per ulteriori informazioni.
                    </div>
                <?php } elseif (isset($_GET['mail'])) { ?>
                    <div class="alert alert-danger">
                        <i class="icon-ban-circle"></i> <strong>Mail già presente</strong>.
                        La mail che stai provando ad aggiungere è già presente nel sistema.
                    </div>
                <?php } ?>
                <div class="alert alert-info">
                    <i class="icon-pencil"></i> <strong>Alcuni campi sono obbligatori</strong>.
                    <p>I campi contrassegnati dall'asterisco (*) sono obbligatori. <!-- Potrai compilare
                        gli altri campi anche in un secondo momento dalla scheda anagrafica.</p>
                    <p>Se non inserisci l'indirizzo email del Volontario <strong>non</strong> sarà attivato
                        il suo account su Gaia. --></p>
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
                        <?php foreach ($conf['sesso'] as $numero => $tipo) { ?>
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
<!--            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputCellulareServizio">Cellulare Servizio</label>
                </div>
                <div class="span8 input-prepend">
                    <span class="add-on">+39</span>
                    <input   type="text" id="inputCellulareServizio" name="inputCellulareServizio" pattern="[0-9]{9,11}" />
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
            </div> -->
            <br/>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label">Docente</label>
                </div>
                <div class="span8">
                    <input type="checkbox" id="inputDocente" name="inputDocente" >
                </div>
            </div>
<!--            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label">Corpo Militare volontario</label>
                </div>
                <div class="span8">
                    <input type="checkbox" id="inputCM" name="inputCM" >
                </div>
            </div>        -->
            <div class="row-fluid">
               <div class="span4 offset4">
                   <button type="submit" class="btn btn-success">
                       <i class="icon-ok"></i>
                       Procedi
                   </button>
               </div>
           </div>
        </form>
    </div>
</div>
