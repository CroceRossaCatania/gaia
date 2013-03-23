<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();
?>

<script type="text/javascript"><?php require './js/admin.listaUtenti.js'; ?></script>
<br/>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Trasferimento Approvato</strong>.
            Trasferimento approvato con successo.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['no']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Trasferimento negato</strong>.
            Trasferimento negato.
        </div>
        <?php } ?>
<?php if ( isset($_GET['prot']) ) { ?>
        <div class="alert alert-info">
            <i class="icon-save"></i> <strong>Richiesta Protocollata</strong>.
            Richiesta di trasferimento protocollata con successo.
        </div>
        <?php } ?>
    <div class="control-group" align="right">
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input data-t="<?php echo $t; ?>" required id="cercaUtente" placeholder="Cerca utente..." class="span4" type="text">
            </div>
        </div>
    </div> 
<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>#</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data di Nascita</th>
        <th>Luogo di Nascita</th>
        <th>Comitato</th>
        <th>Azione</th>
    </thead>
<?php
$comitati= $me->comitatiDiCompetenza();
foreach($comitati as $comitato){
    foreach($comitato->trasferimenti(TRASF_INCORSO) as $_t){
        $_v = $_t->volontario();
        $c=$_t->comitato();
 ?>
    <tr>
        <td><?php echo $_t->id; ?></td>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td><?php echo $c->nome; ?></td>
        <td>
         <?php if($_t->protNumero){ ?>   
        <a class="btn btn-success" href="?p=presidente.trasferimento.ok&id=<?php echo $_t->id; ?>&si">
                <i class="icon-ok"></i>
                    Conferma
        </a>
            <a class="btn btn-danger" onClick="return confirm('Vuoi veramente negare il trasferimento a questo utente ?');" href="?p=presidente.trasferimentoNegato&id=<?php echo $_t->id; ?>">
                <i class="icon-ban-circle"></i>
                    Nega
            </a>
        <?php }else{ ?>
        <a class="btn btn-success" href="?p=presidente.trasferimentoRichiesta&id=<?php echo $_t->id; ?>&si">
                <i class="icon-ok"></i>
                    Protocolla richiesta
        </a>
        <?php } ?>    
        </td>
       
    </tr>
    <?php }
    } ?>
</table>