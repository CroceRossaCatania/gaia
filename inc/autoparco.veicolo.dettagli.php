<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

$veicolo = $_GET['id'];

if ( $veicolo ){

    $veicolo = Veicolo::id($veicolo);

    /* Mica posso vedere o modificare i veicoli di altri */
    proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

    if ( $veicolo->stato == VEI_FUORIUSO ) {
        $x=1;
    }
}

?>
<script type="text/javascript"><?php require './js/autoparco.veicolo.nuovo.js'; ?></script>
<div class="row-fluid">
    <?php if (isset($_GET['err'])) { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
            <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
        </div> 
    <?php } 
    if ( !($veicolo) ){?>
        <h2><i class="icon-truck muted"></i> Aggiungi nuovo Veicolo</h2>
        <div class="alert alert-block alert-info ">
            <div class="row-fluid">
                <span class="span12">
                    <p>Con questo modulo si possono aggiungere <b>nuovi veicoli</b>, curati di inserire le informazioni con <b>attenzione</b></p>
                </span>
            </div>
        </div>  
    <?php } else { ?>
        <h2><i class="icon-truck muted"></i> Dettagli Veicolo</h2>   
        <br/>  
    <?php } ?>
</div>
<form class="form-horizontal" action="?p=autoparco.veicolo.nuovo.ok&id=<?= $veicolo; ?>" method="POST">
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label class="control-label" for="inputLibretto">N° Libretto</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->libretto; ?>" name="inputLibretto" id="inputLibretto" placeholder="201X-XXXXXXXXX" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputTarga">Targa <b>(A)</b></label>
                <div class="controls">
                    <input class="input-medium" type="text" value="<?= $veicolo->targa; ?>" name="inputTarga" id="targa" placeholder="CRIXXXX" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPrimaImmatricolazione">Prima immatricolazione <b>(B)</b></label>
                <div class="controls">
                    <input class="input-small" type="text" <?php if ( $veicolo ) { ?> value="<?= date('d/m/Y', $veicolo->primaImmatricolazione); ?>" <?php } ?> name="inputPrimaImmatricolazione" id="inputPrimaImmatricolazione" required<?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <h3>Proprietario del veicolo (C.2)</h3>
            <div class="control-group">
                <label class="control-label" for="inputCognome">Cognome o Ragione Sociale <b>(C2.1)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->cognome; ?>" name="inputCognome" id="inputCognome" placeholder="Croce Rossa Italiana" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputNome">Nome o iniziale <b>(C2.2)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->nome; ?>" name="inputNome" id="inputNome" placeholder="Comitato Centrale" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputIndirizzo">Indirizzo <b>(C2.3)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->indirizzo; ?>" name="inputIndirizzo" id="inputIndirizzo" placeholder="12 Via Toscana - 00187 Roma" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <br/><br/>
            <h3>Pneumatici</h3>
            <div class="control-group">
                <label class="control-label" for="inputAnt">Anteriori</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->anteriori; ?>" name="inputAnt" id="inputAnt" placeholder="215/70 R12C" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPost">Posteriori</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->posteriori; ?>" name="inputPost" id="inputPost" placeholder="215/70 R12C" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <br/>
            <h3>Pneumatici alternativi</h3>
            <div class="control-group">
                <label class="control-label" for="inputAltAnt">Anteriori</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->altAnt; ?>" name="inputAltAnt" id="inputAltAnt" placeholder="215/70 R12C" <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputAltPost">Posteriori</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->altPost; ?>" name="inputAltPost" id="inputAltPost" placeholder="215/70 R12C" <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <br/>
            <div class="control-group">
                <label class="control-label" for="inputCambio">Cambio</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->cambio; ?>" name="inputCambio" id="inputCambio" placeholder="Meccanico" <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputLunghezza">Lunghezza[m]</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->lunghezza; ?>" name="inputLunghezza" id="inputLunghezza" placeholder="2,15" <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputLarghezza">Larghezza [m]</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->larghezza; ?>" name="inputLarghezza" id="inputLarghezza" placeholder="3,56" <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputSbalzo">Sbalzo [m]</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->sbalzo; ?>" name="inputSbalzo" id="inputSbalzo" placeholder="1,60" <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <br/><br/>
            <div class="control-group">
                <label class="control-label" for="inputTara">Tara [kg]</label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->tara; ?>" name="inputTara" id="inputTara" placeholder="200" <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
        </div>
        <div class="span6">
            <h3>Veicolo (D)</h3>
            <div class="control-group">
                <label class="control-label" for="inputMarca">Marca <b>(D.1)</b></label>
                <div class="controls">
                    <input class="input-medium" type="text" value="<?= $veicolo->marca; ?>" name="inputMarca" id="inputMarca" placeholder="Fiat" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputTipo">Tipo <b>(D.2)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->tipo; ?>" name="inputTipo" id="inputTipo" placeholder="Ducato" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <br/>
            <div class="control-group">
                <label class="control-label" for="inputTelaio">Numero Identificazione veicolo <b>(E)</b></label>
                <div class="controls">
                    <input class="input-medium" type="text" value="<?= $veicolo->telaio; ?>" name="inputTelaio" id="inputTelaio" placeholder="ZXXXXXXXXXXXXXXX" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <h3>Massa (F)</h3>
            <div class="control-group">
                <label class="control-label" for="inputMaxMassa">Massa massima a carico <b>(F.2)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->massa; ?>" name="inputMaxMassa" id="inputMaxMassa" placeholder="3300" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputImmatricolazione">Data immatricolazione attuale <b>(I)</b></label>
                <div class="controls">
                    <input class="input-small" type="text" <?php if ( $veicolo ) { ?> value="<?= date('d/m/Y', $veicolo->immatricolazione); ?>" <?php } ?> name="inputImmatricolazione" id="inputImmatricolazione" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <h3>Categoria del veicolo (J)</h3>
            <div class="control-group">
                <label class="control-label" for="inputCategoria">Categoria del veicolo <b>(J)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->categoria; ?>" name="inputCategoria" id="inputCategoria" placeholder="Ambulanza" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputUso">Destinazione ed uso <b>(J.1)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->uso; ?>" name="inputUso" id="inputUso" placeholder="Amb. Soccorso (AMB-A)" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCarozzeria">Carrozzeria <b>(J.2)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->carrozzeria; ?>" name="inputCarozzeria" id="inputCarozzeria" placeholder="Chiuso" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <br/>
            <div class="control-group">
                <label class="control-label" for="inputOmologazione">N° Omologazione <b>(K)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->omologazione; ?>" name="inputOmologazione" id="inputOmologazione" placeholder="OEXXXXXXXXXX" <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <br/>
            <div class="control-group">
                <label class="control-label" for="inputAssi">N° Assi <b>(L)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->assi; ?>" name="inputAssi" id="inputAssi" placeholder="2" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <h3>Massa massima a rimorchio tecnicamente ammissibile (O)</h3>
            <div class="control-group">
                <label class="control-label" for="inputRimorchioFrenato">Rimorchio frenato [Kg]<b> (O.1)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->rimorchioFrenato; ?>" name="inputRimorchioFrenato" id="inputRimorchioFrenato" placeholder="2500" <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <h3>Motore (P)</h3>
            <div class="control-group">
                <label class="control-label" for="inputCilindrata">Cilindrata <b>(P.1)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->cilindrata; ?>" name="inputCilindrata" id="inputCilindrata" placeholder="2500" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPotenza">Potenza Massima [Kw]<b>(P.2)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->potenza; ?>" name="inputPotenza" id="inputPotenza" placeholder="25" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputAlimentazione">Alimentazione <b>(P.3)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->alimentazione; ?>" name="inputAlimentazione" id="inputAlimentazione" placeholder="Gasolio" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <h3>Posti a sedere (S)</h3>
            <div class="control-group">
                <label class="control-label" for="inputPosti">N° Posti a sedere conducente compreso <b>(S.1)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->posti; ?>" name="inputPosti" id="inputPosti" placeholder="3" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
            <h3>Livello Sonoro (U)</h3>
            <div class="control-group">
                <label class="control-label" for="inputRegime">Regime del motore <b>(U.2)</b></label>
                <div class="controls">
                    <input class="input-large" type="text" value="<?= $veicolo->regime; ?>" name="inputRegime" id="inputRegime" placeholder="3500" required <?php if ($x) { ?> readonly <?php } ?>>
                </div>
            </div>
        </div>
        <div class="span12">
            <hr/>
            <h3>Intervallo revisione</h3>
            <?php if ($x) { ?> 
                <div class="control-group">
                    <label class="control-label" for="inputintervalloRevisione">Intervallo</label>
                    <div class="controls">
                        <input class="input-large" type="text" value="<?= $conf['rev_intervallo'][$veicolo->intervalloRevisione]; ?>" name="inputintervalloRevisione" id="inputintervalloRevisione" readonly >
                    </div>
                </div>
            <?php }else{ ?>
                <div class="control-group">
                    <label class="control-label" for="inputintervalloRevisione">Intervallo</label>
                    <div class="controls">
                       <select class="input-large" id="inputintervalloRevisione" name="inputintervalloRevisione"  required>
                            <?php
                            foreach ( $conf['rev_intervallo'] as $numero => $gruppo ) { ?>
                                <option value="<?php echo $numero; ?>"><?php echo $gruppo; ?></option>
                            <?php } ?>
                        </select> 
                    </div>
                </div>
            <?php } ?>
            <hr/>
            <h3>Stato veicolo</h3>
            <div class="control-group">
                <label class="control-label" for="inputStato">Stato</label>
                <div class="controls">
                    <?php if($x) { ?>
                       <input class="input-large" type="text" value="<?= $conf['vei_stato'][$veicolo->stato]; ?>" name="inputStato" id="inputStato" readonly>
                       <b> dichiarato da: </b><input class="input-large" type="text" value="<?= $veicolo->pFuoriuso()->nomeCompleto(); ?>" readonly>
                       <b> il </b><input class="input-large" type="text" value="<?= date('d/m/Y H:i', $veicolo->tFuoriuso); ?>" readonly>
                    <?php }else{ ?>
                        <select class="input-large" id="inputStato" name="inputStato" required>
                            <?php
                            foreach ( $conf['vei_stato'] as $numero => $gruppo ) { ?>
                                <option value="<?php echo $numero; ?>"<?php if ( $numero==$veicolo->stato ) { ?>selected<?php } ?>><?php echo $gruppo; ?></option>
                            <?php } ?>
                        </select>  
                    <?php } ?> 
                </div>
            </div>
            <hr/>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-large btn-success">
              <i class="icon-ok"></i>
              Salva cambiamenti
          </button>
        </div>
    </div>
</form>