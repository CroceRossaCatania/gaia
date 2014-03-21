<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
?>

<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Estensione Approvata</strong>.
            Estensione approvata con successo.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['no']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Estensione negata</strong>.
            Estensione negata.
        </div>
        <?php } ?>
<?php if ( isset($_GET['prot']) ) { ?>
        <div class="alert alert-info">
            <i class="icon-save"></i> <strong>Richiesta Protocollata</strong>.
            Richiesta di estensione protocollata con successo.
        </div>
<?php } ?>
<?php if ( isset($_GET['err']) ) { ?>
        <div class="alert alert-danger">
            <i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.
           Qualcosa nella procedura di approvazione non ha funzionato, per favore, riprova.
        </div>
<?php } ?>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-cogs muted"></i>
            Estensioni in attesa
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari..." type="text">
        </div>
    </div>    
</div>
    
<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data richiesta</th>
        <th>Comitato destinazione</th>
        <th>Azione</th>
    </thead>
<?php
$comitati= $me->comitatiDiCompetenza();
foreach($comitati as $comitato){
    $e = Estensione::filtra([['stato',EST_INCORSO],['cProvenienza', $comitato]]);
    foreach ($e as $_e){
        $v = $_e->volontario();
        $modificabile = $v->modificabileDa($me);
 ?>
    <tr>
        <td><?php echo $v->nome; ?></td>
        <td><?php echo $v->cognome; ?></td>
        <td><?php echo $v->codiceFiscale; ?></td>
        <td><?php echo date('d/m/Y', $_e->appartenenza()->timestamp); ?></td> 
        <td><?php echo $_e->comitato()->nomeCompleto(); ?></td>
        <?php if($_e->protNumero){ ?>
        <td>
            <?php if ($modificabile) { ?>
            <div class="btn-group">
                <a class="btn btn-success" href="?p=presidente.estensione.ok&id=<?php echo $_e->id; ?>&si">
                    <i class="icon-ok"></i> Conferma
                </a>
                <a class="btn btn-danger" onClick="return confirm('Vuoi veramente negare estensione a questo utente ?');" href="?p=presidente.estensioneNegata&id=<?php echo $_e->id; ?>">
                    <i class="icon-ban-circle"></i> Nega
                </a>
            </div>
            <?php } ?>
        <?php }else{ ?>
        <td>   
            <div class="btn-group">
                <a class="btn btn-info" href="?p=utente.estensioneRichiesta.stampa&id=<?php echo $_e->id; ?>">
                    <i class="icon-print"></i> Stampa richiesta
                </a>
                <?php if($modificabile) { ?>
                <a class="btn btn-success" href="?p=presidente.estensioneRichiesta&id=<?php echo $_e->id; ?>">
                    <i class="icon-ok"></i> Protocolla richiesta
                </a>
                <?php } ?>
            </div>
        <?php } ?>    
        </td>
       
    </tr>
    <?php }
    } ?>
</table>
