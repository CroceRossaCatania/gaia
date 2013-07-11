<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
?>

<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
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
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-cogs muted"></i>
            Trasferimenti in attesa
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
        <th>Data di Nascita</th>
        <th>Luogo di Nascita</th>
        <th>Comitato</th>
        <th>Azione</th>
    </thead>
<?php
$comitati= $me->comitatiDiCompetenza();
$t = Trasferimento::filtra([['stato',TRASF_INCORSO]]);
foreach ($t as $_t){
    $v =$_t->volontario();
    $a = Appartenenza::filtra([['volontario',$v],['stato', MEMBRO_VOLONTARIO]]);
    foreach($comitati as $comitato){
        if ($a[0]->comitato()==$comitato){
            $b = Trasferimento::filtra([['volontario',$v],['stato', TRASF_INCORSO]]);
 ?>
    <tr>
        <td><?php echo $v->nome; ?></td>
        <td><?php echo $v->cognome; ?></td>
        <td><?php echo $v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $v->dataNascita); ?></td> 
        <td><?php echo $v->comuneNascita; ?></td>
        <td><?php echo $b[0]->comitato()->nomeCompleto(); ?></td>
        <?php if($_t->protNumero){ ?>
        <td>
            <div class="btn-group">
                <a class="btn btn-success" href="?p=presidente.trasferimento.ok&id=<?php echo $b[0]->id; ?>&si">
                    <i class="icon-ok"></i> Conferma
                </a>
                <a class="btn btn-danger" onClick="return confirm('Vuoi veramente negare il trasferimento a questo utente ?');" href="?p=presidente.trasferimentoNegato&id=<?php echo $b[0]->id; ?>">
                    <i class="icon-ban-circle"></i> Nega
                </a>
            </div>
        <?php }else{ ?>
        <td>   
            <div class="btn-group">
                <a class="btn btn-info" href="?p=presidente.trasferimentoRichiesta.stampa&id=<?php echo $b[0]->id; ?>">
                    <i class="icon-print"></i> Stampa richiesta
                </a>
                <a class="btn btn-success" href="?p=presidente.trasferimentoRichiesta&id=<?php echo $b[0]->id; ?>">
                    <i class="icon-ok"></i> Protocolla richiesta
                </a>
            </div>
        <?php } ?>    
        </td>
       
    </tr>
    <?php }}
    } ?>
</table>