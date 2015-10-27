<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);

controllaParametri(['id'], 'admin.corsi.crea&err');

// try catch da usare per evitare stampa dell'errore e poter fare redirect 
$id = intval($_GET['id']);
$wizard = intval($_GET['wizard']);
try {
    $c = Corso::id($id);
    if (empty($c)) {
        throw new Exception('Manomissione');
    }
    $tipocorso = TipoCorso::id($c->tipo);

} catch(Exception $e) {
    redirect('admin.corsi.crea&err='.CORSO_ERRORE_CORSO_NON_TROVATO);
}

if (!$c->modificabile()) {
    redirect('formazione.corsi.riepilogo&id='.$id);
}

// calcola il numero massimo di discenti per il corso
$maxDiscenti = $c->numeroDocentiNecessari() * $tipocorso->proporzioneIstruttori;

// recupera gli id di discenti già presenti per il corso
// per popolare automaticamente la lista in caso di pagina di modifica
$partecipazioni = PartecipazioneCorso::filtra([
    ['corso', $c->id],
    ['ruolo', CORSO_RUOLO_DISCENTE]
]);
$discenti = [];
foreach ($partecipazioni as $p) {
    $discenti[] = $p->volontario();
}
unset($partecipazioni);

caricaSelettoreDiscente([
    'max_selected_options' => $maxDiscenti,
    'no_results_text' => 'Ricerca discenti in corso...',
]);

$d = new DateTime('@' . $c->inizio);


$ruolo = $tipocorso->ruoloDiscenti;
$qualifica = $tipocorso->qualfica;
        
?>

<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Corso di formazione</h2>
        <form action="?p=formazione.corsi.discenti.ok" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <input value="<?php echo empty($wizard) ? 0 : 1 ?>" name="wizard" type="hidden">
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4><i class="icon-question-sign"></i> Discenti per <?php echo $certificato->nome ?> del <?php echo $d->format('d/m/Y'); ?></h4>
                </div>
                <hr>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user"></i> Discenti</label>
                    </div>
                    <div class="span8">
                        <select name="discenti[]" 
                                data-ruolo="<?php echo $ruolo;?>"
                                data-qualifica="<?php echo $qualifica;?>"
                                data-insert-page="formazione.corsi.discente_popolazione.nuovo" data-placeholder="Scegli un discente..." multiple class="chosen-select discenti">
                            <?php 
                                foreach ($discenti as $i ) {
                                ?>
                                <option value="<?php echo $i->id ?>" selected><?php echo $i->nomeCompleto() ?></option>
                                <?php
                                }
                            ?>
                        </select>
                        <span>Inserisci il testo necessario per ricercare il volontario (nome, cognome, email o codice fiscale),<br/>
                            premi INVIO per aggiornare la lista e scegli un volontario dalla lista che appare.</span><br/>
                        <span>Aggiungi fino a <strong><?php echo $maxDiscenti ?> discenti</strong></span>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4 offset4">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-ok"></i>
                            Procedi
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="span4">
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="nuovo-utente">Nuovo discente (popolazione)</button>
    </div>
</div>

<!-- Modal -->
<div id="nuovo-utente" class="modal fade" role="dialog" style="display: none">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2><i class="icon-plus-square icon-calendar muted"></i> Anagrafica popolazione</h2>
            </div>
            <div class="modal-body">

                <form id='nuova-persona' action="?p=formazione.corsi.discente_popolazione.nuovo.ok" method="POST" >
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
                            <p>Nel caso in cui a sinistra non si riesca a trovare il discente ricercato, è possibile aggiungere una persona (<strong>NON VOLONTARIO</strong>) all'anagrafica di Gaia inserendone i dati nel modulo qui sotto</p>
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
                    <br/>
                    <div class="row-fluid">
                        <div class="span4 centrato">
                            <label class="control-label">Docente</label>
                        </div>
                        <div class="span8">
                            <input type="checkbox" id="inputDocente" name="inputDocente" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <i class="icon-ok"></i>
                    Procedi
                </button>
            </div>
        </div>

    </div>
</div>
